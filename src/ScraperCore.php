<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper;

use BVP\Converter\Converter;
use BVP\BoatraceScraper\Scrapers\BaseScraperInterface;
use BVP\BoatraceScraper\Scrapers\OddsScraper;
use BVP\BoatraceScraper\Scrapers\PreviewScraper;
use BVP\BoatraceScraper\Scrapers\ProgramScraper;
use BVP\BoatraceScraper\Scrapers\ResultScraper;
use BVP\BoatraceScraper\Scrapers\StadiumScraper;
use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class ScraperCore implements ScraperCoreInterface
{
    /**
     * @var array
     */
    private array $instances = [];

    /**
     * @var array
     */
    private array $scraperClasses = [
        'scrapeOddses' => OddsScraper::class,
        'scrapePreviews' => PreviewScraper::class,
        'scrapePrograms' => ProgramScraper::class,
        'scrapeResults' => ResultScraper::class,
        'scrapeStadiumIds' => StadiumScraper::class,
        'scrapeStadiumNames' => StadiumScraper::class,
        'scrapeStadiums' => StadiumScraper::class,
    ];

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function __call(string $name, array $arguments): array
    {
        $countArguments = count($arguments);
        if ($countArguments >= 4) {
            throw new \InvalidArgumentException(
                __METHOD__ . "() - Too many arguments to function " . self::class . "::{$name}(), " .
                "{$countArguments} passed and exactly 1-3 expected."
            );
        }

        return $this->scraper($name, ...$arguments);
    }

    /**
     * @param  string                          $name
     * @param  \Carbon\CarbonInterface|string  $date
     * @param  string|int|null                 $raceStadiumNumber
     * @param  string|int|null                 $raceNumber
     * @return array
     */
    private function scraper(string $name, CarbonInterface|string $date, string|int|null $raceStadiumNumber = null, string|int|null $raceNumber = null): array
    {
        $scraper = $this->getScraperInstance($name);
        $raceDate = Carbon::parse($date);

        if (str_starts_with($name, 'scrapeStadium')) {
            $methodName = match ($name) {
                'scrapeStadiumIds' => 'scrapeIds',
                'scrapeStadiumNames' => 'scrapeNames',
                default => 'scrape',
            };
            $response = $scraper->$methodName($raceDate);
            return $response;
        }

        $raceStadiumNumbers = $this->getRaceStadiumNumbers($raceDate, $raceStadiumNumber);
        $raceNumbers = $this->getRaceNumbers($raceNumber);

        $response = [];
        foreach ($raceStadiumNumbers as $raceStadiumNumber) {
            foreach ($raceNumbers as $raceNumber) {
                $response[$raceStadiumNumber][$raceNumber] = $scraper->scrape(
                    $raceDate,
                    $raceStadiumNumber,
                    $raceNumber
                );
            }
        }

        return $response;
    }

    /**
     * @param  string  $name
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    private function resolveScraperClass(string $name): string
    {
        if (isset($this->scraperClasses[$name])) {
            return $this->scraperClasses[$name];
        }

        throw new \InvalidArgumentException(
            __METHOD__ . "The scraper name for '{$name}' is invalid."
        );
    }

    /**
     * @param  string  $name
     * @return \BVP\BoatraceScraper\ScraperContractInterface
     */
    private function getScraperInstance(string $name): ScraperContractInterface
    {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        $scraper = $this->resolveScraperClass($name);
        return $this->instances[$name] = new $scraper(
            new HttpBrowser()
        );
    }

    /**
     * @param  string  $name
     * @return \BVP\BoatraceScraper\ScraperContractInterface
     */
    private function createScraperInstance(string $name): ScraperContractInterface
    {
        $scraper = $this->resolveScraperClass($name);
        return $this->instances[$name] = new $scraper(
            new HttpBrowser()
        );
    }

    /**
     * @param  \Carbon\CarbonInterface  $raceDate
     * @param  string|int|null          $raceStadiumNumber
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function getRaceStadiumNumbers(CarbonInterface $raceDate, string|int|null $raceStadiumNumber): array
    {
        if (is_null($raceStadiumNumber)) {
            return $this->getScraperInstance('scrapeStadiums')->scrapeIds($raceDate);
        }

        $formattedRaceStadiumNumber = Converter::convertToString($raceStadiumNumber);
        if (preg_match('/\b(0?[1-9]|1[0-9]|2[0-4])\b/', $formattedRaceStadiumNumber, $matches)) {
            return [(int) $matches[1]];
        }

        throw new \InvalidArgumentException(
            __METHOD__ . "The race stadium code for '{$raceStadiumNumber}' is invalid."
        );
    }

    /**
     * @param  string|int|null  $raceNumber
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function getRaceNumbers(string|int|null $raceNumber): array
    {
        if (is_null($raceNumber)) {
            return range(1, 12);
        }

        $formattedRaceCode = Converter::convertToString($raceNumber);
        if (preg_match('/\b(0?[1-9]|1[0-2])\b/', $formattedRaceCode, $matches)) {
            return [(int) $matches[1]];
        }

        throw new \InvalidArgumentException(
            __METHOD__ . "() - The race code for '{$raceNumber}' is invalid."
        );
    }
}
