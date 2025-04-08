<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use BVP\BoatraceScraper\Scrapers\OddsScraper;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
final class OddsScraperTest extends TestCase
{
    /**
     * @var \BVP\BoatraceScraper\Scrapers\OddsScraper
     */
    protected OddsScraper $scraper;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->scraper = new OddsScraper(
            new HttpBrowser()
        );
    }

    /**
     * @param  array  $arguments
     * @param  array  $expected
     * @return void
     */
    #[DataProviderExternal(OddsScraperDataProvider::class, 'scrapeProvider')]
    public function testScrape(array $arguments, array $expected): void
    {
        $this->assertSame($expected, $this->scraper->scrape(...$arguments));
    }
}
