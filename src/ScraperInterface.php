<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper;

/**
 * @author shimomo
 */
interface ScraperInterface extends ScraperContractInterface
{
    /**
     * @param  \BVP\BoatraceScraper\ScraperCoreInterface|null  $scraperCore
     * @return \BVP\BoatraceScraper\ScraperInterface
     */
    public static function getInstance(?ScraperCoreInterface $scraperCore = null): ScraperInterface;

    /**
     * @param  \BVP\BoatraceScraper\ScraperCoreInterface|null  $scraperCore
     * @return \BVP\BoatraceScraper\ScraperInterface
     */
    public static function createInstance(?ScraperCoreInterface $scraperCore = null): ScraperInterface;

    /**
     * @return void
     */
    public static function resetInstance(): void;
}
