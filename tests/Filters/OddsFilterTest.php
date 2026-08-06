<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Filters;

use BVP\Scraper\Filters\OddsFilter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
final class OddsFilterTest extends TestCase
{
    /**
     * A bare `<td>` is dropped by the HTML parser, so the cell has to be given
     * the table it would sit in on the page.
     *
     * @param non-empty-string $html
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    private function crawler(string $html): Crawler
    {
        return new Crawler("<html><body><table><tr>{$html}</tr></table></body></html>");
    }

    public function testByXPathReadsNumericOdds(): void
    {
        $crawler = $this->crawler('<td id="odds"> 12.3 </td>');

        $this->assertSame(12.3, OddsFilter::byXPath($crawler, '//td[@id="odds"]'));
    }

    public function testByXPathReportsNonNumericOddsAsMissing(): void
    {
        $crawler = $this->crawler('<td id="odds">欠場</td>');

        $this->assertNull(OddsFilter::byXPath($crawler, '//td[@id="odds"]'));
    }

    public function testByXPathReportsAnAbsentCellAsMissing(): void
    {
        $crawler = $this->crawler('<td id="odds">12.3</td>');

        $this->assertNull(OddsFilter::byXPath($crawler, '//td[@id="absent"]'));
    }

    public function testByXPathAsRangeReadsNumericLimits(): void
    {
        $crawler = $this->crawler('<td id="odds">1.2-3.4</td>');

        $this->assertSame(
            ['lower_limit' => 1.2, 'upper_limit' => 3.4],
            OddsFilter::byXPathAsRange($crawler, '//td[@id="odds"]')
        );
    }

    public function testByXPathAsRangeReportsNonNumericLimitsAsMissing(): void
    {
        $crawler = $this->crawler('<td id="odds">欠場-欠場</td>');

        $this->assertSame(
            ['lower_limit' => null, 'upper_limit' => null],
            OddsFilter::byXPathAsRange($crawler, '//td[@id="odds"]')
        );
    }
}
