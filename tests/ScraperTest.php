<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests;

use BVP\Scraper\Scraper;
use PHPUnit\Framework\TestCase;
use ValueError;

/**
 * Exercises the argument validation the instance-based Scraper facade does
 * before it reaches a scraper at all. Fan-out is covered by BatchScraperTest,
 * and per-field scraping correctness by tests/Scrapers/*Test.php against the
 * underlying scraper classes directly.
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
        $this->scraper = new Scraper(httpBrowser: MockBrowser::create());
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
