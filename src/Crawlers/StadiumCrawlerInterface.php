<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Crawlers;

use Boatrace\Venture\Project\CrawlerContractInterface;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
interface StadiumCrawlerInterface extends CrawlerContractInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function crawlIds(CarbonInterface $carbonDate): array;

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function crawlNames(CarbonInterface $carbonDate): array;
}
