<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper;

use Illuminate\Support\Collection;

/**
 * @author shimomo
 */
interface ScraperCoreInterface extends ScraperContractInterface
{
    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public function __call(string $name, array $arguments): Collection;
}
