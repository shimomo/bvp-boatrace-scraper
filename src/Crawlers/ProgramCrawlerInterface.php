<?php

declare(strict_types=1);

namespace BVP\Crawler\Crawlers;

use BVP\Crawler\CrawlerContractInterface;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
interface ProgramCrawlerInterface extends CrawlerContractInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  int                      $raceStadiumCode
     * @param  int                      $raceCode
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate, int $raceStadiumCode, int $raceCode): array;
}
