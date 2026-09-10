<?php

declare(strict_types=1);

namespace BVP\Scraper\Caching;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * @author shimomo
 */
final class CacheFactory
{
    /**
     * The namespace carries the schema version of the scraped payload, so that
     * a release which changes the shape of a response leaves its old entries
     * unreachable instead of serving them alongside the new shape. Past dates
     * are cached permanently, so without this a backfill would keep replaying
     * whatever shape happened to be current when it was first run.
     *
     * Bump the version whenever the keys or the value semantics of a scrape
     * response change.
     *
     * @var non-empty-string
     */
    private const string NAMESPACE = 'bvp-scraper.v5';

    /**
     * Builds the default cache backend: a filesystem-backed PSR-16 cache
     * that survives across process runs (unlike an in-memory cache), which
     * matters for backfill workloads that re-run the same date range over
     * multiple invocations.
     *
     * @param ?non-empty-string $directory
     * @return \Psr\SimpleCache\CacheInterface
     */
    public static function createDefault(?string $directory = null): CacheInterface
    {
        return new Psr16Cache(
            new FilesystemAdapter(self::NAMESPACE, 0, $directory)
        );
    }
}
