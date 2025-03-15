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
use Illuminate\Support\Collection;
use InvalidArgumentException;
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
        'oddses' => OddsScraper::class,
        'previews' => PreviewScraper::class,
        'programs' => ProgramScraper::class,
        'results' => ResultScraper::class,
        'stadiumIds' => StadiumScraper::class,
        'stadiumNames' => StadiumScraper::class,
        'stadiums' => StadiumScraper::class,
    ];

    /**
     * @return void
     */
    public function __construct()
    {
        Collection::macro('recursive', fn() => $this->map(
            fn($value) => is_array($value) || is_object($value)
                ? collect($value)->recursive()
                : $value
        ));
    }

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public function __call(string $name, array $arguments): Collection
    {
        return $this->scraper($name, ...$arguments);
    }

    /**
     * @param  string                          $name
     * @param  \Carbon\CarbonInterface|string  $date
     * @param  string|int|null                 $raceStadiumCode
     * @param  string|int|null                 $raceCode
     * @return \Illuminate\Support\Collection
     */
    private function scraper(string $name, CarbonInterface|string $date, string|int|null $raceStadiumCode = null, string|int|null $raceCode = null): Collection
    {
        $scraper = $this->getScraperInstance($name);
        $carbonDate = Carbon::parse($date);

        if (str_starts_with($name, 'stadium')) {
            $methodName = match ($name) {
                'stadiumIds' => 'scrapeIds',
                'stadiumNames' => 'scrapeNames',
                default => 'scrape',
            };
            $response = $scraper->$methodName($carbonDate);
            return collect($response)->recursive();
        }

        $raceStadiumCodes = $this->getRaceStadiumCodes($carbonDate, $raceStadiumCode);
        $raceCodes = $this->getRaceCodes($raceCode);

        $response = [];
        foreach ($raceStadiumCodes as $raceStadiumCode) {
            foreach ($raceCodes as $raceCode) {
                $response[$raceStadiumCode][$raceCode] = $scraper->scrape(
                    $carbonDate,
                    $raceStadiumCode,
                    $raceCode
                );
            }
        }

        return collect($response)->recursive();
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

        throw new InvalidArgumentException(
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
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  string|int|null          $raceStadiumCode
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function getRaceStadiumCodes(CarbonInterface $carbonDate, string|int|null $raceStadiumCode): array
    {
        if (is_null($raceStadiumCode)) {
            return $this->getScraperInstance('stadiums')->scrapeIds($carbonDate);
        }

        $formattedRaceStadiumCode = Converter::string($raceStadiumCode);
        if (preg_match('/\b(0?[1-9]|1[0-9]|2[0-4])\b/', $formattedRaceStadiumCode, $matches)) {
            return [(int) $matches[1]];
        }

        throw new InvalidArgumentException(
            __METHOD__ . "The race stadium code for '{$raceStadiumCode}' is invalid."
        );
    }

    /**
     * @param  string|int|null  $raceCode
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function getRaceCodes(string|int|null $raceCode): array
    {
        if (is_null($raceCode)) {
            return range(1, 12);
        }

        $formattedRaceCode = Converter::string($raceCode);
        if (preg_match('/\b(0?[1-9]|1[0-2])\b/', $formattedRaceCode, $matches)) {
            return [(int) $matches[1]];
        }

        throw new InvalidArgumentException(
            __METHOD__ . "() - The race code for '{$raceCode}' is invalid."
        );
    }
}
