<?php

declare(strict_types=1);

namespace BVP\Crawler\Crawlers;

use BVP\Converter\Converter;
use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
class ResultCrawler extends BaseCrawler implements ResultCrawlerInterface
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

        $crawlerFormat = '%s/owpc/pc/race/raceresult?hd=%s&jcd=%02d&rno=%d';
        $crawlerUrl = sprintf($crawlerFormat, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler = $this->httpBrowser->request('GET', $crawlerUrl);
        sleep($this->seconds);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (!is_null($this->filterXPath($crawler, $levelXPath))) {
            $this->baseLevel = 1;
        }

        $raceWindFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[3]/div/span[2]';
        $raceWindDirectionIdFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[4]/p';
        $raceWaveFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[6]/div/span[2]';
        $raceWeatherNameFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[2]/div/span';
        $raceTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[1]/div/span[2]';
        $raceWaterTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[5]/div/span[2]';
        $raceTechniqueNameFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[2]/div[2]/table/tbody/tr/td';

        $raceWindXPath = sprintf($raceWindFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWindDirectionIdXPath = sprintf($raceWindDirectionIdFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWaveXPath = sprintf($raceWaveFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWeatherNameXPath = sprintf($raceWeatherNameFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceTemperatureXPath = sprintf($raceTemperatureFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWaterTemperatureXPath = sprintf($raceWaterTemperatureFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceTechniqueNameXPath = sprintf($raceTechniqueNameFormat, $this->baseXPath, $this->baseLevel + 6);

        $raceWind = $this->filterXPath($crawler, $raceWindXPath);
        $raceWindDirectionId = $this->filterXPathForWindDirectionId($crawler, $raceWindDirectionIdXPath);
        $raceWave = $this->filterXPath($crawler, $raceWaveXPath);
        $raceWeatherName = $this->filterXPath($crawler, $raceWeatherNameXPath);
        $raceTemperature = $this->filterXPath($crawler, $raceTemperatureXPath);
        $raceWaterTemperature = $this->filterXPath($crawler, $raceWaterTemperatureXPath);
        $raceTechniqueName = $this->filterXPath($crawler, $raceTechniqueNameXPath);

        $raceWind = Converter::wind($raceWind);
        $raceWindDirectionId = Converter::windDirection($raceWindDirectionId);
        $raceWave = Converter::wave($raceWave);
        $raceWeatherId = Converter::weatherId($raceWeatherName);
        $raceTemperature = Converter::temperature($raceTemperature);
        $raceWaterTemperature = Converter::temperature($raceWaterTemperature);
        $raceTechniqueId = Converter::techniqueId($raceTechniqueName);

        $response['race_date'] = $carbonDate->format('Y-m-d');
        $response['race_stadium_code'] = $raceStadiumCode;
        $response['race_code'] = $raceCode;
        $response['race_wind'] = $raceWind;
        $response['race_wind_direction_id'] = $raceWindDirectionId;
        $response['race_wave'] = $raceWave;
        $response['race_weather_id'] = $raceWeatherId;
        $response['race_temperature'] = $raceTemperature;
        $response['race_water_temperature'] = $raceWaterTemperature;
        $response['race_technique_id'] = $raceTechniqueId;

        $response += $this->crawlCourses($crawler, $raceStadiumCode, $raceCode);
        $response += $this->crawlPlaces($crawler, $raceStadiumCode, $raceCode);
        $response += $this->crawlRefunds($crawler, $raceStadiumCode, $raceCode);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlCourses(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[2]/div/table/tbody/tr[%s]/td/div/span[1]';
        $racerStartTimingFormat = '%s/div[2]/div[%s]/div[2]/div/table/tbody/tr[%s]/td/div/span[3]/span';

        foreach (range(1, 6) as $index) {
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerStartTimingXPath = sprintf($racerStartTimingFormat, $this->baseXPath, $this->baseLevel + 5, $index);

            $racerBoatNumber = $this->filterXPath($crawler, $racerBoatNumberXPath);
            $racerStartTiming = $this->filterXPath($crawler, $racerStartTimingXPath);

            $racerBoatNumber = Converter::int($racerBoatNumber);
            $racerStartTiming = Converter::startTiming($racerStartTiming);

            $response['courses'][$index]['racer_course_number'] = $index;
            $response['courses'][$index]['racer_boat_number'] = $racerBoatNumber;
            $response['courses'][$index]['racer_start_timing'] = $racerStartTiming;
        }

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlPlaces(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $racerPlaceNameFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[1]';
        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[2]';
        $racerNumberFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[3]/span[1]';
        $racerNameFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[3]/span[2]';

        foreach (range(1, 6) as $index) {
            $racerPlaceNameXPath = sprintf($racerPlaceNameFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerNumberXPath = sprintf($racerNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerNameXPath = sprintf($racerNameFormat, $this->baseXPath, $this->baseLevel + 5, $index);

            $racerPlaceName = $this->filterXPath($crawler, $racerPlaceNameXPath);
            $racerBoatNumber = $this->filterXPath($crawler, $racerBoatNumberXPath);
            $racerNumber = $this->filterXPath($crawler, $racerNumberXPath);
            $racerName = $this->filterXPath($crawler, $racerNameXPath);

            $racerPlaceId = Converter::placeId($racerPlaceName) ?? $index;
            $racerBoatNumber = Converter::int($racerBoatNumber);
            $racerNumber = Converter::int($racerNumber);
            $racerName = Converter::name($racerName);

            $response['places'][$racerPlaceId]['racer_place_id'] = $racerPlaceId;
            $response['places'][$racerPlaceId]['racer_boat_number'] = $racerBoatNumber;
            $response['places'][$racerPlaceId]['racer_number'] = $racerNumber;
            $response['places'][$racerPlaceId]['racer_name'] = $racerName;
        }

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlRefunds(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $refundFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr[%s]/td[%s]/span';
        $refundTypes = [
            'trifecta',
            'trio',
            'exacta',
            'quinella',
            'quinella_place',
            'win',
            'place',
        ];

        foreach ($refundTypes as $key => $value) {
            $response['refunds'][$value] = [];

            for ($trLevel = 1; $trLevel <= 10; $trLevel++) {
                $tdLevel = $trLevel === 1 ? 3 : 2;

                $refundXPath = sprintf($refundFormat, $this->baseXPath, $this->baseLevel + 6, $key + 1, $trLevel, $tdLevel);
                $refund = $this->filterXPath($crawler, $refundXPath);

                if (!str_starts_with($refund ?? '', '¥')) {
                    break;
                }

                $refund = str_replace('¥', '', $refund);
                $refund = str_replace(',', '', $refund);

                $response['refunds'][$value][] = Converter::int($refund);
            }
        }

        return $response;
    }
}
