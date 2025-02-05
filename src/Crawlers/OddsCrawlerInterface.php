<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Crawlers;

use Boatrace\Venture\Project\CrawlerContractInterface;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
interface OddsCrawlerInterface extends CrawlerContractInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  int                      $raceStadiumCode
     * @param  int                      $raceCode
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate, int $raceStadiumCode, int $raceCode): array;
}
