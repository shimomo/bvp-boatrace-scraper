<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use BVP\BoatraceScraper\Scrapers\StadiumScraper;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class StadiumScraperTest extends TestCase
{
    /**
     * @var \BVP\BoatraceScraper\Scrapers\StadiumScraper
     */
    protected StadiumScraper $scraper;

    /**
     * @var array
     */
    protected array $stadiums = [
        4 => '平和島',
        5 => '多摩川',
        6 => '浜名湖',
        10 => '三国',
        15 => '丸亀',
        18 => '徳山',
        23 => '唐津',
        24 => '大村',
    ];

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->scraper = new StadiumScraper(
            new HttpBrowser()
        );
    }

    /**
     * @return void
     */
    public function testScrapeStadiumsWithDate20170331(): void
    {
        $this->assertSame($this->stadiums, $this->scraper->scrape(
            Carbon::parse('2017-03-31')
        ));
    }

    /**
     * @return void
     */
    public function testScrapeStadiumIdsWithDate20170331(): void
    {
        $this->assertSame(array_keys($this->stadiums), $this->scraper->scrapeIds(
            Carbon::parse('2017-03-31')
        ));
    }

    /**
     * @return void
     */
    public function testScrapeStadiumNamesWithDate20170331(): void
    {
        $this->assertSame(array_values($this->stadiums), $this->scraper->scrapeNames(
            Carbon::parse('2017-03-31')
        ));
    }
}
