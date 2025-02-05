<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project;

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
     * @param  \Boatrace\Venture\Project\CrawlerCoreInterface|null  $crawlerCore
     * @return \Boatrace\Venture\Project\CrawlerInterface
     */
    public static function getInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface;

    /**
     * @param  \Boatrace\Venture\Project\CrawlerCoreInterface|null  $crawlerCore
     * @return \Boatrace\Venture\Project\CrawlerInterface
     */
    public static function createInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface;

    /**
     * @return void
     */
    public static function resetInstance(): void;
}
