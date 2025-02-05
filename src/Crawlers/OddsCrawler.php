<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Crawlers;

use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
class OddsCrawler extends BaseCrawler implements OddsCrawlerInterface
{
    /**
     * @var string
     */
    private string $baseXPath = 'descendant-or-self::body/main/div/div/div';

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  int                      $raceStadiumCode
     * @param  int                      $raceCode
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $crawler1Format = '%s/owpc/pc/race/oddstf?hd=%s&jcd=%02d&rno=%d';
        $crawler1Url = sprintf($crawler1Format, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler1 = $this->httpBrowser->request('GET', $crawler1Url);
        sleep($this->seconds);

        $crawler2Format = '%s/owpc/pc/race/odds2tf?hd=%s&jcd=%02d&rno=%d';
        $crawler2Url = sprintf($crawler2Format, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler2 = $this->httpBrowser->request('GET', $crawler2Url);
        sleep($this->seconds);

        $crawler3Format = '%s/owpc/pc/race/oddsk?hd=%s&jcd=%02d&rno=%d';
        $crawler3Url = sprintf($crawler3Format, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler3 = $this->httpBrowser->request('GET', $crawler3Url);
        sleep($this->seconds);

        $crawler4Format = '%s/owpc/pc/race/odds3t?hd=%s&jcd=%02d&rno=%d';
        $crawler4Url = sprintf($crawler4Format, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler4 = $this->httpBrowser->request('GET', $crawler4Url);
        sleep($this->seconds);

        $crawler5Format = '%s/owpc/pc/race/odds3f?hd=%s&jcd=%02d&rno=%d';
        $crawler5Url = sprintf($crawler5Format, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler5 = $this->httpBrowser->request('GET', $crawler5Url);
        sleep($this->seconds);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (!is_null($this->filterXPath($crawler1, $levelXPath))) {
            $this->baseLevel = 1;
        }

        $response['race_date'] = $carbonDate->format('Y-m-d');
        $response['race_stadium_code'] = $raceStadiumCode;
        $response['race_code'] = $raceCode;

        $response += $this->crawlWin($crawler1, $raceStadiumCode, $raceCode);
        $response += $this->crawlPlace($crawler1, $raceStadiumCode, $raceCode);
        $response += $this->crawlExacta($crawler2, $raceStadiumCode, $raceCode);
        $response += $this->crawlQuinella($crawler2, $raceStadiumCode, $raceCode);
        $response += $this->crawlQuinellaPlace($crawler3, $raceStadiumCode, $raceCode);
        $response += $this->crawlTrifecta($crawler4, $raceStadiumCode, $raceCode);
        $response += $this->crawlTrio($crawler5, $raceStadiumCode, $raceCode);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlWin(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $win1XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[1]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $win2XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[2]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $win3XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[3]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $win4XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[4]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $win5XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[5]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $win6XPath = sprintf('%s/div[2]/div[%s]/div[1]/div[2]/table/tbody[6]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);

        $response['win_oddses'][1] = $this->filterXPathForOdds($crawler, $win1XPath);
        $response['win_oddses'][2] = $this->filterXPathForOdds($crawler, $win2XPath);
        $response['win_oddses'][3] = $this->filterXPathForOdds($crawler, $win3XPath);
        $response['win_oddses'][4] = $this->filterXPathForOdds($crawler, $win4XPath);
        $response['win_oddses'][5] = $this->filterXPathForOdds($crawler, $win5XPath);
        $response['win_oddses'][6] = $this->filterXPathForOdds($crawler, $win6XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlPlace(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $place1XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[1]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $place2XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[2]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $place3XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[3]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $place4XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[4]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $place5XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[5]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);
        $place6XPath = sprintf('%s/div[2]/div[%s]/div[2]/div[2]/table/tbody[6]/tr/td[3]', $this->baseXPath, $this->baseLevel + 6);

        $response['place_oddses'][1] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place1XPath);
        $response['place_oddses'][2] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place2XPath);
        $response['place_oddses'][3] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place3XPath);
        $response['place_oddses'][4] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place4XPath);
        $response['place_oddses'][5] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place5XPath);
        $response['place_oddses'][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $place6XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlExacta(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $exacta12XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $exacta13XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $exacta14XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $exacta15XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $exacta16XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $exacta21XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $exacta23XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $exacta24XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $exacta25XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $exacta26XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $exacta31XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $exacta32XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $exacta34XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $exacta35XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $exacta36XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $exacta41XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $exacta42XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $exacta43XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $exacta45XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $exacta46XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $exacta51XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $exacta52XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $exacta53XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $exacta54XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $exacta56XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $exacta61XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $exacta62XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $exacta63XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $exacta64XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $exacta65XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[12]', $this->baseXPath, $this->baseLevel + 7);

        $response['exacta_oddses'][1][2] = $this->filterXPathForOdds($crawler, $exacta12XPath);
        $response['exacta_oddses'][1][3] = $this->filterXPathForOdds($crawler, $exacta13XPath);
        $response['exacta_oddses'][1][4] = $this->filterXPathForOdds($crawler, $exacta14XPath);
        $response['exacta_oddses'][1][5] = $this->filterXPathForOdds($crawler, $exacta15XPath);
        $response['exacta_oddses'][1][6] = $this->filterXPathForOdds($crawler, $exacta16XPath);
        $response['exacta_oddses'][2][1] = $this->filterXPathForOdds($crawler, $exacta21XPath);
        $response['exacta_oddses'][2][3] = $this->filterXPathForOdds($crawler, $exacta23XPath);
        $response['exacta_oddses'][2][4] = $this->filterXPathForOdds($crawler, $exacta24XPath);
        $response['exacta_oddses'][2][5] = $this->filterXPathForOdds($crawler, $exacta25XPath);
        $response['exacta_oddses'][2][6] = $this->filterXPathForOdds($crawler, $exacta26XPath);
        $response['exacta_oddses'][3][1] = $this->filterXPathForOdds($crawler, $exacta31XPath);
        $response['exacta_oddses'][3][2] = $this->filterXPathForOdds($crawler, $exacta32XPath);
        $response['exacta_oddses'][3][4] = $this->filterXPathForOdds($crawler, $exacta34XPath);
        $response['exacta_oddses'][3][5] = $this->filterXPathForOdds($crawler, $exacta35XPath);
        $response['exacta_oddses'][3][6] = $this->filterXPathForOdds($crawler, $exacta36XPath);
        $response['exacta_oddses'][4][1] = $this->filterXPathForOdds($crawler, $exacta41XPath);
        $response['exacta_oddses'][4][2] = $this->filterXPathForOdds($crawler, $exacta42XPath);
        $response['exacta_oddses'][4][3] = $this->filterXPathForOdds($crawler, $exacta43XPath);
        $response['exacta_oddses'][4][5] = $this->filterXPathForOdds($crawler, $exacta45XPath);
        $response['exacta_oddses'][4][6] = $this->filterXPathForOdds($crawler, $exacta46XPath);
        $response['exacta_oddses'][5][1] = $this->filterXPathForOdds($crawler, $exacta51XPath);
        $response['exacta_oddses'][5][2] = $this->filterXPathForOdds($crawler, $exacta52XPath);
        $response['exacta_oddses'][5][3] = $this->filterXPathForOdds($crawler, $exacta53XPath);
        $response['exacta_oddses'][5][4] = $this->filterXPathForOdds($crawler, $exacta54XPath);
        $response['exacta_oddses'][5][6] = $this->filterXPathForOdds($crawler, $exacta56XPath);
        $response['exacta_oddses'][6][1] = $this->filterXPathForOdds($crawler, $exacta61XPath);
        $response['exacta_oddses'][6][2] = $this->filterXPathForOdds($crawler, $exacta62XPath);
        $response['exacta_oddses'][6][3] = $this->filterXPathForOdds($crawler, $exacta63XPath);
        $response['exacta_oddses'][6][4] = $this->filterXPathForOdds($crawler, $exacta64XPath);
        $response['exacta_oddses'][6][5] = $this->filterXPathForOdds($crawler, $exacta65XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlQuinella(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $quinella12XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[2]', $this->baseXPath, $this->baseLevel + 9);
        $quinella13XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[2]', $this->baseXPath, $this->baseLevel + 9);
        $quinella14XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[2]', $this->baseXPath, $this->baseLevel + 9);
        $quinella15XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[2]', $this->baseXPath, $this->baseLevel + 9);
        $quinella16XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[2]', $this->baseXPath, $this->baseLevel + 9);
        $quinella23XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[4]', $this->baseXPath, $this->baseLevel + 9);
        $quinella24XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[4]', $this->baseXPath, $this->baseLevel + 9);
        $quinella25XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[4]', $this->baseXPath, $this->baseLevel + 9);
        $quinella26XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[4]', $this->baseXPath, $this->baseLevel + 9);
        $quinella34XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[6]', $this->baseXPath, $this->baseLevel + 9);
        $quinella35XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[6]', $this->baseXPath, $this->baseLevel + 9);
        $quinella36XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[6]', $this->baseXPath, $this->baseLevel + 9);
        $quinella45XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[8]', $this->baseXPath, $this->baseLevel + 9);
        $quinella46XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[8]', $this->baseXPath, $this->baseLevel + 9);
        $quinella56XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[10]', $this->baseXPath, $this->baseLevel + 9);

        $response['quinella_oddses'][1][2] = $this->filterXPathForOdds($crawler, $quinella12XPath);
        $response['quinella_oddses'][1][3] = $this->filterXPathForOdds($crawler, $quinella13XPath);
        $response['quinella_oddses'][1][4] = $this->filterXPathForOdds($crawler, $quinella14XPath);
        $response['quinella_oddses'][1][5] = $this->filterXPathForOdds($crawler, $quinella15XPath);
        $response['quinella_oddses'][1][6] = $this->filterXPathForOdds($crawler, $quinella16XPath);
        $response['quinella_oddses'][2][3] = $this->filterXPathForOdds($crawler, $quinella23XPath);
        $response['quinella_oddses'][2][4] = $this->filterXPathForOdds($crawler, $quinella24XPath);
        $response['quinella_oddses'][2][5] = $this->filterXPathForOdds($crawler, $quinella25XPath);
        $response['quinella_oddses'][2][6] = $this->filterXPathForOdds($crawler, $quinella26XPath);
        $response['quinella_oddses'][3][4] = $this->filterXPathForOdds($crawler, $quinella34XPath);
        $response['quinella_oddses'][3][5] = $this->filterXPathForOdds($crawler, $quinella35XPath);
        $response['quinella_oddses'][3][6] = $this->filterXPathForOdds($crawler, $quinella36XPath);
        $response['quinella_oddses'][4][5] = $this->filterXPathForOdds($crawler, $quinella45XPath);
        $response['quinella_oddses'][4][6] = $this->filterXPathForOdds($crawler, $quinella46XPath);
        $response['quinella_oddses'][5][6] = $this->filterXPathForOdds($crawler, $quinella56XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlQuinellaPlace(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $quinellaPlace12XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace13XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace14XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace15XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace16XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace23XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace24XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace25XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace26XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace34XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace35XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace36XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace45XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace46XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $quinellaPlace56XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[10]', $this->baseXPath, $this->baseLevel + 7);

        $response['quinella_place_oddses'][1][2] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace12XPath);
        $response['quinella_place_oddses'][1][3] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace13XPath);
        $response['quinella_place_oddses'][1][4] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace14XPath);
        $response['quinella_place_oddses'][1][5] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace15XPath);
        $response['quinella_place_oddses'][1][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace16XPath);
        $response['quinella_place_oddses'][2][3] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace23XPath);
        $response['quinella_place_oddses'][2][4] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace24XPath);
        $response['quinella_place_oddses'][2][5] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace25XPath);
        $response['quinella_place_oddses'][2][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace26XPath);
        $response['quinella_place_oddses'][3][4] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace34XPath);
        $response['quinella_place_oddses'][3][5] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace35XPath);
        $response['quinella_place_oddses'][3][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace36XPath);
        $response['quinella_place_oddses'][4][5] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace45XPath);
        $response['quinella_place_oddses'][4][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace46XPath);
        $response['quinella_place_oddses'][5][6] = $this->filterXPathForOddsWithLowerLimitAndUpperLimit($crawler, $quinellaPlace56XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlTrifecta(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $trifecta123XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta124XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta125XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta126XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta132XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta134XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta135XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta136XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta142XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta143XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta145XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta146XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta152XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta153XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta154XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta156XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta162XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta163XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta164XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta165XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta213XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta214XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta215XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta216XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta231XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta234XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta235XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta236XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta241XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta243XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta245XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta246XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta251XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta253XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta254XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta256XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta261XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta263XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta264XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta265XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta312XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta314XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta315XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta316XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta321XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta324XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta325XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta326XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta341XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta342XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta345XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta346XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta351XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta352XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta354XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta356XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta361XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta362XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta364XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta365XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta412XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta413XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta415XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta416XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta421XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta423XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta425XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta426XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta431XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta432XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta435XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta436XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta451XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta452XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta453XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta456XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta461XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta462XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta463XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta465XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[8]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta512XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[15]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta513XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta514XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta516XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta521XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[15]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta523XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta524XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta526XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta531XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[15]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta532XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta534XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta536XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta541XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[15]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta542XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta543XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta546XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta561XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[15]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta562XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta563XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta564XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[10]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta612XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[18]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta613XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta614XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta615XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta621XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[18]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta623XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta624XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta625XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta631XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[18]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta632XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta634XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[11]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta635XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[12]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta641XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[13]/td[18]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta642XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[14]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta643XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[15]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta645XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[16]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta651XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[17]/td[18]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta652XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[18]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta653XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[19]/td[12]', $this->baseXPath, $this->baseLevel + 7);
        $trifecta654XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[20]/td[12]', $this->baseXPath, $this->baseLevel + 7);

        $response['trifecta_oddses'][1][2][3] = $this->filterXPathForOdds($crawler, $trifecta123XPath);
        $response['trifecta_oddses'][1][2][4] = $this->filterXPathForOdds($crawler, $trifecta124XPath);
        $response['trifecta_oddses'][1][2][5] = $this->filterXPathForOdds($crawler, $trifecta125XPath);
        $response['trifecta_oddses'][1][2][6] = $this->filterXPathForOdds($crawler, $trifecta126XPath);
        $response['trifecta_oddses'][1][3][2] = $this->filterXPathForOdds($crawler, $trifecta132XPath);
        $response['trifecta_oddses'][1][3][4] = $this->filterXPathForOdds($crawler, $trifecta134XPath);
        $response['trifecta_oddses'][1][3][5] = $this->filterXPathForOdds($crawler, $trifecta135XPath);
        $response['trifecta_oddses'][1][3][6] = $this->filterXPathForOdds($crawler, $trifecta136XPath);
        $response['trifecta_oddses'][1][4][2] = $this->filterXPathForOdds($crawler, $trifecta142XPath);
        $response['trifecta_oddses'][1][4][3] = $this->filterXPathForOdds($crawler, $trifecta143XPath);
        $response['trifecta_oddses'][1][4][5] = $this->filterXPathForOdds($crawler, $trifecta145XPath);
        $response['trifecta_oddses'][1][4][6] = $this->filterXPathForOdds($crawler, $trifecta146XPath);
        $response['trifecta_oddses'][1][5][2] = $this->filterXPathForOdds($crawler, $trifecta152XPath);
        $response['trifecta_oddses'][1][5][3] = $this->filterXPathForOdds($crawler, $trifecta153XPath);
        $response['trifecta_oddses'][1][5][4] = $this->filterXPathForOdds($crawler, $trifecta154XPath);
        $response['trifecta_oddses'][1][5][6] = $this->filterXPathForOdds($crawler, $trifecta156XPath);
        $response['trifecta_oddses'][1][6][2] = $this->filterXPathForOdds($crawler, $trifecta162XPath);
        $response['trifecta_oddses'][1][6][3] = $this->filterXPathForOdds($crawler, $trifecta163XPath);
        $response['trifecta_oddses'][1][6][4] = $this->filterXPathForOdds($crawler, $trifecta164XPath);
        $response['trifecta_oddses'][1][6][5] = $this->filterXPathForOdds($crawler, $trifecta165XPath);
        $response['trifecta_oddses'][2][1][3] = $this->filterXPathForOdds($crawler, $trifecta213XPath);
        $response['trifecta_oddses'][2][1][4] = $this->filterXPathForOdds($crawler, $trifecta214XPath);
        $response['trifecta_oddses'][2][1][5] = $this->filterXPathForOdds($crawler, $trifecta215XPath);
        $response['trifecta_oddses'][2][1][6] = $this->filterXPathForOdds($crawler, $trifecta216XPath);
        $response['trifecta_oddses'][2][3][1] = $this->filterXPathForOdds($crawler, $trifecta231XPath);
        $response['trifecta_oddses'][2][3][4] = $this->filterXPathForOdds($crawler, $trifecta234XPath);
        $response['trifecta_oddses'][2][3][5] = $this->filterXPathForOdds($crawler, $trifecta235XPath);
        $response['trifecta_oddses'][2][3][6] = $this->filterXPathForOdds($crawler, $trifecta236XPath);
        $response['trifecta_oddses'][2][4][1] = $this->filterXPathForOdds($crawler, $trifecta241XPath);
        $response['trifecta_oddses'][2][4][3] = $this->filterXPathForOdds($crawler, $trifecta243XPath);
        $response['trifecta_oddses'][2][4][5] = $this->filterXPathForOdds($crawler, $trifecta245XPath);
        $response['trifecta_oddses'][2][4][6] = $this->filterXPathForOdds($crawler, $trifecta246XPath);
        $response['trifecta_oddses'][2][5][1] = $this->filterXPathForOdds($crawler, $trifecta251XPath);
        $response['trifecta_oddses'][2][5][3] = $this->filterXPathForOdds($crawler, $trifecta253XPath);
        $response['trifecta_oddses'][2][5][4] = $this->filterXPathForOdds($crawler, $trifecta254XPath);
        $response['trifecta_oddses'][2][5][6] = $this->filterXPathForOdds($crawler, $trifecta256XPath);
        $response['trifecta_oddses'][2][6][1] = $this->filterXPathForOdds($crawler, $trifecta261XPath);
        $response['trifecta_oddses'][2][6][3] = $this->filterXPathForOdds($crawler, $trifecta263XPath);
        $response['trifecta_oddses'][2][6][4] = $this->filterXPathForOdds($crawler, $trifecta264XPath);
        $response['trifecta_oddses'][2][6][5] = $this->filterXPathForOdds($crawler, $trifecta265XPath);
        $response['trifecta_oddses'][3][1][2] = $this->filterXPathForOdds($crawler, $trifecta312XPath);
        $response['trifecta_oddses'][3][1][4] = $this->filterXPathForOdds($crawler, $trifecta314XPath);
        $response['trifecta_oddses'][3][1][5] = $this->filterXPathForOdds($crawler, $trifecta315XPath);
        $response['trifecta_oddses'][3][1][6] = $this->filterXPathForOdds($crawler, $trifecta316XPath);
        $response['trifecta_oddses'][3][2][1] = $this->filterXPathForOdds($crawler, $trifecta321XPath);
        $response['trifecta_oddses'][3][2][4] = $this->filterXPathForOdds($crawler, $trifecta324XPath);
        $response['trifecta_oddses'][3][2][5] = $this->filterXPathForOdds($crawler, $trifecta325XPath);
        $response['trifecta_oddses'][3][2][6] = $this->filterXPathForOdds($crawler, $trifecta326XPath);
        $response['trifecta_oddses'][3][4][1] = $this->filterXPathForOdds($crawler, $trifecta341XPath);
        $response['trifecta_oddses'][3][4][2] = $this->filterXPathForOdds($crawler, $trifecta342XPath);
        $response['trifecta_oddses'][3][4][5] = $this->filterXPathForOdds($crawler, $trifecta345XPath);
        $response['trifecta_oddses'][3][4][6] = $this->filterXPathForOdds($crawler, $trifecta346XPath);
        $response['trifecta_oddses'][3][5][1] = $this->filterXPathForOdds($crawler, $trifecta351XPath);
        $response['trifecta_oddses'][3][5][2] = $this->filterXPathForOdds($crawler, $trifecta352XPath);
        $response['trifecta_oddses'][3][5][4] = $this->filterXPathForOdds($crawler, $trifecta354XPath);
        $response['trifecta_oddses'][3][5][6] = $this->filterXPathForOdds($crawler, $trifecta356XPath);
        $response['trifecta_oddses'][3][6][1] = $this->filterXPathForOdds($crawler, $trifecta361XPath);
        $response['trifecta_oddses'][3][6][2] = $this->filterXPathForOdds($crawler, $trifecta362XPath);
        $response['trifecta_oddses'][3][6][4] = $this->filterXPathForOdds($crawler, $trifecta364XPath);
        $response['trifecta_oddses'][3][6][5] = $this->filterXPathForOdds($crawler, $trifecta365XPath);
        $response['trifecta_oddses'][4][1][2] = $this->filterXPathForOdds($crawler, $trifecta412XPath);
        $response['trifecta_oddses'][4][1][3] = $this->filterXPathForOdds($crawler, $trifecta413XPath);
        $response['trifecta_oddses'][4][1][5] = $this->filterXPathForOdds($crawler, $trifecta415XPath);
        $response['trifecta_oddses'][4][1][6] = $this->filterXPathForOdds($crawler, $trifecta416XPath);
        $response['trifecta_oddses'][4][2][1] = $this->filterXPathForOdds($crawler, $trifecta421XPath);
        $response['trifecta_oddses'][4][2][3] = $this->filterXPathForOdds($crawler, $trifecta423XPath);
        $response['trifecta_oddses'][4][2][5] = $this->filterXPathForOdds($crawler, $trifecta425XPath);
        $response['trifecta_oddses'][4][2][6] = $this->filterXPathForOdds($crawler, $trifecta426XPath);
        $response['trifecta_oddses'][4][3][1] = $this->filterXPathForOdds($crawler, $trifecta431XPath);
        $response['trifecta_oddses'][4][3][2] = $this->filterXPathForOdds($crawler, $trifecta432XPath);
        $response['trifecta_oddses'][4][3][5] = $this->filterXPathForOdds($crawler, $trifecta435XPath);
        $response['trifecta_oddses'][4][3][6] = $this->filterXPathForOdds($crawler, $trifecta436XPath);
        $response['trifecta_oddses'][4][5][1] = $this->filterXPathForOdds($crawler, $trifecta451XPath);
        $response['trifecta_oddses'][4][5][2] = $this->filterXPathForOdds($crawler, $trifecta452XPath);
        $response['trifecta_oddses'][4][5][3] = $this->filterXPathForOdds($crawler, $trifecta453XPath);
        $response['trifecta_oddses'][4][5][6] = $this->filterXPathForOdds($crawler, $trifecta456XPath);
        $response['trifecta_oddses'][4][6][1] = $this->filterXPathForOdds($crawler, $trifecta461XPath);
        $response['trifecta_oddses'][4][6][2] = $this->filterXPathForOdds($crawler, $trifecta462XPath);
        $response['trifecta_oddses'][4][6][3] = $this->filterXPathForOdds($crawler, $trifecta463XPath);
        $response['trifecta_oddses'][4][6][5] = $this->filterXPathForOdds($crawler, $trifecta465XPath);
        $response['trifecta_oddses'][5][1][2] = $this->filterXPathForOdds($crawler, $trifecta512XPath);
        $response['trifecta_oddses'][5][1][3] = $this->filterXPathForOdds($crawler, $trifecta513XPath);
        $response['trifecta_oddses'][5][1][4] = $this->filterXPathForOdds($crawler, $trifecta514XPath);
        $response['trifecta_oddses'][5][1][6] = $this->filterXPathForOdds($crawler, $trifecta516XPath);
        $response['trifecta_oddses'][5][2][1] = $this->filterXPathForOdds($crawler, $trifecta521XPath);
        $response['trifecta_oddses'][5][2][3] = $this->filterXPathForOdds($crawler, $trifecta523XPath);
        $response['trifecta_oddses'][5][2][4] = $this->filterXPathForOdds($crawler, $trifecta524XPath);
        $response['trifecta_oddses'][5][2][6] = $this->filterXPathForOdds($crawler, $trifecta526XPath);
        $response['trifecta_oddses'][5][3][1] = $this->filterXPathForOdds($crawler, $trifecta531XPath);
        $response['trifecta_oddses'][5][3][2] = $this->filterXPathForOdds($crawler, $trifecta532XPath);
        $response['trifecta_oddses'][5][3][4] = $this->filterXPathForOdds($crawler, $trifecta534XPath);
        $response['trifecta_oddses'][5][3][6] = $this->filterXPathForOdds($crawler, $trifecta536XPath);
        $response['trifecta_oddses'][5][4][1] = $this->filterXPathForOdds($crawler, $trifecta541XPath);
        $response['trifecta_oddses'][5][4][2] = $this->filterXPathForOdds($crawler, $trifecta542XPath);
        $response['trifecta_oddses'][5][4][3] = $this->filterXPathForOdds($crawler, $trifecta543XPath);
        $response['trifecta_oddses'][5][4][6] = $this->filterXPathForOdds($crawler, $trifecta546XPath);
        $response['trifecta_oddses'][5][6][1] = $this->filterXPathForOdds($crawler, $trifecta561XPath);
        $response['trifecta_oddses'][5][6][2] = $this->filterXPathForOdds($crawler, $trifecta562XPath);
        $response['trifecta_oddses'][5][6][3] = $this->filterXPathForOdds($crawler, $trifecta563XPath);
        $response['trifecta_oddses'][5][6][4] = $this->filterXPathForOdds($crawler, $trifecta564XPath);
        $response['trifecta_oddses'][6][1][2] = $this->filterXPathForOdds($crawler, $trifecta612XPath);
        $response['trifecta_oddses'][6][1][3] = $this->filterXPathForOdds($crawler, $trifecta613XPath);
        $response['trifecta_oddses'][6][1][4] = $this->filterXPathForOdds($crawler, $trifecta614XPath);
        $response['trifecta_oddses'][6][1][5] = $this->filterXPathForOdds($crawler, $trifecta615XPath);
        $response['trifecta_oddses'][6][2][1] = $this->filterXPathForOdds($crawler, $trifecta621XPath);
        $response['trifecta_oddses'][6][2][3] = $this->filterXPathForOdds($crawler, $trifecta623XPath);
        $response['trifecta_oddses'][6][2][4] = $this->filterXPathForOdds($crawler, $trifecta624XPath);
        $response['trifecta_oddses'][6][2][5] = $this->filterXPathForOdds($crawler, $trifecta625XPath);
        $response['trifecta_oddses'][6][3][1] = $this->filterXPathForOdds($crawler, $trifecta631XPath);
        $response['trifecta_oddses'][6][3][2] = $this->filterXPathForOdds($crawler, $trifecta632XPath);
        $response['trifecta_oddses'][6][3][4] = $this->filterXPathForOdds($crawler, $trifecta634XPath);
        $response['trifecta_oddses'][6][3][5] = $this->filterXPathForOdds($crawler, $trifecta635XPath);
        $response['trifecta_oddses'][6][4][1] = $this->filterXPathForOdds($crawler, $trifecta641XPath);
        $response['trifecta_oddses'][6][4][2] = $this->filterXPathForOdds($crawler, $trifecta642XPath);
        $response['trifecta_oddses'][6][4][3] = $this->filterXPathForOdds($crawler, $trifecta643XPath);
        $response['trifecta_oddses'][6][4][5] = $this->filterXPathForOdds($crawler, $trifecta645XPath);
        $response['trifecta_oddses'][6][5][1] = $this->filterXPathForOdds($crawler, $trifecta651XPath);
        $response['trifecta_oddses'][6][5][2] = $this->filterXPathForOdds($crawler, $trifecta652XPath);
        $response['trifecta_oddses'][6][5][3] = $this->filterXPathForOdds($crawler, $trifecta653XPath);
        $response['trifecta_oddses'][6][5][4] = $this->filterXPathForOdds($crawler, $trifecta654XPath);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlTrio(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $trio123XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[1]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trio124XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[2]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio125XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[3]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio126XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[4]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio134XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trio135XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio136XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio145XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trio146XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[2]', $this->baseXPath, $this->baseLevel + 7);
        $trio156XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[3]', $this->baseXPath, $this->baseLevel + 7);
        $trio234XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[5]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trio235XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[6]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trio236XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[7]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trio245XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trio246XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[4]', $this->baseXPath, $this->baseLevel + 7);
        $trio256XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trio345XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[8]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trio346XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[9]/td[6]', $this->baseXPath, $this->baseLevel + 7);
        $trio356XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[9]', $this->baseXPath, $this->baseLevel + 7);
        $trio456XPath = sprintf('%s/div[2]/div[%s]/table/tbody/tr[10]/td[12]', $this->baseXPath, $this->baseLevel + 7);

        $response['trio_oddses'][1][2][3] = $this->filterXPathForOdds($crawler, $trio123XPath);
        $response['trio_oddses'][1][2][4] = $this->filterXPathForOdds($crawler, $trio124XPath);
        $response['trio_oddses'][1][2][5] = $this->filterXPathForOdds($crawler, $trio125XPath);
        $response['trio_oddses'][1][2][6] = $this->filterXPathForOdds($crawler, $trio126XPath);
        $response['trio_oddses'][1][3][4] = $this->filterXPathForOdds($crawler, $trio134XPath);
        $response['trio_oddses'][1][3][5] = $this->filterXPathForOdds($crawler, $trio135XPath);
        $response['trio_oddses'][1][3][6] = $this->filterXPathForOdds($crawler, $trio136XPath);
        $response['trio_oddses'][1][4][5] = $this->filterXPathForOdds($crawler, $trio145XPath);
        $response['trio_oddses'][1][4][6] = $this->filterXPathForOdds($crawler, $trio146XPath);
        $response['trio_oddses'][1][5][6] = $this->filterXPathForOdds($crawler, $trio156XPath);
        $response['trio_oddses'][2][3][4] = $this->filterXPathForOdds($crawler, $trio234XPath);
        $response['trio_oddses'][2][3][5] = $this->filterXPathForOdds($crawler, $trio235XPath);
        $response['trio_oddses'][2][3][6] = $this->filterXPathForOdds($crawler, $trio236XPath);
        $response['trio_oddses'][2][4][5] = $this->filterXPathForOdds($crawler, $trio245XPath);
        $response['trio_oddses'][2][4][6] = $this->filterXPathForOdds($crawler, $trio246XPath);
        $response['trio_oddses'][2][5][6] = $this->filterXPathForOdds($crawler, $trio256XPath);
        $response['trio_oddses'][3][4][5] = $this->filterXPathForOdds($crawler, $trio345XPath);
        $response['trio_oddses'][3][4][6] = $this->filterXPathForOdds($crawler, $trio346XPath);
        $response['trio_oddses'][3][5][6] = $this->filterXPathForOdds($crawler, $trio356XPath);
        $response['trio_oddses'][4][5][6] = $this->filterXPathForOdds($crawler, $trio456XPath);

        return $response;
    }
}
