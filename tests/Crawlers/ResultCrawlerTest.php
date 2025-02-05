<?php

declare(strict_types=1);

namespace Boatrace\Venture\Project\Tests\Crawlers;

use Boatrace\Venture\Project\Crawlers\ResultCrawler;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
class ResultCrawlerTest extends TestCase
{
    /**
     * @var \Boatrace\Venture\Project\Crawlers\ResultCrawler
     */
    protected ResultCrawler $crawler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->crawler = new ResultCrawler(
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
        $this->assertSame(5, $response['race_wind']);
        $this->assertSame(11, $response['race_wind_direction_id']);
        $this->assertSame(4, $response['race_wave']);
        $this->assertSame(3, $response['race_weather_id']);
        $this->assertSame(13.0, $response['race_temperature']);
        $this->assertSame(14.0, $response['race_water_temperature']);
        $this->assertSame(1, $response['race_technique_id']);
        $this->assertSame(1, $response['places'][1]['racer_place_id']);
        $this->assertSame(2, $response['places'][2]['racer_place_id']);
        $this->assertSame(3, $response['places'][3]['racer_place_id']);
        $this->assertSame(4, $response['places'][4]['racer_place_id']);
        $this->assertSame(5, $response['places'][5]['racer_place_id']);
        $this->assertSame(6, $response['places'][6]['racer_place_id']);
        $this->assertSame(1, $response['places'][1]['racer_boat_number']);
        $this->assertSame(2, $response['places'][2]['racer_boat_number']);
        $this->assertSame(5, $response['places'][3]['racer_boat_number']);
        $this->assertSame(4, $response['places'][4]['racer_boat_number']);
        $this->assertSame(3, $response['places'][5]['racer_boat_number']);
        $this->assertSame(6, $response['places'][6]['racer_boat_number']);
        $this->assertSame(3833, $response['places'][1]['racer_number']);
        $this->assertSame(3773, $response['places'][2]['racer_number']);
        $this->assertSame(3800, $response['places'][3]['racer_number']);
        $this->assertSame(4574, $response['places'][4]['racer_number']);
        $this->assertSame(3471, $response['places'][5]['racer_number']);
        $this->assertSame(4924, $response['places'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response['places'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response['places'][2]['racer_name']);
        $this->assertSame('牧 宏次', $response['places'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response['places'][4]['racer_name']);
        $this->assertSame('赤峰 和也', $response['places'][5]['racer_name']);
        $this->assertSame('中北 涼', $response['places'][6]['racer_name']);
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
        $this->assertSame(0.25, $response['courses'][1]['racer_start_timing']);
        $this->assertSame(0.28, $response['courses'][2]['racer_start_timing']);
        $this->assertSame(0.31, $response['courses'][3]['racer_start_timing']);
        $this->assertSame(0.31, $response['courses'][4]['racer_start_timing']);
        $this->assertSame(0.23, $response['courses'][5]['racer_start_timing']);
        $this->assertSame(0.24, $response['courses'][6]['racer_start_timing']);
        $this->assertSame([460], $response['refunds']['trifecta']);
        $this->assertSame([320], $response['refunds']['trio']);
        $this->assertSame([180], $response['refunds']['exacta']);
        $this->assertSame([150], $response['refunds']['quinella']);
        $this->assertSame([110, 240, 280], $response['refunds']['quinella_place']);
        $this->assertSame([100], $response['refunds']['win']);
        $this->assertSame([100, 150], $response['refunds']['place']);
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
        $this->assertNull($response['race_technique_id']);
        $this->assertSame(1, $response['places'][1]['racer_place_id']);
        $this->assertSame(2, $response['places'][2]['racer_place_id']);
        $this->assertSame(3, $response['places'][3]['racer_place_id']);
        $this->assertSame(4, $response['places'][4]['racer_place_id']);
        $this->assertSame(5, $response['places'][5]['racer_place_id']);
        $this->assertSame(6, $response['places'][6]['racer_place_id']);
        $this->assertNull($response['places'][1]['racer_boat_number']);
        $this->assertNull($response['places'][2]['racer_boat_number']);
        $this->assertNull($response['places'][3]['racer_boat_number']);
        $this->assertNull($response['places'][4]['racer_boat_number']);
        $this->assertNull($response['places'][5]['racer_boat_number']);
        $this->assertNull($response['places'][6]['racer_boat_number']);
        $this->assertNull($response['places'][1]['racer_number']);
        $this->assertNull($response['places'][2]['racer_number']);
        $this->assertNull($response['places'][3]['racer_number']);
        $this->assertNull($response['places'][4]['racer_number']);
        $this->assertNull($response['places'][5]['racer_number']);
        $this->assertNull($response['places'][6]['racer_number']);
        $this->assertNull($response['places'][1]['racer_name']);
        $this->assertNull($response['places'][2]['racer_name']);
        $this->assertNull($response['places'][3]['racer_name']);
        $this->assertNull($response['places'][4]['racer_name']);
        $this->assertNull($response['places'][5]['racer_name']);
        $this->assertNull($response['places'][6]['racer_name']);
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
        $this->assertSame([], $response['refunds']['trifecta']);
        $this->assertSame([], $response['refunds']['trio']);
        $this->assertSame([], $response['refunds']['exacta']);
        $this->assertSame([], $response['refunds']['quinella']);
        $this->assertSame([], $response['refunds']['quinella_place']);
        $this->assertSame([], $response['refunds']['win']);
        $this->assertSame([], $response['refunds']['place']);
    }
}
