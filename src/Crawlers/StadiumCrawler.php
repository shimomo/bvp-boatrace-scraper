<?php

declare(strict_types=1);

namespace BVP\Crawler\Crawlers;

use Boatrace\Venture\Project\Converter;
use Carbon\CarbonInterface;

/**
 * @author shimomo
 */
class StadiumCrawler extends BaseCrawler implements StadiumCrawlerInterface
{
    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate): array
    {
        $response = [];

        $crawlerFormat = '%s/owpc/pc/race/index?hd=%s';
        $crawlerUrl = sprintf($crawlerFormat, $this->baseUrl, $carbonDate->format('Ymd'));
        $crawler = $this->httpBrowser->request('GET', $crawlerUrl);

        $response = [];
        $crawler = $crawler->filter('.table1')->eq(0);
        $crawler = $crawler->filter('table tbody td.is-arrow1.is-fBold.is-fs15');
        $crawler->each(function ($element) use (&$response) {
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
    public function crawlIds(CarbonInterface $carbonDate): array
    {
        return array_keys($this->crawl($carbonDate));
    }

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @return array
     */
    public function crawlNames(CarbonInterface $carbonDate): array
    {
        return array_values($this->crawl($carbonDate));
    }
}
