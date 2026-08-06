<?php

declare(strict_types=1);

namespace BVP\Scraper\Scrapers;

use BVP\Scraper\Contracts\Scraper;
use BVP\Scraper\Filters\Filter;
use BVP\Scraper\Filters\WindDirectionFilter;
use BVP\Scraper\Parsers\Parser;
use BVP\Scraper\Parsers\PreviewParser;
use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
final class PreviewScraper extends BaseScraper implements Scraper
{
    /**
     * Every key a racer entry carries, in the order the two passes below fill
     * them in. Used to shape all six entries, so that a boat the page does not
     * print still comes back with the full set of keys rather than being left
     * out.
     *
     * @var non-empty-list<non-empty-string>
     */
    private const array RACER_KEYS = [
        'entry_number',
        'course_number',
        'start_timing_source',
        'start_timing',
        'weight_source',
        'weight',
        'weight_adjustment_source',
        'weight_adjustment',
        'exhibition_time_source',
        'exhibition_time',
        'tilt_adjustment_source',
        'tilt_adjustment',
        'propeller',
        'parts',
    ];

    /**
     * @var int<0, 1>
     */
    private int $baseLevel = 0;

    /**
     * @param \Carbon\CarbonInterface $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @return array<non-empty-string, mixed>
     */
    #[\Override]
    public function scrape(CarbonInterface $date, int $stadiumNumber, int $raceNumber): array
    {
        $scraperFormat = '%s/owpc/pc/race/beforeinfo?hd=%s&jcd=%02d&rno=%d';
        $scraperUrl = sprintf($scraperFormat, $this->baseUrl, $date->format('Ymd'), $stadiumNumber, $raceNumber);
        $scraper = $this->requestAndAssertPage('GET', $scraperUrl);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (Filter::byXPath($scraper, $levelXPath) !== null) {
            $this->baseLevel = 1;
        }

        $windSpeedFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[3]/div/span[2]';
        $windSpeedXPath = sprintf($windSpeedFormat, $this->baseXPath, $this->baseLevel + 5);
        $windSpeed = PreviewParser::parseWindSpeed(Filter::byXPath($scraper, $windSpeedXPath));

        $windDirectionFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[4]/p';
        $windDirectionXPath = sprintf($windDirectionFormat, $this->baseXPath, $this->baseLevel + 5);
        $windDirection = PreviewParser::parseWindDirection(WindDirectionFilter::byXPath($scraper, $windDirectionXPath));

        $waveHeightFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[6]/div/span[2]';
        $waveHeightXPath = sprintf($waveHeightFormat, $this->baseXPath, $this->baseLevel + 5);
        $waveHeight = PreviewParser::parseWaveHeight(Filter::byXPath($scraper, $waveHeightXPath));

        $weatherFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[2]/div/span';
        $weatherXPath = sprintf($weatherFormat, $this->baseXPath, $this->baseLevel + 5);
        $weather = PreviewParser::parseWeather(Filter::byXPath($scraper, $weatherXPath));

        $airTemperatureFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[1]/div/span[2]';
        $airTemperatureXPath = sprintf($airTemperatureFormat, $this->baseXPath, $this->baseLevel + 5);
        $airTemperature = PreviewParser::parseAirTemperature(Filter::byXPath($scraper, $airTemperatureXPath));

        $waterTemperatureFormat = '%s/div[2]/div[%d]/div[2]/div[2]/div[1]/div[5]/div/span[2]';
        $waterTemperatureXPath = sprintf($waterTemperatureFormat, $this->baseXPath, $this->baseLevel + 5);
        $waterTemperature = PreviewParser::parseWaterTemperature(Filter::byXPath($scraper, $waterTemperatureXPath));

        $response = [];

        $response['date'] = $date->format('Y-m-d');
        $response['stadium_number'] = $stadiumNumber;
        $response['race_number'] = $raceNumber;

        $response += $windSpeed;
        $response += $windDirection;
        $response += $waveHeight;
        $response += $weather;
        $response += $airTemperature;
        $response += $waterTemperature;

        $response += $this->scrapeRacers($scraper);

        return $response;
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @return array<non-empty-string, mixed>
     */
    private function scrapeRacers(Crawler $scraper): array
    {
        $racers = $this->scrapePreviewTable($scraper);

        $template = array_fill_keys(self::RACER_KEYS, null);

        $response = ['racers' => []];

        foreach (range(1, 6) as $entryNumberKey) {
            $response['racers'][$entryNumberKey] = array_replace($template, [
                'entry_number' => $entryNumberKey,
            ], $racers[$entryNumberKey] ?? []);
        }

        return $response;
    }

    /**
     * The page splits a boat across two tables. The start display is ordered by
     * course, so a boat's course is the row it stands in rather than anything
     * printed; the table above it is ordered by entry number and carries the
     * exhibition run. Both are read into the same boat.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @return array<int, array<non-empty-string, mixed>>
     */
    private function scrapePreviewTable(Crawler $scraper): array
    {
        $response = [];

        foreach (range(1, 6) as $index) {
            $entryNumberFormat = '%s/div[2]/div[%d]/div[2]/div[1]/table/tbody/tr[%s]/td/div/span[1]';
            $entryNumberXPath = sprintf($entryNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $entryNumber = Parser::parseEntryNumber(Filter::byXPath($scraper, $entryNumberXPath));

            $course = ['course_number' => $index];

            $startTimingFormat = '%s/div[2]/div[%d]/div[2]/div[1]/table/tbody/tr[%s]/td/div/span[3]';
            $startTimingXPath = sprintf($startTimingFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $startTiming = PreviewParser::parseStartTiming(Filter::byXPath($scraper, $startTimingXPath));

            if (!isset($entryNumber['entry_number'])) {
                $entryNumber['entry_number'] = $index;
                $course['course_number'] = null;
            }

            $entryNumberKey = $entryNumber['entry_number'];

            if (!in_array($entryNumberKey, range(1, 6), true)) {
                continue;
            }

            $response[$entryNumberKey] ??= [];
            $response[$entryNumberKey] += $entryNumber;
            $response[$entryNumberKey] += $course;
            $response[$entryNumberKey] += $startTiming;
        }

        foreach (range(1, 6) as $index) {
            $entryNumberFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[1]';
            $entryNumberXPath = sprintf($entryNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $entryNumber = Parser::parseEntryNumber(Filter::byXPath($scraper, $entryNumberXPath));

            $weightFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[4]';
            $weightXPath = sprintf($weightFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $weight = PreviewParser::parseWeight(Filter::byXPath($scraper, $weightXPath));

            $weightAdjustmentFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[3]/td[1]';
            $weightAdjustmentXPath = sprintf($weightAdjustmentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $weightAdjustment = PreviewParser::parseWeightAdjustment(Filter::byXPath($scraper, $weightAdjustmentXPath));

            $exhibitionTimeFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[5]';
            $exhibitionTimeXPath = sprintf($exhibitionTimeFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $exhibitionTime = PreviewParser::parseExhibitionTime(Filter::byXPath($scraper, $exhibitionTimeXPath));

            $tiltAdjustmentFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[6]';
            $tiltAdjustmentXPath = sprintf($tiltAdjustmentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $tiltAdjustment = PreviewParser::parseTiltAdjustment(Filter::byXPath($scraper, $tiltAdjustmentXPath));

            $propellerFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[7]';
            $propellerXPath = sprintf($propellerFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $propeller = PreviewParser::parsePropeller(Filter::byXPath($scraper, $propellerXPath));

            // Look for the cell itself before counting the li, so that a missing
            // cell stays apart from a cell holding no exchange.
            $partsFormat = '%s/div[2]/div[%d]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[8]';
            $partsXPath = sprintf($partsFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $partsSource = Filter::byXPath($scraper, $partsXPath) === null
                ? null
                : Filter::byXPathAsList($scraper, $partsXPath . '/ul/li');
            $parts = PreviewParser::parseParts($partsSource);

            if (!isset($entryNumber['entry_number'])) {
                $entryNumber['entry_number'] = $index;
            }

            $entryNumberKey = $entryNumber['entry_number'];

            if (!in_array($entryNumberKey, range(1, 6), true)) {
                continue;
            }

            $response[$entryNumberKey] ??= [];
            $response[$entryNumberKey] += $entryNumber;
            $response[$entryNumberKey] += $weight;
            $response[$entryNumberKey] += $weightAdjustment;
            $response[$entryNumberKey] += $exhibitionTime;
            $response[$entryNumberKey] += $tiltAdjustment;
            $response[$entryNumberKey] += $propeller;
            $response[$entryNumberKey] += $parts;
        }

        return $response;
    }
}
