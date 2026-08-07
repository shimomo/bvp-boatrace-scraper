<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Smoke;

use BVP\Scraper\Caching\CacheFactory;
use BVP\Scraper\Factories\HttpBrowserFactory;
use BVP\Scraper\Scraper;
use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Throwable;

/**
 * The only test that talks to boatrace.jp. The rest of the suite reads frozen
 * bytes from tests/fixtures, which proves the parsing has not regressed but
 * says nothing about the site having moved underneath it — and a scraper that
 * quietly returns nulls after a redesign is the failure this package exists to
 * avoid. This test exists to catch that, so it is deliberately not part of the
 * default suite: it is excluded from the `Boatrace Vibe Project` testsuite in
 * phpunit.xml.dist and run on its own with `--testsuite=Smoke`, nightly.
 *
 * It asks for yesterday's races, so every page it reads is final. Rather than
 * pin a stadium, it walks the day's open stadiums until one 1R comes back
 * whole, because a single stadium can always have been cancelled for weather.
 * Only when no stadium yields a whole race does it fail, and it then reports
 * what was missing at each one — a genuine site change fails every stadium the
 * same way, which is what separates it from a cancelled meeting.
 *
 * @author shimomo
 */
final class LiveSiteSmokeTest extends TestCase
{
    /**
     * Enough stadiums to ride out a cancelled meeting or two, few enough to
     * keep the run inside a minute at one request per second.
     *
     * @var int
     */
    private const int MAX_STADIUMS = 3;

    /**
     * @psalm-return void
     *
     * @return void
     */
    public function testYesterdaysRaceStillReadsWhole(): void
    {
        // A cache would defeat the point: the second run of the day would pass
        // on yesterday's bytes without ever asking the site. Every run gets a
        // cache of its own, so every run is a live read.
        $scraper = new Scraper(
            httpBrowser: HttpBrowserFactory::create(httpClient: HttpClient::create([
                'timeout' => 15.0,
                'max_duration' => 30.0,
            ])),
            cache: CacheFactory::createDefault(
                sys_get_temp_dir() . '/bvp-scraper-smoke-' . uniqid()
            ),
        );

        $date = Carbon::now('Asia/Tokyo')->subDay();
        $stadiums = $scraper->scrapeStadium($date);

        $this->assertNotSame(
            [],
            $stadiums,
            sprintf('No stadium was listed as open on %s.', $date->format('Y-m-d')),
        );

        $report = [];

        foreach (array_slice(array_keys($stadiums), 0, self::MAX_STADIUMS) as $stadiumNumber) {
            $problems = $this->findProblems($scraper, $date, $stadiumNumber);

            if ($problems === []) {
                $this->assertTrue(true);

                return;
            }

            $report[] = sprintf(
                '%s (%d): %s',
                $stadiums[$stadiumNumber],
                $stadiumNumber,
                implode('; ', $problems),
            );
        }

        $this->fail(sprintf(
            "No stadium returned a whole 1R for %s, which points at boatrace.jp having changed.\n%s",
            $date->format('Y-m-d'),
            implode("\n", $report),
        ));
    }

    /**
     * Reads one race off all four page families and reports what came back
     * missing. A cancelled meeting and a redesigned page both land here; what
     * tells them apart is whether every stadium reports the same thing.
     *
     * @psalm-return list<non-empty-string>
     *
     * @param \BVP\Scraper\Scraper $scraper
     * @param \Carbon\CarbonInterface $date
     * @param int<1, 24> $stadiumNumber
     * @return array
     */
    private function findProblems(Scraper $scraper, CarbonInterface $date, int $stadiumNumber): array
    {
        try {
            $program = $scraper->scrapeProgram($date, $stadiumNumber, 1);
            $preview = $scraper->scrapePreview($date, $stadiumNumber, 1);
            $result = $scraper->scrapeResult($date, $stadiumNumber, 1);
            $odds = $scraper->scrapeOdds($date, $stadiumNumber, 1);
        } catch (Throwable $throwable) {
            return [sprintf('%s: %s', $throwable::class, $throwable->getMessage())];
        }

        $problems = [];

        if (!is_string($program['title'] ?? null)) {
            $problems[] = 'the program has no title';
        }

        if (!is_string($program['closed_at'] ?? null)) {
            $problems[] = 'the program has no closing time';
        }

        if (!$this->everyRacerHas($program, 'name') || !$this->everyRacerHas($program, 'national_win_rate')) {
            $problems[] = 'the program is missing a racer name or win rate';
        }

        if (!$this->everyRacerHas($preview, 'exhibition_time')) {
            $problems[] = 'the preview is missing an exhibition time';
        }

        if (!is_int($result['wind_speed'] ?? null) || !is_int($result['weather_number'] ?? null)) {
            $problems[] = 'the result has no wind speed or weather';
        }

        if (!$this->everyRacerHas($result, 'place_number')) {
            $problems[] = 'the result is missing a finishing place';
        }

        if (!$this->hasATrifectaPayout($result)) {
            $problems[] = 'the result has no trifecta payout';
        }

        if (!is_float($odds['win'][1] ?? null) && !is_int($odds['win'][1] ?? null)) {
            $problems[] = 'the odds have no win odds for boat 1';
        }

        return $problems;
    }

    /**
     * @psalm-return bool
     *
     * @param array<non-empty-string, mixed> $response
     * @param non-empty-string $key
     * @return bool
     */
    private function everyRacerHas(array $response, string $key): bool
    {
        $racers = $response['racers'] ?? null;

        if (!is_array($racers) || count($racers) !== 6) {
            return false;
        }

        foreach ($racers as $racer) {
            if (!is_array($racer) || ($racer[$key] ?? null) === null) {
                return false;
            }
        }

        return true;
    }

    /**
     * A finished race always pays a trifecta, unless it was voided — in which
     * case the row is still there, carrying the printed wording instead of a
     * combination.
     *
     * @psalm-return bool
     *
     * @param array<non-empty-string, mixed> $response
     * @return bool
     */
    private function hasATrifectaPayout(array $response): bool
    {
        $payouts = $response['payouts'] ?? null;

        if (!is_array($payouts) || !is_array($payouts['trifecta'] ?? null)) {
            return false;
        }

        foreach ($payouts['trifecta'] as $row) {
            if (!is_array($row)) {
                continue;
            }

            if (is_string($row['combination'] ?? null) || is_string($row['label'] ?? null)) {
                return true;
            }
        }

        return false;
    }
}
