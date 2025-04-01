<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Scrapers;

use BVP\BoatraceScraper\ScraperContractInterface;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
interface OddsScraperInterface extends ScraperContractInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  int                      $raceStadiumNumber
     * @param  int                      $raceNumber
     * @return array
     */
    public function scrape(CarbonInterface $carbonDate, int $raceStadiumNumber, int $raceNumber): array;
}
