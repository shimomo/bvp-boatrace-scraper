<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Scrapers;

use BVP\Scraper\Scrapers\StadiumScraper;
use BVP\Scraper\Tests\MockBrowser;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-import-type RaceDate from \BVP\Scraper\Tests\ScraperPsalmType
 * @psalm-import-type RaceStadiumNumber from \BVP\Scraper\Tests\ScraperPsalmType
 *
 * @author shimomo
 */
final class StadiumScraperTest extends TestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @psalm-var \BVP\Scraper\Scrapers\StadiumScraper
     *
     * @var \BVP\Scraper\Scrapers\StadiumScraper
     */
    protected StadiumScraper $scraper;

    /**
     * @psalm-return void
     *
     * @return void
     */
    #[\Override]
    protected function setUp(): void
    {
        $this->scraper = new StadiumScraper(
            MockBrowser::create()
        );
    }

    /**
     * @psalm-param array{RaceDate} $arguments
     * @psalm-param array<RaceStadiumNumber, non-empty-string> $expected
     * @psalm-return void
     *
     * @param array $arguments
     * @param array $expected
     * @return void
     */
    #[DataProviderExternal(StadiumScraperDataProvider::class, 'scrapeStadiumsProvider')]
    public function testScrapeStadiums(array $arguments, array $expected): void
    {
        $this->assertSame($expected, $this->scraper->scrape(...$arguments));
    }

    /**
     * A name the enum does not know is dropped on its own. Every batch method
     * reads this list before anything else, so letting it take the list down
     * would stop the whole run.
     *
     * The fixture is the 2017-03-31 page with the alt of the 平和島 banner
     * replaced by a name that is not a stadium.
     *
     * @psalm-return void
     *
     * @return void
     */
    public function testScrapeDropsAStadiumItCannotRecognise(): void
    {
        $scraper = new StadiumScraper(
            MockBrowser::create('index-unknown-stadium.html')
        );

        $stadiums = $scraper->scrape(Carbon::parse('2017-03-31'));

        $this->assertArrayNotHasKey(4, $stadiums);
        $this->assertCount(7, $stadiums);
        $this->assertSame('多摩川', $stadiums[5]);
        $this->assertSame('大村', $stadiums[24]);
    }
}
