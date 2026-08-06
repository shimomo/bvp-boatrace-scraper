<?php

declare(strict_types=1);

namespace BVP\Scraper\Filters;

use BVP\Scraper\Converters\Converter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
final class Filter
{
    /**
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @param string $xpath
     * @return ?string
     */
    public static function byXPath(Crawler $scraper, string $xpath): ?string
    {
        if (!$scraper->filterXPath($xpath)->count()) {
            return null;
        }

        $value = $scraper->filterXPath($xpath)->text();

        $value = Converter::toKana($value);

        return Converter::trim($value);
    }

    /**
     * Return the text of every matched node in document order. Used for columns
     * whose number of entries varies and cannot be read with fixed indexes,
     * such as the parts exchange list.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @param string $xpath
     * @return list<string>
     */
    public static function byXPathAsList(Crawler $scraper, string $xpath): array
    {
        return $scraper->filterXPath($xpath)->each(function (Crawler $node): string {
            $value = Converter::toKana($node->text());

            return Converter::trim($value) ?? '';
        });
    }
}
