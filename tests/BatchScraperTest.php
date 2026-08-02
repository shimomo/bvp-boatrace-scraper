<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests;

use BVP\Scraper\BatchScraper;
use BVP\Scraper\Tests\Scrapers\OddsScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\PreviewScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\ProgramScraperDataProvider;
use BVP\Scraper\Tests\Scrapers\ResultScraperDataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Exercises the batch fan-out itself. Per-field scraping correctness is
 * already covered by tests/Scrapers/*Test.php against the underlying scraper
 * classes directly; these tests reuse those already-verified fixtures rather
 * than re-deriving them, wrapped in the [stadiumNumber => [raceNumber => ...]]
 * batch shape.
 *
 * @author shimomo
 */
final class BatchScraperTest extends TestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private BatchScraper $batchScraper;

    #[\Override]
    protected function setUp(): void
    {
        $this->batchScraper = new BatchScraper();
    }

    public function testScrapeResultFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = ResultScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = ResultScraperDataProvider::scrapeProvider()[0]['expected'];

        $result = $this->batchScraper->scrapeResult($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapeProgramFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = ProgramScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = ProgramScraperDataProvider::scrapeProvider()[0]['expected'];

        $result = $this->batchScraper->scrapeProgram($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapePreviewFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = PreviewScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = PreviewScraperDataProvider::scrapeProvider()[0]['expected'];

        $result = $this->batchScraper->scrapePreview($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapeOddsFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeProvider()[0]['expected'];

        $result = $this->batchScraper->scrapeOdds($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapeSingleFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeSingleProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeSingleProvider()[0]['expected'];

        $result = $this->batchScraper->scrapeSingle($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapePairFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapePairProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapePairProvider()[0]['expected'];

        $result = $this->batchScraper->scrapePair($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }

    public function testScrapeTripleFansOutOverExplicitStadiumAndRace(): void
    {
        [$date, $stadiumNumber, $raceNumber] = OddsScraperDataProvider::scrapeTripleProvider()[0]['arguments'];
        $expected = OddsScraperDataProvider::scrapeTripleProvider()[0]['expected'];

        $result = $this->batchScraper->scrapeTriple($date, [$stadiumNumber], [$raceNumber]);

        $this->assertSame([$stadiumNumber => [$raceNumber => $expected]], $result);
    }
}
