<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests;

use BVP\Scraper\Scraper;
use BVP\Scraper\Tests\Scrapers\OddsScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\PreviewScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\ProgramScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\ResultScraperDataProvider;
use PHPUnit\Framework\TestCase;
use ValueError;

/**
 * Exercises the instance-based Scraper facade itself (validation, plus the
 * deprecated scrape*Bulk() shims still delegating to BatchScraper). Fan-out
 * itself is covered by BatchScraperTest, and per-field scraping correctness
 * by tests/Scrapers/*Test.php against the underlying scraper classes
 * directly; these tests reuse those already-verified fixtures rather than
 * re-deriving them, wrapped in the [stadiumNumber => [raceNumber => ...]]
 * bulk shape.
 *
 * @author shimomo
 */
final class ScraperTest extends TestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private Scraper $scraper;

    #[\Override]
    protected function setUp(): void
    {
        $this->scraper = new Scraper();
    }

    public function testDeprecatedScrapeResultBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = ResultScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = ResultScraperDataProvider::scrapeProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapeResultBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapeProgramBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = ProgramScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = ProgramScraperDataProvider::scrapeProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapeProgramBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapePreviewBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = PreviewScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = PreviewScraperDataProvider::scrapeProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapePreviewBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapeOddsBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapeOddsBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapeSingleBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeSingleProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeSingleProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapeSingleBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapePairBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapePairProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapePairProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapePairBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testDeprecatedScrapeTripleBulkDelegatesToBatchScraper(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeTripleProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeTripleProvider()[0]['expected'];

        /** @psalm-suppress DeprecatedMethod */
        $result = $this->scraper->scrapeTripleBulk($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapeResultRejectsInvalidStadiumNumber(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('$stadiumNumber must be between 1 and 24, 0 given.');

        /** @psalm-suppress InvalidArgument */
        $this->scraper->scrapeResult('2017-03-31', 0, 1);
    }

    public function testScrapeResultRejectsInvalidRaceNumber(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('$raceNumber must be between 1 and 12, 0 given.');

        /** @psalm-suppress InvalidArgument */
        $this->scraper->scrapeResult('2017-03-31', 24, 0);
    }
}
