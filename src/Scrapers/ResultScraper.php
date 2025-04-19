<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Scrapers;

use BVP\Converter\Converter;
use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
class ResultScraper extends BaseScraper implements ResultScraperInterface
{
    /**
     * @var string
     */
    private string $baseXPath = 'descendant-or-self::body/main/div/div/div';

    /**
     * @param  \Carbon\CarbonInterface  $raceDate
     * @param  int                      $raceStadiumNumber
     * @param  int                      $raceNumber
     * @return array
     */
    public function scrape(CarbonInterface $raceDate, int $raceStadiumNumber, int $raceNumber): array
    {
        $response = [];

        $scraperFormat = '%s/owpc/pc/race/raceresult?hd=%s&jcd=%02d&rno=%d';
        $scraperUrl = sprintf($scraperFormat, $this->baseUrl, $raceDate->format('Ymd'), $raceStadiumNumber, $raceNumber);
        $scraper = $this->httpBrowser->request('GET', $scraperUrl);
        sleep($this->seconds);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (!is_null($this->filterXPath($scraper, $levelXPath))) {
            $this->baseLevel = 1;
        }

        $raceWindFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[3]/div/span[2]';
        $raceWindDirectionNumberFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[4]/p';
        $raceWaveFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[6]/div/span[2]';
        $raceWeatherNameFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[2]/div/span';
        $raceTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[1]/div/span[2]';
        $raceWaterTemperatureFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[1]/div/div[1]/div[5]/div/span[2]';
        $raceTechniqueNameFormat = '%s/div[2]/div[%s]/div[2]/div[1]/div[2]/div[2]/table/tbody/tr/td';

        $raceWindXPath = sprintf($raceWindFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWindDirectionNumberXPath = sprintf($raceWindDirectionNumberFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWaveXPath = sprintf($raceWaveFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWeatherNameXPath = sprintf($raceWeatherNameFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceTemperatureXPath = sprintf($raceTemperatureFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceWaterTemperatureXPath = sprintf($raceWaterTemperatureFormat, $this->baseXPath, $this->baseLevel + 6);
        $raceTechniqueNameXPath = sprintf($raceTechniqueNameFormat, $this->baseXPath, $this->baseLevel + 6);

        $raceWind = $this->filterXPath($scraper, $raceWindXPath);
        $raceWindDirectionNumber = $this->filterXPathForWindDirectionNumber($scraper, $raceWindDirectionNumberXPath);
        $raceWave = $this->filterXPath($scraper, $raceWaveXPath);
        $raceWeatherName = $this->filterXPath($scraper, $raceWeatherNameXPath);
        $raceTemperature = $this->filterXPath($scraper, $raceTemperatureXPath);
        $raceWaterTemperature = $this->filterXPath($scraper, $raceWaterTemperatureXPath);
        $raceTechniqueName = $this->filterXPath($scraper, $raceTechniqueNameXPath);

        $raceWind = Converter::parseWind($raceWind);
        $raceWindDirectionNumber = Converter::parseWindDirectionNumber($raceWindDirectionNumber);
        $raceWave = Converter::parseWave($raceWave);
        $raceWeatherNumber = Converter::convertToWeatherNumber($raceWeatherName);
        $raceTemperature = Converter::parseTemperature($raceTemperature);
        $raceWaterTemperature = Converter::parseTemperature($raceWaterTemperature);
        $raceTechniqueNumber = Converter::convertToTechniqueNumber($raceTechniqueName);

        $response['race_date'] = $raceDate->format('Y-m-d');
        $response['race_stadium_number'] = $raceStadiumNumber;
        $response['race_number'] = $raceNumber;
        $response['race_wind'] = $raceWind;
        $response['race_wind_direction_number'] = $raceWindDirectionNumber;
        $response['race_wave'] = $raceWave;
        $response['race_weather_number'] = $raceWeatherNumber;
        $response['race_temperature'] = $raceTemperature;
        $response['race_water_temperature'] = $raceWaterTemperature;
        $response['race_technique_number'] = $raceTechniqueNumber;

        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[2]/div/table/tbody/tr[%s]/td/div/span[1]';
        $racerStartTimingFormat = '%s/div[2]/div[%s]/div[2]/div/table/tbody/tr[%s]/td/div/span[3]/span';

        foreach (range(1, 6) as $courseNumber) {
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $courseNumber);
            $racerStartTimingXPath = sprintf($racerStartTimingFormat, $this->baseXPath, $this->baseLevel + 5, $courseNumber);

            $racerBoatNumber = $this->filterXPath($scraper, $racerBoatNumberXPath);
            $racerStartTiming = $this->filterXPath($scraper, $racerStartTimingXPath);

            $racerCourseNumber = is_null($racerBoatNumber) ? null : $courseNumber;
            $racerBoatNumber = Converter::convertToInt($racerBoatNumber) ?? $courseNumber;
            $racerStartTiming = Converter::parseStartTiming($racerStartTiming);

            $response['boats'][$racerBoatNumber]['racer_boat_number'] = $racerBoatNumber;
            $response['boats'][$racerBoatNumber]['racer_course_number'] = $racerCourseNumber;
            $response['boats'][$racerBoatNumber]['racer_start_timing'] = $racerStartTiming;
        }

        $racerPlaceNameFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[1]';
        $racerBoatNumberFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[2]';
        $racerNumberFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[3]/span[1]';
        $racerNameFormat = '%s/div[2]/div[%s]/div[1]/div/table/tbody[%s]/tr/td[3]/span[2]';

        foreach (range(1, 6) as $placeNumber) {
            $racerPlaceNameXPath = sprintf($racerPlaceNameFormat, $this->baseXPath, $this->baseLevel + 5, $placeNumber);
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $placeNumber);
            $racerNumberXPath = sprintf($racerNumberFormat, $this->baseXPath, $this->baseLevel + 5, $placeNumber);
            $racerNameXPath = sprintf($racerNameFormat, $this->baseXPath, $this->baseLevel + 5, $placeNumber);

            $racerPlaceName = $this->filterXPath($scraper, $racerPlaceNameXPath);
            $racerBoatNumber = $this->filterXPath($scraper, $racerBoatNumberXPath);
            $racerNumber = $this->filterXPath($scraper, $racerNumberXPath);
            $racerName = $this->filterXPath($scraper, $racerNameXPath);

            $racerPlaceNumber = Converter::convertToPlaceNumber($racerPlaceName);
            $racerBoatNumber = Converter::convertToInt($racerBoatNumber) ?? $placeNumber;
            $racerNumber = Converter::convertToInt($racerNumber);
            $racerName = Converter::convertToName($racerName);

            $response['boats'][$racerBoatNumber]['racer_boat_number'] = $racerBoatNumber;
            $response['boats'][$racerBoatNumber]['racer_place_number'] = $racerPlaceNumber;
            $response['boats'][$racerBoatNumber]['racer_number'] = $racerNumber;
            $response['boats'][$racerBoatNumber]['racer_name'] = $racerName;
        }

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
                $refund = $this->filterXPath($scraper, $refundXPath);

                if (!str_starts_with($refund ?? '', '¥')) {
                    break;
                }

                $refund = str_replace('¥', '', $refund);
                $refund = str_replace(',', '', $refund);

                $response['refunds'][$value][] = Converter::convertToInt($refund);
            }
        }

        return $response;
    }
}
