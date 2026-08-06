<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests;

use BVP\Scraper\BatchScraper;
use BVP\Scraper\Caching\CacheFactory;
use BVP\Scraper\Caching\CacheKeyFactory;
use BVP\Scraper\RateLimiting\RateLimiterInterface;
use BVP\Scraper\Retry\RetryPolicy;
use BVP\Scraper\Scraper;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Throwable;

/**
 * Covers the $onError escape hatch on the batch fan-out: one unusable race
 * must be able to cost the caller that race only, not every stadium queued
 * behind it.
 *
 * The stadium index is pre-seeded into the cache so the grid resolves without
 * a network call; every race page below it then comes back broken, which is
 * what a maintenance window or a changed page structure looks like from here.
 *
 * @author shimomo
 */
final class BatchScraperFailureIsolationTest extends TestCase
{
    /**
     * @var non-empty-string
     */
    private const string BROKEN_HTML = '<html><body>ただいまメンテナンス中です</body></html>';

    /**
     * @var list<int<1, 24>>
     */
    private const array STADIUM_NUMBERS = [18, 22];

    /**
     * @var list<int<1, 12>>
     */
    private const array RACE_NUMBERS = [1, 2, 3];

    public function testAbortsTheWholeGridWhenNoHandlerIsGiven(): void
    {
        $batchScraper = $this->makeBatchScraper($requestCount);

        $this->expectException(RuntimeException::class);

        try {
            $batchScraper->scrapeResult($this->date(), self::STADIUM_NUMBERS, self::RACE_NUMBERS);
        } finally {
            $this->assertSame(1, $requestCount, 'The sweep must stop at the first unusable race.');
        }
    }

    public function testKeepsSweepingAndReportsEveryFailureWhenAHandlerIsGiven(): void
    {
        $batchScraper = $this->makeBatchScraper($requestCount);

        /** @var list<array{int, int}> $failures */
        $failures = [];

        $result = $batchScraper->scrapeResult(
            $this->date(),
            self::STADIUM_NUMBERS,
            self::RACE_NUMBERS,
            onError: function (Throwable $throwable, int $stadiumNumber, int $raceNumber) use (&$failures): void {
                $this->assertInstanceOf(RuntimeException::class, $throwable);

                $failures[] = [$stadiumNumber, $raceNumber];
            },
        );

        $this->assertSame([
            [18, 1], [18, 2], [18, 3],
            [22, 1], [22, 2], [22, 3],
        ], $failures);

        $this->assertSame(6, $requestCount, 'Every race in the grid must still be attempted.');
        $this->assertSame([], $result, 'A race that failed must not appear in the result.');
    }

    public function testStadiumResolutionStillThrowsEvenWithAHandler(): void
    {
        // No cache seed this time, so the stadium index itself is the broken
        // page. There is no grid to iterate, so isolation cannot apply.
        $httpBrowser = new HttpBrowser(new MockHttpClient(new MockResponse(self::BROKEN_HTML)));

        $batchScraper = new BatchScraper(new Scraper(
            httpBrowser: $httpBrowser,
            rateLimiter: $this->makeRateLimiter(),
            cache: CacheFactory::createDefault($this->makeCacheDirectory()),
            retryPolicy: new RetryPolicy(maxAttempts: 1, retryDelaySeconds: 0),
        ));

        $this->expectException(RuntimeException::class);

        $batchScraper->scrapeResult(
            $this->date(),
            self::STADIUM_NUMBERS,
            self::RACE_NUMBERS,
            onError: static fn(): null => null,
        );
    }

    /**
     * @param ?int $requestCount
     * @return \BVP\Scraper\BatchScraper
     */
    private function makeBatchScraper(?int &$requestCount): BatchScraper
    {
        $requestCount = 0;

        $mockHttpClient = new MockHttpClient(
            static function () use (&$requestCount): MockResponse {
                $requestCount++;

                return new MockResponse(self::BROKEN_HTML);
            }
        );

        $cache = CacheFactory::createDefault($this->makeCacheDirectory());
        $cache->set(CacheKeyFactory::makeForStadium($this->date()), [18 => '徳山', 22 => '福岡']);

        return new BatchScraper(new Scraper(
            httpBrowser: new HttpBrowser($mockHttpClient),
            rateLimiter: $this->makeRateLimiter(),
            cache: $cache,
            retryPolicy: new RetryPolicy(maxAttempts: 1, retryDelaySeconds: 0),
        ));
    }

    /**
     * @return \Carbon\CarbonImmutable
     */
    private function date(): Carbon
    {
        // Strictly in the past, so DateBasedCachePolicy treats both the
        // stadium index and the races as cacheable.
        return Carbon::parse('2017-03-31');
    }

    /**
     * The default ThrottleRateLimiter has a 1s floor, which would make these
     * tests take as long as the grid is wide. Pacing is not what is under
     * test here.
     *
     * @return \BVP\Scraper\RateLimiting\RateLimiterInterface
     */
    private function makeRateLimiter(): RateLimiterInterface
    {
        return new class implements RateLimiterInterface {
            #[\Override]
            public function throttle(): void
            {
                //
            }
        };
    }

    /**
     * @return non-empty-string
     */
    private function makeCacheDirectory(): string
    {
        return sys_get_temp_dir() . '/bvp-scraper-batch-isolation-test-' . uniqid();
    }
}
