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
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrape(CarbonInterface $carbonDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrapeIds(CarbonInterface $carbonDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrapeNames(CarbonInterface $carbonDate): array;
}
