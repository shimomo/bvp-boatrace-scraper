<?php

declare(strict_types=1);

namespace BVP\Crawler;

use Illuminate\Support\Collection;

/**
 * @author shimomo
 */
interface CrawlerCoreInterface extends CrawlerContractInterface
{
    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public function __call(string $name, array $arguments): Collection;
}
