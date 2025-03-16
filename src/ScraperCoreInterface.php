<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper;

/**
 * @author shimomo
 */
interface ScraperCoreInterface extends ScraperContractInterface
{
    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return array
     */
    public function __call(string $name, array $arguments): array;
}
