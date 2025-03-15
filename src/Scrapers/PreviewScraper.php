<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Scrapers;

use BVP\Converter\Converter;
use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
class PreviewScraper extends BaseScraper implements PreviewScraperInterface
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
    public function scrape(CarbonInterface $carbonDate, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $scraperFormat = '%s/owpc/pc/race/beforeinfo?hd=%s&jcd=%02d&rno=%d';
        $scraperUrl = sprintf($scraperFormat, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $scraper = $this->httpBrowser->request('GET', $scraperUrl);
        sleep($this->seconds);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (!is_null($this->filterXPath($scraper, $levelXPath))) {
            $this->baseLevel = 1;
        }

        $raceWindFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[3]/div/span[2]';
        $raceWindDirectionIdFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[4]/p';
        $raceWaveFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[6]/div/span[2]';
        $raceWeatherIdFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[2]/div/span';
        $raceTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[1]/div/span[2]';
        $raceWaterTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[2]/div[1]/div[5]/div/span[2]';

        $raceWindXPath = sprintf($raceWindFormat, $this->baseXPath, $this->baseLevel + 5);
        $raceWindDirectionIdXPath = sprintf($raceWindDirectionIdFormat, $this->baseXPath, $this->baseLevel + 5);
        $raceWaveXPath = sprintf($raceWaveFormat, $this->baseXPath, $this->baseLevel + 5);
        $raceWeatherNameXPath = sprintf($raceWeatherIdFormat, $this->baseXPath, $this->baseLevel + 5);
        $raceTemperatureXPath = sprintf($raceTemperatureFormat, $this->baseXPath, $this->baseLevel + 5);
        $raceWaterTemperatureXPath = sprintf($raceWaterTemperatureFormat, $this->baseXPath, $this->baseLevel + 5);

        $raceWind = $this->filterXPath($scraper, $raceWindXPath);
        $raceWindDirectionId = $this->filterXPathForWindDirectionId($scraper, $raceWindDirectionIdXPath);
        $raceWave = $this->filterXPath($scraper, $raceWaveXPath);
        $raceWeatherName = $this->filterXPath($scraper, $raceWeatherNameXPath);
        $raceTemperature = $this->filterXPath($scraper, $raceTemperatureXPath);
        $raceWaterTemperature = $this->filterXPath($scraper, $raceWaterTemperatureXPath);

        $raceWind = Converter::wind($raceWind);
        $raceWindDirectionId = Converter::windDirection($raceWindDirectionId);
        $raceWave = Converter::wave($raceWave);
        $raceWeatherId = Converter::weatherId($raceWeatherName);
        $raceTemperature = Converter::temperature($raceTemperature);
        $raceWaterTemperature = Converter::temperature($raceWaterTemperature);

        $response['race_date'] = $carbonDate->format('Y-m-d');
        $response['race_stadium_code'] = $raceStadiumCode;
        $response['race_code'] = $raceCode;
        $response['race_wind'] = $raceWind;
        $response['race_wind_direction_id'] = $raceWindDirectionId;
        $response['race_wave'] = $raceWave;
        $response['race_weather_id'] = $raceWeatherId;
        $response['race_temperature'] = $raceTemperature;
        $response['race_water_temperature'] = $raceWaterTemperature;

        $response += $this->scrapeBoats($scraper, $raceStadiumCode, $raceCode);
        $response += $this->scrapeCourses($scraper, $raceStadiumCode, $raceCode);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $scraper
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function scrapeBoats(Crawler $scraper, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[1]';
        $racerWeightFormat = '%s/div[2]/div[%s]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[4]';
        $racerWeightAdjustmentFormat = '%s/div[2]/div[%s]/div[1]/div[1]/table/tbody[%s]/tr[3]/td[1]';
        $racerExhibitionTimeFormat = '%s/div[2]/div[%s]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[5]';
        $racerTiltAdjustmentFormat = '%s/div[2]/div[%s]/div[1]/div[1]/table/tbody[%s]/tr[1]/td[6]';

        foreach (range(1, 6) as $index) {
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerWeightXPath = sprintf($racerWeightFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerWeightAdjustmentXPath = sprintf($racerWeightAdjustmentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerExhibitionTimeXPath = sprintf($racerExhibitionTimeFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerTiltAdjustmentXPath = sprintf($racerTiltAdjustmentFormat, $this->baseXPath, $this->baseLevel + 5, $index);

            $racerBoatNumber = $this->filterXPath($scraper, $racerBoatNumberXPath);
            $racerWeight = $this->filterXPath($scraper, $racerWeightXPath);
            $racerWeightAdjustment = $this->filterXPath($scraper, $racerWeightAdjustmentXPath);
            $racerExhibitionTime = $this->filterXPath($scraper, $racerExhibitionTimeXPath);
            $racerTiltAdjustment = $this->filterXPath($scraper, $racerTiltAdjustmentXPath);

            $racerBoatNumber = Converter::int($racerBoatNumber ?? $index);
            $racerWeight = Converter::float($racerWeight);
            $racerWeightAdjustment = Converter::float($racerWeightAdjustment);
            $racerExhibitionTime = Converter::float($racerExhibitionTime);
            $racerTiltAdjustment = Converter::float($racerTiltAdjustment);

            $response['boats'][$racerBoatNumber]['racer_boat_number'] = $racerBoatNumber;
            $response['boats'][$racerBoatNumber]['racer_weight'] = $racerWeight;
            $response['boats'][$racerBoatNumber]['racer_weight_adjustment'] = $racerWeightAdjustment;
            $response['boats'][$racerBoatNumber]['racer_exhibition_time'] = $racerExhibitionTime;
            $response['boats'][$racerBoatNumber]['racer_tilt_adjustment'] = $racerTiltAdjustment;
        }

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $scraper
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function scrapeCourses(Crawler $scraper, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[2]/div[1]/table/tbody/tr[%s]/td/div/span[1]';
        $racerStartTimingFormat = '%s/div[2]/div[%s]/div[2]/div[1]/table/tbody/tr[%s]/td/div/span[3]';

        foreach (range(1, 6) as $index) {
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerStartTimingXPath = sprintf($racerStartTimingFormat, $this->baseXPath, $this->baseLevel + 5, $index);

            $racerBoatNumber = $this->filterXPath($scraper, $racerBoatNumberXPath);
            $racerStartTiming = $this->filterXPath($scraper, $racerStartTimingXPath);

            $racerBoatNumber = Converter::int($racerBoatNumber);
            $racerStartTiming = Converter::startTiming($racerStartTiming);

            $response['courses'][$index]['racer_course_number'] = $index;
            $response['courses'][$index]['racer_boat_number'] = $racerBoatNumber;
            $response['courses'][$index]['racer_start_timing'] = $racerStartTiming;
        }

        return $response;
    }
}
