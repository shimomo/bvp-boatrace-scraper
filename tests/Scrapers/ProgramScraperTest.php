<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use BVP\BoatraceScraper\Scrapers\ProgramScraper;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author shimomo
 */
final class ProgramScraperTest extends TestCase
{
    /**
     * @var \BVP\BoatraceScraper\Scrapers\ProgramScraper
     */
    protected ProgramScraper $scraper;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->scraper = new ProgramScraper(
            new HttpBrowser()
        );
    }

    /**
     * @return void
     */
    public function testScrapeWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = $this->scraper->scrape(Carbon::parse('2017-03-31'), 24, 1);
        $this->assertSame('2017-03-31', $response['race_date']);
        $this->assertSame(24, $response['race_stadium_number']);
        $this->assertSame(1, $response['race_number']);
        $this->assertSame('2017-03-31 12:00:00', $response['race_closed_at']);
        $this->assertSame('おおむら桜祭り競走', $response['race_title']);
        $this->assertSame('めざまし戦一般', $response['race_subtitle']);
        $this->assertSame(1800, $response['race_distance']);
        $this->assertSame(1, $response['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response['boats'][6]['racer_boat_number']);
        $this->assertSame(3833, $response['boats'][1]['racer_number']);
        $this->assertSame(3773, $response['boats'][2]['racer_number']);
        $this->assertSame(3471, $response['boats'][3]['racer_number']);
        $this->assertSame(4574, $response['boats'][4]['racer_number']);
        $this->assertSame(3800, $response['boats'][5]['racer_number']);
        $this->assertSame(4924, $response['boats'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response['boats'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response['boats'][2]['racer_name']);
        $this->assertSame('赤峰 和也', $response['boats'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response['boats'][4]['racer_name']);
        $this->assertSame('牧 宏次', $response['boats'][5]['racer_name']);
        $this->assertSame('中北 涼', $response['boats'][6]['racer_name']);
        $this->assertSame(42, $response['boats'][1]['racer_age']);
        $this->assertSame(42, $response['boats'][2]['racer_age']);
        $this->assertSame(47, $response['boats'][3]['racer_age']);
        $this->assertSame(28, $response['boats'][4]['racer_age']);
        $this->assertSame(43, $response['boats'][5]['racer_age']);
        $this->assertSame(24, $response['boats'][6]['racer_age']);
        $this->assertSame(54.0, $response['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response['boats'][6]['racer_weight']);
        $this->assertSame(1, $response['boats'][1]['racer_class_id']);
        $this->assertSame(3, $response['boats'][2]['racer_class_id']);
        $this->assertSame(3, $response['boats'][3]['racer_class_id']);
        $this->assertSame(3, $response['boats'][4]['racer_class_id']);
        $this->assertSame(3, $response['boats'][5]['racer_class_id']);
        $this->assertSame(4, $response['boats'][6]['racer_class_id']);
        $this->assertSame(18, $response['boats'][1]['racer_branch_id']);
        $this->assertSame(42, $response['boats'][2]['racer_branch_id']);
        $this->assertSame(41, $response['boats'][3]['racer_branch_id']);
        $this->assertSame(34, $response['boats'][4]['racer_branch_id']);
        $this->assertSame(13, $response['boats'][5]['racer_branch_id']);
        $this->assertSame(42, $response['boats'][6]['racer_branch_id']);
        $this->assertSame(18, $response['boats'][1]['racer_birthplace_id']);
        $this->assertSame(42, $response['boats'][2]['racer_birthplace_id']);
        $this->assertSame(41, $response['boats'][3]['racer_birthplace_id']);
        $this->assertSame(38, $response['boats'][4]['racer_birthplace_id']);
        $this->assertSame(14, $response['boats'][5]['racer_birthplace_id']);
        $this->assertSame(23, $response['boats'][6]['racer_birthplace_id']);
        $this->assertSame(1, $response['boats'][1]['racer_flying_count']);
        $this->assertSame(0, $response['boats'][2]['racer_flying_count']);
        $this->assertSame(0, $response['boats'][3]['racer_flying_count']);
        $this->assertSame(1, $response['boats'][4]['racer_flying_count']);
        $this->assertSame(0, $response['boats'][5]['racer_flying_count']);
        $this->assertSame(1, $response['boats'][6]['racer_flying_count']);
        $this->assertSame(0, $response['boats'][1]['racer_late_count']);
        $this->assertSame(0, $response['boats'][2]['racer_late_count']);
        $this->assertSame(0, $response['boats'][3]['racer_late_count']);
        $this->assertSame(0, $response['boats'][4]['racer_late_count']);
        $this->assertSame(0, $response['boats'][5]['racer_late_count']);
        $this->assertSame(0, $response['boats'][6]['racer_late_count']);
        $this->assertSame(0.13, $response['boats'][1]['racer_average_start_timing']);
        $this->assertSame(0.18, $response['boats'][2]['racer_average_start_timing']);
        $this->assertSame(0.21, $response['boats'][3]['racer_average_start_timing']);
        $this->assertSame(0.17, $response['boats'][4]['racer_average_start_timing']);
        $this->assertSame(0.20, $response['boats'][5]['racer_average_start_timing']);
        $this->assertSame(0.18, $response['boats'][6]['racer_average_start_timing']);
        $this->assertSame(6.45, $response['boats'][1]['racer_national_top_1_percent']);
        $this->assertSame(5.70, $response['boats'][2]['racer_national_top_1_percent']);
        $this->assertSame(4.13, $response['boats'][3]['racer_national_top_1_percent']);
        $this->assertSame(4.88, $response['boats'][4]['racer_national_top_1_percent']);
        $this->assertSame(5.05, $response['boats'][5]['racer_national_top_1_percent']);
        $this->assertSame(1.76, $response['boats'][6]['racer_national_top_1_percent']);
        $this->assertSame(45.36, $response['boats'][1]['racer_national_top_2_percent']);
        $this->assertSame(35.85, $response['boats'][2]['racer_national_top_2_percent']);
        $this->assertSame(16.50, $response['boats'][3]['racer_national_top_2_percent']);
        $this->assertSame(33.78, $response['boats'][4]['racer_national_top_2_percent']);
        $this->assertSame(34.48, $response['boats'][5]['racer_national_top_2_percent']);
        $this->assertSame(1.96, $response['boats'][6]['racer_national_top_2_percent']);
        $this->assertSame(65.98, $response['boats'][1]['racer_national_top_3_percent']);
        $this->assertSame(61.32, $response['boats'][2]['racer_national_top_3_percent']);
        $this->assertSame(33.01, $response['boats'][3]['racer_national_top_3_percent']);
        $this->assertSame(41.89, $response['boats'][4]['racer_national_top_3_percent']);
        $this->assertSame(45.98, $response['boats'][5]['racer_national_top_3_percent']);
        $this->assertSame(1.96, $response['boats'][6]['racer_national_top_3_percent']);
        $this->assertSame(7.78, $response['boats'][1]['racer_local_top_1_percent']);
        $this->assertSame(6.40, $response['boats'][2]['racer_local_top_1_percent']);
        $this->assertSame(3.95, $response['boats'][3]['racer_local_top_1_percent']);
        $this->assertSame(4.17, $response['boats'][4]['racer_local_top_1_percent']);
        $this->assertSame(5.00, $response['boats'][5]['racer_local_top_1_percent']);
        $this->assertSame(0.00, $response['boats'][6]['racer_local_top_1_percent']);
        $this->assertSame(55.56, $response['boats'][1]['racer_local_top_2_percent']);
        $this->assertSame(52.48, $response['boats'][2]['racer_local_top_2_percent']);
        $this->assertSame(14.29, $response['boats'][3]['racer_local_top_2_percent']);
        $this->assertSame(13.04, $response['boats'][4]['racer_local_top_2_percent']);
        $this->assertSame(37.50, $response['boats'][5]['racer_local_top_2_percent']);
        $this->assertSame(0.00, $response['boats'][6]['racer_local_top_2_percent']);
        $this->assertSame(77.78, $response['boats'][1]['racer_local_top_3_percent']);
        $this->assertSame(65.35, $response['boats'][2]['racer_local_top_3_percent']);
        $this->assertSame(33.33, $response['boats'][3]['racer_local_top_3_percent']);
        $this->assertSame(30.43, $response['boats'][4]['racer_local_top_3_percent']);
        $this->assertSame(37.50, $response['boats'][5]['racer_local_top_3_percent']);
        $this->assertSame(0.00, $response['boats'][6]['racer_local_top_3_percent']);
        $this->assertSame(66, $response['boats'][1]['racer_assigned_motor_number']);
        $this->assertSame(43, $response['boats'][2]['racer_assigned_motor_number']);
        $this->assertSame(59, $response['boats'][3]['racer_assigned_motor_number']);
        $this->assertSame(73, $response['boats'][4]['racer_assigned_motor_number']);
        $this->assertSame(52, $response['boats'][5]['racer_assigned_motor_number']);
        $this->assertSame(64, $response['boats'][6]['racer_assigned_motor_number']);
        $this->assertSame(88.89, $response['boats'][1]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(25.00, $response['boats'][2]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(33.33, $response['boats'][3]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(37.50, $response['boats'][4]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(0.00, $response['boats'][5]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(66.67, $response['boats'][6]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(100.00, $response['boats'][1]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(37.50, $response['boats'][2]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(44.44, $response['boats'][3]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(50.00, $response['boats'][4]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(0.00, $response['boats'][5]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(88.89, $response['boats'][6]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(71, $response['boats'][1]['racer_assigned_boat_number']);
        $this->assertSame(41, $response['boats'][2]['racer_assigned_boat_number']);
        $this->assertSame(67, $response['boats'][3]['racer_assigned_boat_number']);
        $this->assertSame(34, $response['boats'][4]['racer_assigned_boat_number']);
        $this->assertSame(65, $response['boats'][5]['racer_assigned_boat_number']);
        $this->assertSame(46, $response['boats'][6]['racer_assigned_boat_number']);
        $this->assertSame(37.14, $response['boats'][1]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(28.87, $response['boats'][2]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(30.71, $response['boats'][3]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(27.86, $response['boats'][4]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(39.57, $response['boats'][5]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(24.82, $response['boats'][6]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(55.00, $response['boats'][1]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(40.14, $response['boats'][2]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(50.71, $response['boats'][3]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.14, $response['boats'][4]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(56.83, $response['boats'][5]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.55, $response['boats'][6]['racer_assigned_boat_top_3_percent']);
    }

    /**
     * @return void
     */
    public function testScrapeWithDate20191014AndRaceStadiumCode2AndRaceCode1(): void
    {
        $response = $this->scraper->scrape(Carbon::parse('2019-10-14'), 2, 1);
        $this->assertSame('2019-10-14', $response['race_date']);
        $this->assertSame(2, $response['race_stadium_number']);
        $this->assertSame(1, $response['race_number']);
        $this->assertNull($response['race_closed_at']);
        $this->assertNull($response['race_title']);
        $this->assertNull($response['race_subtitle']);
        $this->assertNull($response['race_distance']);
        $this->assertSame(1, $response['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response['boats'][6]['racer_boat_number']);
        $this->assertNull($response['boats'][1]['racer_number']);
        $this->assertNull($response['boats'][2]['racer_number']);
        $this->assertNull($response['boats'][3]['racer_number']);
        $this->assertNull($response['boats'][4]['racer_number']);
        $this->assertNull($response['boats'][5]['racer_number']);
        $this->assertNull($response['boats'][6]['racer_number']);
        $this->assertNull($response['boats'][1]['racer_name']);
        $this->assertNull($response['boats'][2]['racer_name']);
        $this->assertNull($response['boats'][3]['racer_name']);
        $this->assertNull($response['boats'][4]['racer_name']);
        $this->assertNull($response['boats'][5]['racer_name']);
        $this->assertNull($response['boats'][6]['racer_name']);
        $this->assertNull($response['boats'][1]['racer_age']);
        $this->assertNull($response['boats'][2]['racer_age']);
        $this->assertNull($response['boats'][3]['racer_age']);
        $this->assertNull($response['boats'][4]['racer_age']);
        $this->assertNull($response['boats'][5]['racer_age']);
        $this->assertNull($response['boats'][6]['racer_age']);
        $this->assertNull($response['boats'][1]['racer_weight']);
        $this->assertNull($response['boats'][2]['racer_weight']);
        $this->assertNull($response['boats'][3]['racer_weight']);
        $this->assertNull($response['boats'][4]['racer_weight']);
        $this->assertNull($response['boats'][5]['racer_weight']);
        $this->assertNull($response['boats'][6]['racer_weight']);
        $this->assertNull($response['boats'][1]['racer_class_id']);
        $this->assertNull($response['boats'][2]['racer_class_id']);
        $this->assertNull($response['boats'][3]['racer_class_id']);
        $this->assertNull($response['boats'][4]['racer_class_id']);
        $this->assertNull($response['boats'][5]['racer_class_id']);
        $this->assertNull($response['boats'][6]['racer_class_id']);
        $this->assertNull($response['boats'][1]['racer_branch_id']);
        $this->assertNull($response['boats'][2]['racer_branch_id']);
        $this->assertNull($response['boats'][3]['racer_branch_id']);
        $this->assertNull($response['boats'][4]['racer_branch_id']);
        $this->assertNull($response['boats'][5]['racer_branch_id']);
        $this->assertNull($response['boats'][6]['racer_branch_id']);
        $this->assertNull($response['boats'][1]['racer_birthplace_id']);
        $this->assertNull($response['boats'][2]['racer_birthplace_id']);
        $this->assertNull($response['boats'][3]['racer_birthplace_id']);
        $this->assertNull($response['boats'][4]['racer_birthplace_id']);
        $this->assertNull($response['boats'][5]['racer_birthplace_id']);
        $this->assertNull($response['boats'][6]['racer_birthplace_id']);
        $this->assertNull($response['boats'][1]['racer_flying_count']);
        $this->assertNull($response['boats'][2]['racer_flying_count']);
        $this->assertNull($response['boats'][3]['racer_flying_count']);
        $this->assertNull($response['boats'][4]['racer_flying_count']);
        $this->assertNull($response['boats'][5]['racer_flying_count']);
        $this->assertNull($response['boats'][6]['racer_flying_count']);
        $this->assertNull($response['boats'][1]['racer_late_count']);
        $this->assertNull($response['boats'][2]['racer_late_count']);
        $this->assertNull($response['boats'][3]['racer_late_count']);
        $this->assertNull($response['boats'][4]['racer_late_count']);
        $this->assertNull($response['boats'][5]['racer_late_count']);
        $this->assertNull($response['boats'][6]['racer_late_count']);
        $this->assertNull($response['boats'][1]['racer_average_start_timing']);
        $this->assertNull($response['boats'][2]['racer_average_start_timing']);
        $this->assertNull($response['boats'][3]['racer_average_start_timing']);
        $this->assertNull($response['boats'][4]['racer_average_start_timing']);
        $this->assertNull($response['boats'][5]['racer_average_start_timing']);
        $this->assertNull($response['boats'][6]['racer_average_start_timing']);
        $this->assertNull($response['boats'][1]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][2]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][3]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][4]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][5]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][6]['racer_national_top_1_percent']);
        $this->assertNull($response['boats'][1]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][2]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][3]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][4]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][5]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][6]['racer_national_top_2_percent']);
        $this->assertNull($response['boats'][1]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][2]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][3]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][4]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][5]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][6]['racer_national_top_3_percent']);
        $this->assertNull($response['boats'][1]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][2]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][3]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][4]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][5]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][6]['racer_local_top_1_percent']);
        $this->assertNull($response['boats'][1]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][2]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][3]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][4]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][5]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][6]['racer_local_top_2_percent']);
        $this->assertNull($response['boats'][1]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][2]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][3]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][4]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][5]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][6]['racer_local_top_3_percent']);
        $this->assertNull($response['boats'][1]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][2]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][3]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][4]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][5]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][6]['racer_assigned_motor_number']);
        $this->assertNull($response['boats'][1]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][2]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][3]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][4]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][5]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][6]['racer_assigned_motor_top_2_percent']);
        $this->assertNull($response['boats'][1]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][2]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][3]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][4]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][5]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][6]['racer_assigned_motor_top_3_percent']);
        $this->assertNull($response['boats'][1]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][2]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][3]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][4]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][5]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][6]['racer_assigned_boat_number']);
        $this->assertNull($response['boats'][1]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][2]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][3]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][4]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][5]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][6]['racer_assigned_boat_top_2_percent']);
        $this->assertNull($response['boats'][1]['racer_assigned_boat_top_3_percent']);
        $this->assertNull($response['boats'][2]['racer_assigned_boat_top_3_percent']);
        $this->assertNull($response['boats'][3]['racer_assigned_boat_top_3_percent']);
        $this->assertNull($response['boats'][4]['racer_assigned_boat_top_3_percent']);
        $this->assertNull($response['boats'][5]['racer_assigned_boat_top_3_percent']);
        $this->assertNull($response['boats'][6]['racer_assigned_boat_top_3_percent']);
    }
}
