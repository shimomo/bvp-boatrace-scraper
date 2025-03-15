<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper;

use Illuminate\Support\Collection;

/**
 * @author shimomo
 */
interface ScraperInterface extends ScraperContractInterface
{
    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public function __call(string $name, array $arguments): Collection;

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public static function __callStatic(string $name, array $arguments): Collection;

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
