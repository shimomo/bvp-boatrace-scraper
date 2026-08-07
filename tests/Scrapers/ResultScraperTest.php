<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Scrapers;

use BVP\Scraper\Scrapers\ResultScraper;
use BVP\Scraper\Tests\MockBrowser;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-import-type RaceArguments from \BVP\Scraper\Tests\ScraperPsalmType
 * @psalm-import-type RaceExpected from \BVP\Scraper\Tests\ScraperPsalmType
 *
 * @author shimomo
 */
final class ResultScraperTest extends TestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @psalm-var \BVP\Scraper\Scrapers\ResultScraper
     *
     * @var \BVP\Scraper\Scrapers\ResultScraper
     */
    protected ResultScraper $scraper;

    /**
     * @psalm-return void
     *
     * @return void
     */
    #[\Override]
    protected function setUp(): void
    {
        $this->scraper = new ResultScraper(
            MockBrowser::create()
        );
    }

    /**
     * @psalm-param RaceArguments $arguments
     * @psalm-param RaceExpected $expected
     * @psalm-return void
     *
     * @param array $arguments
     * @param array $expected
     * @return void
     */
    #[DataProviderExternal(ResultScraperDataProvider::class, 'scrapeProvider')]
    public function testScrape(array $arguments, array $expected): void
    {
        $this->assertSame($expected, $this->scraper->scrape(...$arguments));
    }

    /**
     * A row whose combination reads but whose amount does not is kept, with the
     * amount reported as missing. Dropping the row would take the only sign that
     * the page has moved with it.
     *
     * The fixture is the 2026-05-31 24R 12R page with the amount of the trifecta
     * blanked out; every other row is untouched.
     *
     * @psalm-return void
     *
     * @return void
     */
    public function testScrapeKeepsAPayoutRowWhoseAmountCannotBeRead(): void
    {
        $scraper = new ResultScraper(
            MockBrowser::create('raceresult-missing-amount.html')
        );

        $response = $scraper->scrape(Carbon::parse('2026-05-31'), 6, 12);

        $this->assertIsArray($response['payouts']);
        $this->assertSame(
            [['combination' => '1-5-4', 'amount' => null, 'label' => null]],
            $response['payouts']['trifecta']
        );
        $this->assertSame(
            [['combination' => '1=4=5', 'amount' => 1550, 'label' => null]],
            $response['payouts']['trio']
        );
    }
}
