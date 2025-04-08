<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Scrapers;

use BVP\BoatraceScraper\ScraperContractInterface;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
interface StadiumScraperInterface extends ScraperContractInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $raceDate
     * @return array
     */
    public function scrape(CarbonInterface $raceDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $raceDate
     * @return array
     */
    public function scrapeNumbers(CarbonInterface $raceDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $raceDate
     * @return array
     */
    public function scrapeNames(CarbonInterface $raceDate): array;
}
