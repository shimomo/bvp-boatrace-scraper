<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Tests\Crawlers;

use Boatrace\Venture\Project\Crawlers\StadiumCrawler;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class StadiumCrawlerTest extends TestCase
{
    /**
     * @var \Boatrace\Venture\Project\Crawlers\StadiumCrawler
     */
    protected StadiumCrawler $crawler;

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
        $this->crawler = new StadiumCrawler(
            new HttpBrowser()
        );
    }

    /**
     * @return void
     */
    public function testCrawlStadiumsWithDate20170331(): void
    {
        $this->assertSame($this->stadiums, $this->crawler->crawl(
            Carbon::parse('2017-03-31')
        ));
    }

    /**
     * @return void
     */
    public function testCrawlStadiumIdsWithDate20170331(): void
    {
        $this->assertSame(array_keys($this->stadiums), $this->crawler->crawlIds(
            Carbon::parse('2017-03-31')
        ));
    }

    /**
     * @return void
     */
    public function testCrawlStadiumNamesWithDate20170331(): void
    {
        $this->assertSame(array_values($this->stadiums), $this->crawler->crawlNames(
            Carbon::parse('2017-03-31')
        ));
    }
}
