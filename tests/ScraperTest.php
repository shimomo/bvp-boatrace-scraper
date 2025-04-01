<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests;

use BVP\BoatraceScraper\Scraper;
use BVP\BoatraceScraper\ScraperInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class ScraperTest extends TestCase
{
    /**
     * @var array
     */
    protected array $stadiums = [
        4 => '平和島',
        5 => '多摩川',
        6 => '浜名湖',
        10 => '三国',
        15 => '丸亀',
        18 => '徳山',
        23 => '唐津',
        24 => '大村',
    ];

    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = Scraper::scrapePrograms('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame('2017-03-31 12:00:00', $response[24][1]['race_closed_at']);
        $this->assertSame('おおむら桜祭り競走', $response[24][1]['race_title']);
        $this->assertSame('めざまし戦一般', $response[24][1]['race_subtitle']);
        $this->assertSame(1800, $response[24][1]['race_distance']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['boats'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['boats'][2]['racer_number']);
        $this->assertSame(3471, $response[24][1]['boats'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['boats'][4]['racer_number']);
        $this->assertSame(3800, $response[24][1]['boats'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['boats'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['boats'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['boats'][2]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['boats'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['boats'][4]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['boats'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['boats'][6]['racer_name']);
        $this->assertSame(42, $response[24][1]['boats'][1]['racer_age']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_age']);
        $this->assertSame(47, $response[24][1]['boats'][3]['racer_age']);
        $this->assertSame(28, $response[24][1]['boats'][4]['racer_age']);
        $this->assertSame(43, $response[24][1]['boats'][5]['racer_age']);
        $this->assertSame(24, $response[24][1]['boats'][6]['racer_age']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][2]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][4]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][5]['racer_class_number']);
        $this->assertSame(4, $response[24][1]['boats'][6]['racer_class_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_branch_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_branch_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_branch_number']);
        $this->assertSame(13, $response[24][1]['boats'][5]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][6]['racer_branch_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_birthplace_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_birthplace_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_birthplace_number']);
        $this->assertSame(38, $response[24][1]['boats'][4]['racer_birthplace_number']);
        $this->assertSame(14, $response[24][1]['boats'][5]['racer_birthplace_number']);
        $this->assertSame(23, $response[24][1]['boats'][6]['racer_birthplace_number']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][4]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][6]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][1]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][4]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][6]['racer_late_count']);
        $this->assertSame(0.13, $response[24][1]['boats'][1]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][2]['racer_average_start_timing']);
        $this->assertSame(0.21, $response[24][1]['boats'][3]['racer_average_start_timing']);
        $this->assertSame(0.17, $response[24][1]['boats'][4]['racer_average_start_timing']);
        $this->assertSame(0.20, $response[24][1]['boats'][5]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][6]['racer_average_start_timing']);
        $this->assertSame(6.45, $response[24][1]['boats'][1]['racer_national_top_1_percent']);
        $this->assertSame(5.70, $response[24][1]['boats'][2]['racer_national_top_1_percent']);
        $this->assertSame(4.13, $response[24][1]['boats'][3]['racer_national_top_1_percent']);
        $this->assertSame(4.88, $response[24][1]['boats'][4]['racer_national_top_1_percent']);
        $this->assertSame(5.05, $response[24][1]['boats'][5]['racer_national_top_1_percent']);
        $this->assertSame(1.76, $response[24][1]['boats'][6]['racer_national_top_1_percent']);
        $this->assertSame(45.36, $response[24][1]['boats'][1]['racer_national_top_2_percent']);
        $this->assertSame(35.85, $response[24][1]['boats'][2]['racer_national_top_2_percent']);
        $this->assertSame(16.50, $response[24][1]['boats'][3]['racer_national_top_2_percent']);
        $this->assertSame(33.78, $response[24][1]['boats'][4]['racer_national_top_2_percent']);
        $this->assertSame(34.48, $response[24][1]['boats'][5]['racer_national_top_2_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_2_percent']);
        $this->assertSame(65.98, $response[24][1]['boats'][1]['racer_national_top_3_percent']);
        $this->assertSame(61.32, $response[24][1]['boats'][2]['racer_national_top_3_percent']);
        $this->assertSame(33.01, $response[24][1]['boats'][3]['racer_national_top_3_percent']);
        $this->assertSame(41.89, $response[24][1]['boats'][4]['racer_national_top_3_percent']);
        $this->assertSame(45.98, $response[24][1]['boats'][5]['racer_national_top_3_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_3_percent']);
        $this->assertSame(7.78, $response[24][1]['boats'][1]['racer_local_top_1_percent']);
        $this->assertSame(6.40, $response[24][1]['boats'][2]['racer_local_top_1_percent']);
        $this->assertSame(3.95, $response[24][1]['boats'][3]['racer_local_top_1_percent']);
        $this->assertSame(4.17, $response[24][1]['boats'][4]['racer_local_top_1_percent']);
        $this->assertSame(5.00, $response[24][1]['boats'][5]['racer_local_top_1_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_1_percent']);
        $this->assertSame(55.56, $response[24][1]['boats'][1]['racer_local_top_2_percent']);
        $this->assertSame(52.48, $response[24][1]['boats'][2]['racer_local_top_2_percent']);
        $this->assertSame(14.29, $response[24][1]['boats'][3]['racer_local_top_2_percent']);
        $this->assertSame(13.04, $response[24][1]['boats'][4]['racer_local_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_2_percent']);
        $this->assertSame(77.78, $response[24][1]['boats'][1]['racer_local_top_3_percent']);
        $this->assertSame(65.35, $response[24][1]['boats'][2]['racer_local_top_3_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_local_top_3_percent']);
        $this->assertSame(30.43, $response[24][1]['boats'][4]['racer_local_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_3_percent']);
        $this->assertSame(66, $response[24][1]['boats'][1]['racer_assigned_motor_number']);
        $this->assertSame(43, $response[24][1]['boats'][2]['racer_assigned_motor_number']);
        $this->assertSame(59, $response[24][1]['boats'][3]['racer_assigned_motor_number']);
        $this->assertSame(73, $response[24][1]['boats'][4]['racer_assigned_motor_number']);
        $this->assertSame(52, $response[24][1]['boats'][5]['racer_assigned_motor_number']);
        $this->assertSame(64, $response[24][1]['boats'][6]['racer_assigned_motor_number']);
        $this->assertSame(88.89, $response[24][1]['boats'][1]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(25.00, $response[24][1]['boats'][2]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][4]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(66.67, $response[24][1]['boats'][6]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(100.00, $response[24][1]['boats'][1]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][2]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(44.44, $response[24][1]['boats'][3]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(50.00, $response[24][1]['boats'][4]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(88.89, $response[24][1]['boats'][6]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(71, $response[24][1]['boats'][1]['racer_assigned_boat_number']);
        $this->assertSame(41, $response[24][1]['boats'][2]['racer_assigned_boat_number']);
        $this->assertSame(67, $response[24][1]['boats'][3]['racer_assigned_boat_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_assigned_boat_number']);
        $this->assertSame(65, $response[24][1]['boats'][5]['racer_assigned_boat_number']);
        $this->assertSame(46, $response[24][1]['boats'][6]['racer_assigned_boat_number']);
        $this->assertSame(37.14, $response[24][1]['boats'][1]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(28.87, $response[24][1]['boats'][2]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(30.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(27.86, $response[24][1]['boats'][4]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(39.57, $response[24][1]['boats'][5]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(24.82, $response[24][1]['boats'][6]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(55.00, $response[24][1]['boats'][1]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(40.14, $response[24][1]['boats'][2]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(50.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.14, $response[24][1]['boats'][4]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(56.83, $response[24][1]['boats'][5]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.55, $response[24][1]['boats'][6]['racer_assigned_boat_top_3_percent']);
    }

    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceCode1(): void
    {
        $response = Scraper::scrapePrograms('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame('2017-03-31 12:00:00', $response[24][1]['race_closed_at']);
        $this->assertSame('おおむら桜祭り競走', $response[24][1]['race_title']);
        $this->assertSame('めざまし戦一般', $response[24][1]['race_subtitle']);
        $this->assertSame(1800, $response[24][1]['race_distance']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['boats'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['boats'][2]['racer_number']);
        $this->assertSame(3471, $response[24][1]['boats'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['boats'][4]['racer_number']);
        $this->assertSame(3800, $response[24][1]['boats'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['boats'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['boats'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['boats'][2]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['boats'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['boats'][4]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['boats'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['boats'][6]['racer_name']);
        $this->assertSame(42, $response[24][1]['boats'][1]['racer_age']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_age']);
        $this->assertSame(47, $response[24][1]['boats'][3]['racer_age']);
        $this->assertSame(28, $response[24][1]['boats'][4]['racer_age']);
        $this->assertSame(43, $response[24][1]['boats'][5]['racer_age']);
        $this->assertSame(24, $response[24][1]['boats'][6]['racer_age']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][2]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][4]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][5]['racer_class_number']);
        $this->assertSame(4, $response[24][1]['boats'][6]['racer_class_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_branch_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_branch_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_branch_number']);
        $this->assertSame(13, $response[24][1]['boats'][5]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][6]['racer_branch_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_birthplace_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_birthplace_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_birthplace_number']);
        $this->assertSame(38, $response[24][1]['boats'][4]['racer_birthplace_number']);
        $this->assertSame(14, $response[24][1]['boats'][5]['racer_birthplace_number']);
        $this->assertSame(23, $response[24][1]['boats'][6]['racer_birthplace_number']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][4]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][6]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][1]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][4]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][6]['racer_late_count']);
        $this->assertSame(0.13, $response[24][1]['boats'][1]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][2]['racer_average_start_timing']);
        $this->assertSame(0.21, $response[24][1]['boats'][3]['racer_average_start_timing']);
        $this->assertSame(0.17, $response[24][1]['boats'][4]['racer_average_start_timing']);
        $this->assertSame(0.20, $response[24][1]['boats'][5]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][6]['racer_average_start_timing']);
        $this->assertSame(6.45, $response[24][1]['boats'][1]['racer_national_top_1_percent']);
        $this->assertSame(5.70, $response[24][1]['boats'][2]['racer_national_top_1_percent']);
        $this->assertSame(4.13, $response[24][1]['boats'][3]['racer_national_top_1_percent']);
        $this->assertSame(4.88, $response[24][1]['boats'][4]['racer_national_top_1_percent']);
        $this->assertSame(5.05, $response[24][1]['boats'][5]['racer_national_top_1_percent']);
        $this->assertSame(1.76, $response[24][1]['boats'][6]['racer_national_top_1_percent']);
        $this->assertSame(45.36, $response[24][1]['boats'][1]['racer_national_top_2_percent']);
        $this->assertSame(35.85, $response[24][1]['boats'][2]['racer_national_top_2_percent']);
        $this->assertSame(16.50, $response[24][1]['boats'][3]['racer_national_top_2_percent']);
        $this->assertSame(33.78, $response[24][1]['boats'][4]['racer_national_top_2_percent']);
        $this->assertSame(34.48, $response[24][1]['boats'][5]['racer_national_top_2_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_2_percent']);
        $this->assertSame(65.98, $response[24][1]['boats'][1]['racer_national_top_3_percent']);
        $this->assertSame(61.32, $response[24][1]['boats'][2]['racer_national_top_3_percent']);
        $this->assertSame(33.01, $response[24][1]['boats'][3]['racer_national_top_3_percent']);
        $this->assertSame(41.89, $response[24][1]['boats'][4]['racer_national_top_3_percent']);
        $this->assertSame(45.98, $response[24][1]['boats'][5]['racer_national_top_3_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_3_percent']);
        $this->assertSame(7.78, $response[24][1]['boats'][1]['racer_local_top_1_percent']);
        $this->assertSame(6.40, $response[24][1]['boats'][2]['racer_local_top_1_percent']);
        $this->assertSame(3.95, $response[24][1]['boats'][3]['racer_local_top_1_percent']);
        $this->assertSame(4.17, $response[24][1]['boats'][4]['racer_local_top_1_percent']);
        $this->assertSame(5.00, $response[24][1]['boats'][5]['racer_local_top_1_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_1_percent']);
        $this->assertSame(55.56, $response[24][1]['boats'][1]['racer_local_top_2_percent']);
        $this->assertSame(52.48, $response[24][1]['boats'][2]['racer_local_top_2_percent']);
        $this->assertSame(14.29, $response[24][1]['boats'][3]['racer_local_top_2_percent']);
        $this->assertSame(13.04, $response[24][1]['boats'][4]['racer_local_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_2_percent']);
        $this->assertSame(77.78, $response[24][1]['boats'][1]['racer_local_top_3_percent']);
        $this->assertSame(65.35, $response[24][1]['boats'][2]['racer_local_top_3_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_local_top_3_percent']);
        $this->assertSame(30.43, $response[24][1]['boats'][4]['racer_local_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_3_percent']);
        $this->assertSame(66, $response[24][1]['boats'][1]['racer_assigned_motor_number']);
        $this->assertSame(43, $response[24][1]['boats'][2]['racer_assigned_motor_number']);
        $this->assertSame(59, $response[24][1]['boats'][3]['racer_assigned_motor_number']);
        $this->assertSame(73, $response[24][1]['boats'][4]['racer_assigned_motor_number']);
        $this->assertSame(52, $response[24][1]['boats'][5]['racer_assigned_motor_number']);
        $this->assertSame(64, $response[24][1]['boats'][6]['racer_assigned_motor_number']);
        $this->assertSame(88.89, $response[24][1]['boats'][1]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(25.00, $response[24][1]['boats'][2]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][4]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(66.67, $response[24][1]['boats'][6]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(100.00, $response[24][1]['boats'][1]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][2]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(44.44, $response[24][1]['boats'][3]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(50.00, $response[24][1]['boats'][4]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(88.89, $response[24][1]['boats'][6]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(71, $response[24][1]['boats'][1]['racer_assigned_boat_number']);
        $this->assertSame(41, $response[24][1]['boats'][2]['racer_assigned_boat_number']);
        $this->assertSame(67, $response[24][1]['boats'][3]['racer_assigned_boat_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_assigned_boat_number']);
        $this->assertSame(65, $response[24][1]['boats'][5]['racer_assigned_boat_number']);
        $this->assertSame(46, $response[24][1]['boats'][6]['racer_assigned_boat_number']);
        $this->assertSame(37.14, $response[24][1]['boats'][1]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(28.87, $response[24][1]['boats'][2]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(30.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(27.86, $response[24][1]['boats'][4]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(39.57, $response[24][1]['boats'][5]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(24.82, $response[24][1]['boats'][6]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(55.00, $response[24][1]['boats'][1]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(40.14, $response[24][1]['boats'][2]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(50.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.14, $response[24][1]['boats'][4]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(56.83, $response[24][1]['boats'][5]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.55, $response[24][1]['boats'][6]['racer_assigned_boat_top_3_percent']);
    }

    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = Scraper::scrapePrograms('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame('2017-03-31 12:00:00', $response[24][1]['race_closed_at']);
        $this->assertSame('おおむら桜祭り競走', $response[24][1]['race_title']);
        $this->assertSame('めざまし戦一般', $response[24][1]['race_subtitle']);
        $this->assertSame(1800, $response[24][1]['race_distance']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['boats'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['boats'][2]['racer_number']);
        $this->assertSame(3471, $response[24][1]['boats'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['boats'][4]['racer_number']);
        $this->assertSame(3800, $response[24][1]['boats'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['boats'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['boats'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['boats'][2]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['boats'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['boats'][4]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['boats'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['boats'][6]['racer_name']);
        $this->assertSame(42, $response[24][1]['boats'][1]['racer_age']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_age']);
        $this->assertSame(47, $response[24][1]['boats'][3]['racer_age']);
        $this->assertSame(28, $response[24][1]['boats'][4]['racer_age']);
        $this->assertSame(43, $response[24][1]['boats'][5]['racer_age']);
        $this->assertSame(24, $response[24][1]['boats'][6]['racer_age']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][2]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][4]['racer_class_number']);
        $this->assertSame(3, $response[24][1]['boats'][5]['racer_class_number']);
        $this->assertSame(4, $response[24][1]['boats'][6]['racer_class_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_branch_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_branch_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_branch_number']);
        $this->assertSame(13, $response[24][1]['boats'][5]['racer_branch_number']);
        $this->assertSame(42, $response[24][1]['boats'][6]['racer_branch_number']);
        $this->assertSame(18, $response[24][1]['boats'][1]['racer_birthplace_number']);
        $this->assertSame(42, $response[24][1]['boats'][2]['racer_birthplace_number']);
        $this->assertSame(41, $response[24][1]['boats'][3]['racer_birthplace_number']);
        $this->assertSame(38, $response[24][1]['boats'][4]['racer_birthplace_number']);
        $this->assertSame(14, $response[24][1]['boats'][5]['racer_birthplace_number']);
        $this->assertSame(23, $response[24][1]['boats'][6]['racer_birthplace_number']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][4]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_flying_count']);
        $this->assertSame(1, $response[24][1]['boats'][6]['racer_flying_count']);
        $this->assertSame(0, $response[24][1]['boats'][1]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][2]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][3]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][4]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][5]['racer_late_count']);
        $this->assertSame(0, $response[24][1]['boats'][6]['racer_late_count']);
        $this->assertSame(0.13, $response[24][1]['boats'][1]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][2]['racer_average_start_timing']);
        $this->assertSame(0.21, $response[24][1]['boats'][3]['racer_average_start_timing']);
        $this->assertSame(0.17, $response[24][1]['boats'][4]['racer_average_start_timing']);
        $this->assertSame(0.20, $response[24][1]['boats'][5]['racer_average_start_timing']);
        $this->assertSame(0.18, $response[24][1]['boats'][6]['racer_average_start_timing']);
        $this->assertSame(6.45, $response[24][1]['boats'][1]['racer_national_top_1_percent']);
        $this->assertSame(5.70, $response[24][1]['boats'][2]['racer_national_top_1_percent']);
        $this->assertSame(4.13, $response[24][1]['boats'][3]['racer_national_top_1_percent']);
        $this->assertSame(4.88, $response[24][1]['boats'][4]['racer_national_top_1_percent']);
        $this->assertSame(5.05, $response[24][1]['boats'][5]['racer_national_top_1_percent']);
        $this->assertSame(1.76, $response[24][1]['boats'][6]['racer_national_top_1_percent']);
        $this->assertSame(45.36, $response[24][1]['boats'][1]['racer_national_top_2_percent']);
        $this->assertSame(35.85, $response[24][1]['boats'][2]['racer_national_top_2_percent']);
        $this->assertSame(16.50, $response[24][1]['boats'][3]['racer_national_top_2_percent']);
        $this->assertSame(33.78, $response[24][1]['boats'][4]['racer_national_top_2_percent']);
        $this->assertSame(34.48, $response[24][1]['boats'][5]['racer_national_top_2_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_2_percent']);
        $this->assertSame(65.98, $response[24][1]['boats'][1]['racer_national_top_3_percent']);
        $this->assertSame(61.32, $response[24][1]['boats'][2]['racer_national_top_3_percent']);
        $this->assertSame(33.01, $response[24][1]['boats'][3]['racer_national_top_3_percent']);
        $this->assertSame(41.89, $response[24][1]['boats'][4]['racer_national_top_3_percent']);
        $this->assertSame(45.98, $response[24][1]['boats'][5]['racer_national_top_3_percent']);
        $this->assertSame(1.96, $response[24][1]['boats'][6]['racer_national_top_3_percent']);
        $this->assertSame(7.78, $response[24][1]['boats'][1]['racer_local_top_1_percent']);
        $this->assertSame(6.40, $response[24][1]['boats'][2]['racer_local_top_1_percent']);
        $this->assertSame(3.95, $response[24][1]['boats'][3]['racer_local_top_1_percent']);
        $this->assertSame(4.17, $response[24][1]['boats'][4]['racer_local_top_1_percent']);
        $this->assertSame(5.00, $response[24][1]['boats'][5]['racer_local_top_1_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_1_percent']);
        $this->assertSame(55.56, $response[24][1]['boats'][1]['racer_local_top_2_percent']);
        $this->assertSame(52.48, $response[24][1]['boats'][2]['racer_local_top_2_percent']);
        $this->assertSame(14.29, $response[24][1]['boats'][3]['racer_local_top_2_percent']);
        $this->assertSame(13.04, $response[24][1]['boats'][4]['racer_local_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_2_percent']);
        $this->assertSame(77.78, $response[24][1]['boats'][1]['racer_local_top_3_percent']);
        $this->assertSame(65.35, $response[24][1]['boats'][2]['racer_local_top_3_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_local_top_3_percent']);
        $this->assertSame(30.43, $response[24][1]['boats'][4]['racer_local_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][5]['racer_local_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][6]['racer_local_top_3_percent']);
        $this->assertSame(66, $response[24][1]['boats'][1]['racer_assigned_motor_number']);
        $this->assertSame(43, $response[24][1]['boats'][2]['racer_assigned_motor_number']);
        $this->assertSame(59, $response[24][1]['boats'][3]['racer_assigned_motor_number']);
        $this->assertSame(73, $response[24][1]['boats'][4]['racer_assigned_motor_number']);
        $this->assertSame(52, $response[24][1]['boats'][5]['racer_assigned_motor_number']);
        $this->assertSame(64, $response[24][1]['boats'][6]['racer_assigned_motor_number']);
        $this->assertSame(88.89, $response[24][1]['boats'][1]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(25.00, $response[24][1]['boats'][2]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(33.33, $response[24][1]['boats'][3]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][4]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(66.67, $response[24][1]['boats'][6]['racer_assigned_motor_top_2_percent']);
        $this->assertSame(100.00, $response[24][1]['boats'][1]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(37.50, $response[24][1]['boats'][2]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(44.44, $response[24][1]['boats'][3]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(50.00, $response[24][1]['boats'][4]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(0.00, $response[24][1]['boats'][5]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(88.89, $response[24][1]['boats'][6]['racer_assigned_motor_top_3_percent']);
        $this->assertSame(71, $response[24][1]['boats'][1]['racer_assigned_boat_number']);
        $this->assertSame(41, $response[24][1]['boats'][2]['racer_assigned_boat_number']);
        $this->assertSame(67, $response[24][1]['boats'][3]['racer_assigned_boat_number']);
        $this->assertSame(34, $response[24][1]['boats'][4]['racer_assigned_boat_number']);
        $this->assertSame(65, $response[24][1]['boats'][5]['racer_assigned_boat_number']);
        $this->assertSame(46, $response[24][1]['boats'][6]['racer_assigned_boat_number']);
        $this->assertSame(37.14, $response[24][1]['boats'][1]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(28.87, $response[24][1]['boats'][2]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(30.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(27.86, $response[24][1]['boats'][4]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(39.57, $response[24][1]['boats'][5]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(24.82, $response[24][1]['boats'][6]['racer_assigned_boat_top_2_percent']);
        $this->assertSame(55.00, $response[24][1]['boats'][1]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(40.14, $response[24][1]['boats'][2]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(50.71, $response[24][1]['boats'][3]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.14, $response[24][1]['boats'][4]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(56.83, $response[24][1]['boats'][5]['racer_assigned_boat_top_3_percent']);
        $this->assertSame(42.55, $response[24][1]['boats'][6]['racer_assigned_boat_top_3_percent']);
    }

    /**
     * @return void
     */
    public function testPreviewsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = Scraper::scrapePreviews('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(7, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(6, $response[24][1]['race_wave']);
        $this->assertSame(2, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.15, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.22, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.19, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.18, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.05, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.11, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(0.0, $response[24][1]['boats'][1]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][2]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][3]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][4]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][5]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][6]['racer_weight_adjustment']);
        $this->assertSame(6.86, $response[24][1]['boats'][1]['racer_exhibition_time']);
        $this->assertSame(6.89, $response[24][1]['boats'][2]['racer_exhibition_time']);
        $this->assertSame(6.88, $response[24][1]['boats'][3]['racer_exhibition_time']);
        $this->assertSame(6.80, $response[24][1]['boats'][4]['racer_exhibition_time']);
        $this->assertSame(6.81, $response[24][1]['boats'][5]['racer_exhibition_time']);
        $this->assertSame(6.76, $response[24][1]['boats'][6]['racer_exhibition_time']);
        $this->assertSame(-0.5, $response[24][1]['boats'][1]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][2]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][3]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][4]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][5]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][6]['racer_tilt_adjustment']);
    }

    /**
     * @return void
     */
    public function testPreviewaWithDate20170331AndRaceCode1(): void
    {
        $response = Scraper::scrapePreviews('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(7, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(6, $response[24][1]['race_wave']);
        $this->assertSame(2, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.15, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.22, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.19, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.18, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.05, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.11, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(0.0, $response[24][1]['boats'][1]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][2]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][3]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][4]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][5]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][6]['racer_weight_adjustment']);
        $this->assertSame(6.86, $response[24][1]['boats'][1]['racer_exhibition_time']);
        $this->assertSame(6.89, $response[24][1]['boats'][2]['racer_exhibition_time']);
        $this->assertSame(6.88, $response[24][1]['boats'][3]['racer_exhibition_time']);
        $this->assertSame(6.80, $response[24][1]['boats'][4]['racer_exhibition_time']);
        $this->assertSame(6.81, $response[24][1]['boats'][5]['racer_exhibition_time']);
        $this->assertSame(6.76, $response[24][1]['boats'][6]['racer_exhibition_time']);
        $this->assertSame(-0.5, $response[24][1]['boats'][1]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][2]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][3]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][4]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][5]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][6]['racer_tilt_adjustment']);
    }

    /**
     * @return void
     */
    public function testPreviewsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = Scraper::scrapePreviews('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(7, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(6, $response[24][1]['race_wave']);
        $this->assertSame(2, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.15, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.22, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.19, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.18, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.05, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.11, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame(1, $response[24][1]['boats'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['boats'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['boats'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['boats'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['boats'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['boats'][6]['racer_boat_number']);
        $this->assertSame(54.0, $response[24][1]['boats'][1]['racer_weight']);
        $this->assertSame(54.2, $response[24][1]['boats'][2]['racer_weight']);
        $this->assertSame(52.6, $response[24][1]['boats'][3]['racer_weight']);
        $this->assertSame(51.2, $response[24][1]['boats'][4]['racer_weight']);
        $this->assertSame(51.6, $response[24][1]['boats'][5]['racer_weight']);
        $this->assertSame(47.5, $response[24][1]['boats'][6]['racer_weight']);
        $this->assertSame(0.0, $response[24][1]['boats'][1]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][2]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][3]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][4]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][5]['racer_weight_adjustment']);
        $this->assertSame(0.0, $response[24][1]['boats'][6]['racer_weight_adjustment']);
        $this->assertSame(6.86, $response[24][1]['boats'][1]['racer_exhibition_time']);
        $this->assertSame(6.89, $response[24][1]['boats'][2]['racer_exhibition_time']);
        $this->assertSame(6.88, $response[24][1]['boats'][3]['racer_exhibition_time']);
        $this->assertSame(6.80, $response[24][1]['boats'][4]['racer_exhibition_time']);
        $this->assertSame(6.81, $response[24][1]['boats'][5]['racer_exhibition_time']);
        $this->assertSame(6.76, $response[24][1]['boats'][6]['racer_exhibition_time']);
        $this->assertSame(-0.5, $response[24][1]['boats'][1]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][2]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][3]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][4]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][5]['racer_tilt_adjustment']);
        $this->assertSame(-0.5, $response[24][1]['boats'][6]['racer_tilt_adjustment']);
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = Scraper::scrapeResults('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(5, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(4, $response[24][1]['race_wave']);
        $this->assertSame(3, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['race_technique_number']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_place_id']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_place_id']);
        $this->assertSame(3, $response[24][1]['places'][3]['racer_place_id']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_place_id']);
        $this->assertSame(5, $response[24][1]['places'][5]['racer_place_id']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_place_id']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['places'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['places'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['places'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['places'][2]['racer_number']);
        $this->assertSame(3800, $response[24][1]['places'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['places'][4]['racer_number']);
        $this->assertSame(3471, $response[24][1]['places'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['places'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['places'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['places'][2]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['places'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['places'][4]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['places'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['places'][6]['racer_name']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.25, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.28, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.23, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.24, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame([460], $response[24][1]['refunds']['trifecta']);
        $this->assertSame([320], $response[24][1]['refunds']['trio']);
        $this->assertSame([180], $response[24][1]['refunds']['exacta']);
        $this->assertSame([150], $response[24][1]['refunds']['quinella']);
        $this->assertSame([110, 240, 280], $response[24][1]['refunds']['quinella_place']);
        $this->assertSame([100], $response[24][1]['refunds']['win']);
        $this->assertSame([100, 150], $response[24][1]['refunds']['place']);
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceCode1(): void
    {
        $response = Scraper::scrapeResults('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(5, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(4, $response[24][1]['race_wave']);
        $this->assertSame(3, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['race_technique_number']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_place_id']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_place_id']);
        $this->assertSame(3, $response[24][1]['places'][3]['racer_place_id']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_place_id']);
        $this->assertSame(5, $response[24][1]['places'][5]['racer_place_id']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_place_id']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['places'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['places'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['places'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['places'][2]['racer_number']);
        $this->assertSame(3800, $response[24][1]['places'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['places'][4]['racer_number']);
        $this->assertSame(3471, $response[24][1]['places'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['places'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['places'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['places'][2]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['places'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['places'][4]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['places'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['places'][6]['racer_name']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.25, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.28, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.23, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.24, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame([460], $response[24][1]['refunds']['trifecta']);
        $this->assertSame([320], $response[24][1]['refunds']['trio']);
        $this->assertSame([180], $response[24][1]['refunds']['exacta']);
        $this->assertSame([150], $response[24][1]['refunds']['quinella']);
        $this->assertSame([110, 240, 280], $response[24][1]['refunds']['quinella_place']);
        $this->assertSame([100], $response[24][1]['refunds']['win']);
        $this->assertSame([100, 150], $response[24][1]['refunds']['place']);
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = Scraper::scrapeResults('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response[24][1]['race_date']);
        $this->assertSame(24, $response[24][1]['race_stadium_number']);
        $this->assertSame(1, $response[24][1]['race_number']);
        $this->assertSame(5, $response[24][1]['race_wind']);
        $this->assertSame(11, $response[24][1]['race_wind_direction_number']);
        $this->assertSame(4, $response[24][1]['race_wave']);
        $this->assertSame(3, $response[24][1]['race_weather_number']);
        $this->assertSame(13.0, $response[24][1]['race_temperature']);
        $this->assertSame(14.0, $response[24][1]['race_water_temperature']);
        $this->assertSame(1, $response[24][1]['race_technique_number']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_place_id']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_place_id']);
        $this->assertSame(3, $response[24][1]['places'][3]['racer_place_id']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_place_id']);
        $this->assertSame(5, $response[24][1]['places'][5]['racer_place_id']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_place_id']);
        $this->assertSame(1, $response[24][1]['places'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['places'][2]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['places'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['places'][4]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['places'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['places'][6]['racer_boat_number']);
        $this->assertSame(3833, $response[24][1]['places'][1]['racer_number']);
        $this->assertSame(3773, $response[24][1]['places'][2]['racer_number']);
        $this->assertSame(3800, $response[24][1]['places'][3]['racer_number']);
        $this->assertSame(4574, $response[24][1]['places'][4]['racer_number']);
        $this->assertSame(3471, $response[24][1]['places'][5]['racer_number']);
        $this->assertSame(4924, $response[24][1]['places'][6]['racer_number']);
        $this->assertSame('中辻 博訓', $response[24][1]['places'][1]['racer_name']);
        $this->assertSame('津留 浩一郎', $response[24][1]['places'][2]['racer_name']);
        $this->assertSame('牧 宏次', $response[24][1]['places'][3]['racer_name']);
        $this->assertSame('東 潤樹', $response[24][1]['places'][4]['racer_name']);
        $this->assertSame('赤峰 和也', $response[24][1]['places'][5]['racer_name']);
        $this->assertSame('中北 涼', $response[24][1]['places'][6]['racer_name']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_course_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_course_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_course_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_course_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_course_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_course_number']);
        $this->assertSame(1, $response[24][1]['courses'][1]['racer_boat_number']);
        $this->assertSame(2, $response[24][1]['courses'][2]['racer_boat_number']);
        $this->assertSame(3, $response[24][1]['courses'][3]['racer_boat_number']);
        $this->assertSame(4, $response[24][1]['courses'][4]['racer_boat_number']);
        $this->assertSame(5, $response[24][1]['courses'][5]['racer_boat_number']);
        $this->assertSame(6, $response[24][1]['courses'][6]['racer_boat_number']);
        $this->assertSame(0.25, $response[24][1]['courses'][1]['racer_start_timing']);
        $this->assertSame(0.28, $response[24][1]['courses'][2]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][3]['racer_start_timing']);
        $this->assertSame(0.31, $response[24][1]['courses'][4]['racer_start_timing']);
        $this->assertSame(0.23, $response[24][1]['courses'][5]['racer_start_timing']);
        $this->assertSame(0.24, $response[24][1]['courses'][6]['racer_start_timing']);
        $this->assertSame([460], $response[24][1]['refunds']['trifecta']);
        $this->assertSame([320], $response[24][1]['refunds']['trio']);
        $this->assertSame([180], $response[24][1]['refunds']['exacta']);
        $this->assertSame([150], $response[24][1]['refunds']['quinella']);
        $this->assertSame([110, 240, 280], $response[24][1]['refunds']['quinella_place']);
        $this->assertSame([100], $response[24][1]['refunds']['win']);
        $this->assertSame([100, 150], $response[24][1]['refunds']['place']);
    }

    /**
     * @return void
     */
    public function testStadiumsWithDate20170331(): void
    {
        $this->assertSame($this->stadiums, Scraper::scrapeStadiums('2017-03-31'));
    }

    /**
     * @return void
     */
    public function testStadiumIdsWithDate20170331(): void
    {
        $this->assertSame(array_keys($this->stadiums), Scraper::scrapeStadiumIds('2017-03-31'));
    }

    /**
     * @return void
     */
    public function testStadiumNamesWithDate20170331(): void
    {
        $this->assertSame(array_values($this->stadiums), Scraper::scrapeStadiumNames('2017-03-31'));
    }

    /**
     * @return void
     */
    public function testGetInstance(): void
    {
        Scraper::resetInstance();
        $this->assertInstanceOf(ScraperInterface::class, Scraper::getInstance());
    }

    /**
     * @return void
     */
    public function testCreateInstance(): void
    {
        Scraper::resetInstance();
        $this->assertInstanceOf(ScraperInterface::class, Scraper::createInstance());
    }

    /**
     * @return void
     */
    public function testResetInstance(): void
    {
        Scraper::resetInstance();
        $instance1 = Scraper::getInstance();
        Scraper::resetInstance();
        $instance2 = Scraper::getInstance();
        $this->assertNotSame($instance1, $instance2);
    }
}
