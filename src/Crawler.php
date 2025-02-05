<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project;

use Illuminate\Support\Collection;

/**
 * @author shimomo
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var \Boatrace\Venture\Project\CrawlerInterface
     */
    private static ?CrawlerInterface $instance;

    /**
     * @param  \Boatrace\Venture\Project\CrawlerCoreInterface  $crawler
     * @return void
     */
    public function __construct(private readonly CrawlerCoreInterface $crawler) {}

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public function __call(string $name, array $arguments): Collection
    {
        return $this->crawler->$name(...$arguments);
    }

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return \Illuminate\Support\Collection
     */
    public static function __callStatic(string $name, array $arguments): Collection
    {
        return self::getInstance()->$name(...$arguments);
    }

    /**
     * @param  \Boatrace\Venture\Project\CrawlerCoreInterface|null  $crawlerCore
     * @return \Boatrace\Venture\Project\CrawlerInterface
     */
    public static function getInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface
    {
        return self::$instance ??= new self($crawlerCore ?? new CrawlerCore());
    }

    /**
     * @param  \Boatrace\Venture\Project\CrawlerCoreInterface|null  $crawlerCore
     * @return \Boatrace\Venture\Project\CrawlerInterface
     */
    public static function createInstance(?CrawlerCoreInterface $crawlerCore = null): CrawlerInterface
    {
        return self::$instance = new self($crawlerCore ?? new CrawlerCore());
    }

    /**
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
