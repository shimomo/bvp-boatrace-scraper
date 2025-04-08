<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests;

use BVP\BoatraceScraper\Scraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class ScraperTest extends TestCase
{
    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeOddsesProvider')]
    public function testScrapeOddses(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeOddses(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapePreviewsProvider')]
    public function testScrapePreviews(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapePreviews(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeProgramsProvider')]
    public function testScrapePrograms(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapePrograms(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeResultsProvider')]
    public function testScrapeResults(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeResults(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeStadiumsProvider')]
    public function testScrapeStadiums(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeStadiums(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeStadiumNumbersProvider')]
    public function testScrapeStadiumNumbers(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeStadiumIds(...$arguments));
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(ScraperCoreDataProvider::class, 'scrapeStadiumNamesProvider')]
    public function testScrapeStadiumNames(array $arguments, array $expected): void
    {
        $this->assertSame($expected, Scraper::scrapeStadiumNames(...$arguments));
    }
}
