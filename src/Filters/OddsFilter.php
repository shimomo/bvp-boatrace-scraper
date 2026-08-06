<?php

declare(strict_types=1);

namespace BVP\Scraper\Filters;

use BVP\Scraper\Converters\Converter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Reads odds out of a page. Odds are numbers the caller computes with, so a
 * cell holding anything else is reported as missing rather than cast.
 *
 * @author shimomo
 */
final class OddsFilter
{
    /**
     * A cell that is published but holds something other than a number, such
     * as the wording left for a withdrawn boat, is not odds of zero. Casting
     * it would read as the lowest possible odds and the caller would have no
     * way to tell, so it is reported as missing instead.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @param string $xpath
     * @return ?float
     */
    public static function byXPath(Crawler $scraper, string $xpath): ?float
    {
        if (!$scraper->filterXPath($xpath)->count()) {
            return null;
        }

        $value = Converter::trim($scraper->filterXPath($xpath)->text());

        return is_numeric($value) ? Converter::toFloat($value) : null;
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $scraper
     * @param string $xpath
     * @return array{
     *     lower_limit: ?float,
     *     upper_limit: ?float,
     * }
     */
    public static function byXPathAsRange(Crawler $scraper, string $xpath): array
    {
        $response = ['lower_limit' => null, 'upper_limit' => null];

        if ($scraper->filterXPath($xpath)->count()) {
            if (count($odds = explode('-', $scraper->filterXPath($xpath)->text())) === 2) {
                $lowerLimit = Converter::trim(array_shift($odds));
                $upperLimit = Converter::trim(array_shift($odds));

                if (is_numeric($lowerLimit) && is_numeric($upperLimit)) {
                    $response['lower_limit'] = Converter::toFloat($lowerLimit);
                    $response['upper_limit'] = Converter::toFloat($upperLimit);
                }
            }
        }

        return $response;
    }
}
