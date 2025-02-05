<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project;

use Boatrace\Venture\Project\Converter;
use Boatrace\Venture\Project\Crawlers\BaseCrawlerInterface;
use Boatrace\Venture\Project\Crawlers\OddsCrawler;
use Boatrace\Venture\Project\Crawlers\PreviewCrawler;
use Boatrace\Venture\Project\Crawlers\ProgramCrawler;
use Boatrace\Venture\Project\Crawlers\ResultCrawler;
use Boatrace\Venture\Project\Crawlers\StadiumCrawler;
use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class CrawlerCore implements CrawlerCoreInterface
{
    /**
     * @var array
     */
    private array $instances = [];

    /**
     * @var array
     */
    private array $crawlerClasses = [
        'oddses' => OddsCrawler::class,
        'previews' => PreviewCrawler::class,
        'programs' => ProgramCrawler::class,
        'results' => ResultCrawler::class,
        'stadiumIds' => StadiumCrawler::class,
        'stadiumNames' => StadiumCrawler::class,
        'stadiums' => StadiumCrawler::class,
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
        return $this->crawl($name, ...$arguments);
    }

    /**
     * @param  string                          $name
     * @param  \Carbon\CarbonInterface|string  $date
     * @param  string|int|null                 $raceStadiumCode
     * @param  string|int|null                 $raceCode
     * @return \Illuminate\Support\Collection
     */
    private function crawl(string $name, CarbonInterface|string $date, string|int|null $raceStadiumCode = null, string|int|null $raceCode = null): Collection
    {
        $crawler = $this->getCrawlerInstance($name);
        $carbonDate = Carbon::parse($date);

        if (str_starts_with($name, 'stadium')) {
            $methodName = match ($name) {
                'stadiumIds' => 'crawlIds',
                'stadiumNames' => 'crawlNames',
                default => 'crawl',
            };
            $response = $crawler->$methodName($carbonDate);
            return collect($response)->recursive();
        }

        $raceStadiumCodes = $this->getRaceStadiumCodes($carbonDate, $raceStadiumCode);
        $raceCodes = $this->getRaceCodes($raceCode);

        $response = [];
        foreach ($raceStadiumCodes as $raceStadiumCode) {
            foreach ($raceCodes as $raceCode) {
                $response[$raceStadiumCode][$raceCode] = $crawler->crawl(
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
    private function resolveCrawlerClass(string $name): string
    {
        if (isset($this->crawlerClasses[$name])) {
            return $this->crawlerClasses[$name];
        }

        throw new InvalidArgumentException(
            'The crawler name for \'' . $name . '\' is invalid.'
        );
    }

    /**
     * @param  string  $name
     * @return \Boatrace\Venture\Project\CrawlerContractInterface
     */
    private function getCrawlerInstance(string $name): CrawlerContractInterface
    {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        $crawler = $this->resolveCrawlerClass($name);
        return $this->instances[$name] = new $crawler(
            new HttpBrowser()
        );
    }

    /**
     * @param  string  $name
     * @return \Boatrace\Venture\Project\CrawlerContractInterface
     */
    private function createCrawlerInstance(string $name): CrawlerContractInterface
    {
        $crawler = $this->resolveCrawlerClass($name);
        return $this->instances[$name] = new $crawler(
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
            return $this->getCrawlerInstance('stadiums')->crawlIds($carbonDate);
        }

        $formattedRaceStadiumCode = Converter::string($raceStadiumCode);
        if (preg_match('/\b(0?[1-9]|1[0-9]|2[0-4])\b/', $formattedRaceStadiumCode, $matches)) {
            return [(int) $matches[1]];
        }

        throw new InvalidArgumentException(
            'The race stadium code for \'' . $raceStadiumCode . '\' is invalid.'
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
            'The race code for \'' . $raceCode . '\' is invalid.'
        );
    }
}
