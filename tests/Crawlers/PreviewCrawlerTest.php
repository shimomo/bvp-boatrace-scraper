<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Tests\Crawlers;

use Boatrace\Venture\Project\Crawlers\PreviewCrawler;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class PreviewCrawlerTest extends TestCase
{
    /**
     * @var \Boatrace\Venture\Project\Crawlers\PreviewCrawler
     */
    protected PreviewCrawler $crawler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->crawler = new PreviewCrawler(
            new HttpBrowser()
        );
    }

    /**
     * @return void
     */
    public function testCrawlForDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = $this->crawler->crawl(Carbon::parse('2017-03-31'), 24, 1);
        $this->assertSame('2017-03-31', $response['race_date']);
        $this->assertSame(24, $response['race_stadium_code']);
        $this->assertSame(1, $response['race_code']);
        $this->assertSame(7, $response['race_wind']);
        $this->assertSame(11, $response['race_wind_direction_id']);
        $this->assertSame(6, $response['race_wave']);
        $this->assertSame(2, $response['race_weather_id']);
        $this->assertSame(13.0, $response['race_temperature']);
        $this->assertSame(14.0, $response['race_water_temperature']);
        $this->assertSame(1, $response['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response['boats'][6]['racer_boat_number']);
        $this->assertSame(54.0, $response['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response['boats'][6]['racer_weight']);
        $this->assertSame(0.0, $response['boats'][1]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response['boats'][2]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response['boats'][3]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response['boats'][4]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response['boats'][5]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response['boats'][6]['racer_weight_adjustment']);
        $this->assertSame(6.86, $response['boats'][1]['racer_exhibition_time']);
        $this->assertSame(6.89, $response['boats'][2]['racer_exhibition_time']);
        $this->assertSame(6.88, $response['boats'][3]['racer_exhibition_time']);
        $this->assertSame(6.80, $response['boats'][4]['racer_exhibition_time']);
        $this->assertSame(6.81, $response['boats'][5]['racer_exhibition_time']);
        $this->assertSame(6.76, $response['boats'][6]['racer_exhibition_time']);
        $this->assertSame(-0.5, $response['boats'][1]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response['boats'][2]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response['boats'][3]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response['boats'][4]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response['boats'][5]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response['boats'][6]['racer_tilt_adjustment']);
        $this->assertSame(1, $response['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response['courses'][6]['racer_boat_number']);
        $this->assertSame(0.15, $response['courses'][1]['racer_start_timing']);
        $this->assertSame(0.22, $response['courses'][2]['racer_start_timing']);
        $this->assertSame(0.19, $response['courses'][3]['racer_start_timing']);
        $this->assertSame(0.18, $response['courses'][4]['racer_start_timing']);
        $this->assertSame(0.05, $response['courses'][5]['racer_start_timing']);
        $this->assertSame(0.11, $response['courses'][6]['racer_start_timing']);
    }

    /**
     * @return void
     */
    public function testCrawlForDate20191014AndRaceStadiumCode2AndRaceCode1(): void
    {
        $response = $this->crawler->crawl(Carbon::parse('2019-10-14'), 2, 1);
        $this->assertSame('2019-10-14', $response['race_date']);
        $this->assertSame(2, $response['race_stadium_code']);
        $this->assertSame(1, $response['race_code']);
        $this->assertNull($response['race_wind']);
        $this->assertNull($response['race_wind_direction_id']);
        $this->assertNull($response['race_wave']);
        $this->assertNull($response['race_weather_id']);
        $this->assertNull($response['race_temperature']);
        $this->assertNull($response['race_water_temperature']);
        $this->assertSame(1, $response['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response['boats'][6]['racer_boat_number']);
        $this->assertNull($response['boats'][1]['racer_weight']);
        $this->assertNull($response['boats'][2]['racer_weight']);
        $this->assertNull($response['boats'][3]['racer_weight']);
        $this->assertNull($response['boats'][4]['racer_weight']);
        $this->assertNull($response['boats'][5]['racer_weight']);
        $this->assertNull($response['boats'][6]['racer_weight']);
        $this->assertNull($response['boats'][1]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][2]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][3]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][4]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][5]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][6]['racer_weight_adjustment']);
        $this->assertNull($response['boats'][1]['racer_exhibition_time']);
        $this->assertNull($response['boats'][2]['racer_exhibition_time']);
        $this->assertNull($response['boats'][3]['racer_exhibition_time']);
        $this->assertNull($response['boats'][4]['racer_exhibition_time']);
        $this->assertNull($response['boats'][5]['racer_exhibition_time']);
        $this->assertNull($response['boats'][6]['racer_exhibition_time']);
        $this->assertNull($response['boats'][1]['racer_tilt_adjustment']);
        $this->assertNull($response['boats'][2]['racer_tilt_adjustment']);
        $this->assertNull($response['boats'][3]['racer_tilt_adjustment']);
        $this->assertNull($response['boats'][4]['racer_tilt_adjustment']);
        $this->assertNull($response['boats'][5]['racer_tilt_adjustment']);
        $this->assertNull($response['boats'][6]['racer_tilt_adjustment']);
        $this->assertSame(1, $response['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response['courses'][6]['racer_course_number']);
        $this->assertNull($response['courses'][1]['racer_boat_number']);
        $this->assertNull($response['courses'][2]['racer_boat_number']);
        $this->assertNull($response['courses'][3]['racer_boat_number']);
        $this->assertNull($response['courses'][4]['racer_boat_number']);
        $this->assertNull($response['courses'][5]['racer_boat_number']);
        $this->assertNull($response['courses'][6]['racer_boat_number']);
        $this->assertNull($response['courses'][1]['racer_start_timing']);
        $this->assertNull($response['courses'][2]['racer_start_timing']);
        $this->assertNull($response['courses'][3]['racer_start_timing']);
        $this->assertNull($response['courses'][4]['racer_start_timing']);
        $this->assertNull($response['courses'][5]['racer_start_timing']);
        $this->assertNull($response['courses'][6]['racer_start_timing']);
    }
}
