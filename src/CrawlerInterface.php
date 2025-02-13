<?php

declare(strict_types=1);

namespace BVP\Crawler;

use Illuminate\Support\Collection;

/**
 * @author shimomo
 */
interface CrawlerInterface extends CrawlerContractInterface
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
     * @param  \BVP\Crawler\CrawlerCoreInterface|null  $crawlerCore
     * @return \BVP\Crawler\CrawlerInterface
     */
    public static function getInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface;

    /**
     * @param  \BVP\Crawler\CrawlerCoreInterface|null  $crawlerCore
     * @return \BVP\Crawler\CrawlerInterface
     */
    public static function createInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface;

    /**
     * @return void
     */
    public static function resetInstance(): void;
}
