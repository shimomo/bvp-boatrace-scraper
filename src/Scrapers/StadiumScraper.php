<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Scrapers;

use BVP\Converter\Converter;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
class StadiumScraper extends BaseScraper implements StadiumScraperInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrape(CarbonInterface $carbonDate): array
    {
        $response = [];

        $scraperFormat = '%s/owpc/pc/race/index?hd=%s';
        $scraperUrl = sprintf($scraperFormat, $this->baseUrl, $carbonDate->format('Ymd'));
        $scraper = $this->httpBrowser->request('GET', $scraperUrl);

        $response = [];
        $scraper = $scraper->filter('.table1')->eq(0);
        $scraper = $scraper->filter('table tbody td.is-arrow1.is-fBold.is-fs15');
        $scraper->each(function ($element) use (&$response) {
            $stadiumName = str_replace('>', '', $element->filter('a')->filter('img')->attr('alt'));
            $stadiumId = Converter::stadiumId($stadiumName);
            $response[$stadiumId] = $stadiumName;
        });

        return $response;
    }

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrapeIds(CarbonInterface $carbonDate): array
    {
        return array_keys($this->scrape($carbonDate));
    }

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function scrapeNames(CarbonInterface $carbonDate): array
    {
        return array_values($this->scrape($carbonDate));
    }
}
