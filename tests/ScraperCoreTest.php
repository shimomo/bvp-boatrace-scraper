<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests;

use BVP\BoatraceScraper\ScraperCore;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
class ScraperCoreTest extends TestCase
{
    /**
     * @var \BVP\BoatraceScraper\ScraperCore
     */
    protected ScraperCore $scraper;

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
    protected function setUp(): void
    {
        $this->scraper = new ScraperCore();
    }
    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = $this->scraper->scrapePrograms('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame('2017-03-31 12:00:00', $response->get(24)->get(1)->get('race_closed_at'));
        $this->assertSame('おおむら桜祭り競走', $response->get(24)->get(1)->get('race_title'));
        $this->assertSame('めざまし戦一般', $response->get(24)->get(1)->get('race_subtitle'));
        $this->assertSame(1800, $response->get(24)->get(1)->get('race_distance'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('boats')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('boats')->get(2)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('boats')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('boats')->get(4)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('boats')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('boats')->get(6)->get('racer_name'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_age'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_age'));
        $this->assertSame(47, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_age'));
        $this->assertSame(28, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_age'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_age'));
        $this->assertSame(24, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_age'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_class_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_class_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_branch_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_branch_id'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_branch_id'));
        $this->assertSame(13, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_branch_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_birthplace_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_birthplace_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_birthplace_id'));
        $this->assertSame(38, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_birthplace_id'));
        $this->assertSame(14, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_birthplace_id'));
        $this->assertSame(23, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_birthplace_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_late_count'));
        $this->assertSame(0.13, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_average_start_timing'));
        $this->assertSame(0.21, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_average_start_timing'));
        $this->assertSame(0.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_average_start_timing'));
        $this->assertSame(0.20, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_average_start_timing'));
        $this->assertSame(6.45, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_1_percent'));
        $this->assertSame(5.70, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_1_percent'));
        $this->assertSame(4.13, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_1_percent'));
        $this->assertSame(4.88, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_1_percent'));
        $this->assertSame(5.05, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_1_percent'));
        $this->assertSame(1.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_1_percent'));
        $this->assertSame(45.36, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_2_percent'));
        $this->assertSame(35.85, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_2_percent'));
        $this->assertSame(16.50, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_2_percent'));
        $this->assertSame(33.78, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_2_percent'));
        $this->assertSame(34.48, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_2_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_2_percent'));
        $this->assertSame(65.98, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_3_percent'));
        $this->assertSame(61.32, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_3_percent'));
        $this->assertSame(33.01, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_3_percent'));
        $this->assertSame(41.89, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_3_percent'));
        $this->assertSame(45.98, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_3_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_3_percent'));
        $this->assertSame(7.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_1_percent'));
        $this->assertSame(6.40, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_1_percent'));
        $this->assertSame(3.95, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_1_percent'));
        $this->assertSame(4.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_1_percent'));
        $this->assertSame(5.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_1_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_1_percent'));
        $this->assertSame(55.56, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_2_percent'));
        $this->assertSame(52.48, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_2_percent'));
        $this->assertSame(14.29, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_2_percent'));
        $this->assertSame(13.04, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_2_percent'));
        $this->assertSame(77.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_3_percent'));
        $this->assertSame(65.35, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_3_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_3_percent'));
        $this->assertSame(30.43, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_3_percent'));
        $this->assertSame(66, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_number'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_number'));
        $this->assertSame(59, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_number'));
        $this->assertSame(73, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_number'));
        $this->assertSame(52, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_number'));
        $this->assertSame(64, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_number'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(25.00, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(66.67, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(100.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(44.44, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(50.00, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(71, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_number'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_number'));
        $this->assertSame(67, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_number'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_number'));
        $this->assertSame(65, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_number'));
        $this->assertSame(46, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_number'));
        $this->assertSame(37.14, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(28.87, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(30.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(27.86, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(39.57, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(24.82, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(55.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(40.14, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(50.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.14, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(56.83, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.55, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_3_percent'));
    }

    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceCode1(): void
    {
        $response = $this->scraper->scrapePrograms('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame('2017-03-31 12:00:00', $response->get(24)->get(1)->get('race_closed_at'));
        $this->assertSame('おおむら桜祭り競走', $response->get(24)->get(1)->get('race_title'));
        $this->assertSame('めざまし戦一般', $response->get(24)->get(1)->get('race_subtitle'));
        $this->assertSame(1800, $response->get(24)->get(1)->get('race_distance'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('boats')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('boats')->get(2)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('boats')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('boats')->get(4)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('boats')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('boats')->get(6)->get('racer_name'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_age'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_age'));
        $this->assertSame(47, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_age'));
        $this->assertSame(28, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_age'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_age'));
        $this->assertSame(24, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_age'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_class_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_class_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_branch_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_branch_id'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_branch_id'));
        $this->assertSame(13, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_branch_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_birthplace_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_birthplace_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_birthplace_id'));
        $this->assertSame(38, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_birthplace_id'));
        $this->assertSame(14, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_birthplace_id'));
        $this->assertSame(23, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_birthplace_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_late_count'));
        $this->assertSame(0.13, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_average_start_timing'));
        $this->assertSame(0.21, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_average_start_timing'));
        $this->assertSame(0.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_average_start_timing'));
        $this->assertSame(0.20, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_average_start_timing'));
        $this->assertSame(6.45, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_1_percent'));
        $this->assertSame(5.70, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_1_percent'));
        $this->assertSame(4.13, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_1_percent'));
        $this->assertSame(4.88, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_1_percent'));
        $this->assertSame(5.05, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_1_percent'));
        $this->assertSame(1.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_1_percent'));
        $this->assertSame(45.36, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_2_percent'));
        $this->assertSame(35.85, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_2_percent'));
        $this->assertSame(16.50, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_2_percent'));
        $this->assertSame(33.78, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_2_percent'));
        $this->assertSame(34.48, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_2_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_2_percent'));
        $this->assertSame(65.98, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_3_percent'));
        $this->assertSame(61.32, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_3_percent'));
        $this->assertSame(33.01, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_3_percent'));
        $this->assertSame(41.89, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_3_percent'));
        $this->assertSame(45.98, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_3_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_3_percent'));
        $this->assertSame(7.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_1_percent'));
        $this->assertSame(6.40, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_1_percent'));
        $this->assertSame(3.95, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_1_percent'));
        $this->assertSame(4.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_1_percent'));
        $this->assertSame(5.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_1_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_1_percent'));
        $this->assertSame(55.56, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_2_percent'));
        $this->assertSame(52.48, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_2_percent'));
        $this->assertSame(14.29, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_2_percent'));
        $this->assertSame(13.04, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_2_percent'));
        $this->assertSame(77.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_3_percent'));
        $this->assertSame(65.35, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_3_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_3_percent'));
        $this->assertSame(30.43, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_3_percent'));
        $this->assertSame(66, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_number'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_number'));
        $this->assertSame(59, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_number'));
        $this->assertSame(73, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_number'));
        $this->assertSame(52, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_number'));
        $this->assertSame(64, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_number'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(25.00, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(66.67, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(100.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(44.44, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(50.00, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(71, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_number'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_number'));
        $this->assertSame(67, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_number'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_number'));
        $this->assertSame(65, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_number'));
        $this->assertSame(46, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_number'));
        $this->assertSame(37.14, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(28.87, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(30.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(27.86, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(39.57, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(24.82, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(55.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(40.14, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(50.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.14, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(56.83, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.55, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_3_percent'));
    }

    /**
     * @return void
     */
    public function testProgramsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = $this->scraper->scrapePrograms('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame('2017-03-31 12:00:00', $response->get(24)->get(1)->get('race_closed_at'));
        $this->assertSame('おおむら桜祭り競走', $response->get(24)->get(1)->get('race_title'));
        $this->assertSame('めざまし戦一般', $response->get(24)->get(1)->get('race_subtitle'));
        $this->assertSame(1800, $response->get(24)->get(1)->get('race_distance'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('boats')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('boats')->get(2)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('boats')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('boats')->get(4)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('boats')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('boats')->get(6)->get('racer_name'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_age'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_age'));
        $this->assertSame(47, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_age'));
        $this->assertSame(28, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_age'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_age'));
        $this->assertSame(24, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_age'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_class_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_class_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_class_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_branch_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_branch_id'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_branch_id'));
        $this->assertSame(13, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_branch_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_branch_id'));
        $this->assertSame(18, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_birthplace_id'));
        $this->assertSame(42, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_birthplace_id'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_birthplace_id'));
        $this->assertSame(38, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_birthplace_id'));
        $this->assertSame(14, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_birthplace_id'));
        $this->assertSame(23, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_birthplace_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_flying_count'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_flying_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_late_count'));
        $this->assertSame(0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_late_count'));
        $this->assertSame(0.13, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_average_start_timing'));
        $this->assertSame(0.21, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_average_start_timing'));
        $this->assertSame(0.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_average_start_timing'));
        $this->assertSame(0.20, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_average_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_average_start_timing'));
        $this->assertSame(6.45, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_1_percent'));
        $this->assertSame(5.70, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_1_percent'));
        $this->assertSame(4.13, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_1_percent'));
        $this->assertSame(4.88, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_1_percent'));
        $this->assertSame(5.05, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_1_percent'));
        $this->assertSame(1.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_1_percent'));
        $this->assertSame(45.36, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_2_percent'));
        $this->assertSame(35.85, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_2_percent'));
        $this->assertSame(16.50, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_2_percent'));
        $this->assertSame(33.78, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_2_percent'));
        $this->assertSame(34.48, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_2_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_2_percent'));
        $this->assertSame(65.98, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_national_top_3_percent'));
        $this->assertSame(61.32, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_national_top_3_percent'));
        $this->assertSame(33.01, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_national_top_3_percent'));
        $this->assertSame(41.89, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_national_top_3_percent'));
        $this->assertSame(45.98, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_national_top_3_percent'));
        $this->assertSame(1.96, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_national_top_3_percent'));
        $this->assertSame(7.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_1_percent'));
        $this->assertSame(6.40, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_1_percent'));
        $this->assertSame(3.95, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_1_percent'));
        $this->assertSame(4.17, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_1_percent'));
        $this->assertSame(5.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_1_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_1_percent'));
        $this->assertSame(55.56, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_2_percent'));
        $this->assertSame(52.48, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_2_percent'));
        $this->assertSame(14.29, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_2_percent'));
        $this->assertSame(13.04, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_2_percent'));
        $this->assertSame(77.78, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_local_top_3_percent'));
        $this->assertSame(65.35, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_local_top_3_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_local_top_3_percent'));
        $this->assertSame(30.43, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_local_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_local_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_local_top_3_percent'));
        $this->assertSame(66, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_number'));
        $this->assertSame(43, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_number'));
        $this->assertSame(59, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_number'));
        $this->assertSame(73, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_number'));
        $this->assertSame(52, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_number'));
        $this->assertSame(64, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_number'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(25.00, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(33.33, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(66.67, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_2_percent'));
        $this->assertSame(100.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(37.50, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(44.44, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(50.00, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(0.00, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(88.89, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_motor_top_3_percent'));
        $this->assertSame(71, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_number'));
        $this->assertSame(41, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_number'));
        $this->assertSame(67, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_number'));
        $this->assertSame(34, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_number'));
        $this->assertSame(65, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_number'));
        $this->assertSame(46, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_number'));
        $this->assertSame(37.14, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(28.87, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(30.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(27.86, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(39.57, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(24.82, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_2_percent'));
        $this->assertSame(55.00, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(40.14, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(50.71, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.14, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(56.83, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_assigned_boat_top_3_percent'));
        $this->assertSame(42.55, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_assigned_boat_top_3_percent'));
    }

    /**
     * @return void
     */
    public function testPreviewsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = $this->scraper->scrapePreviews('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(7, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(2, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.15, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.22, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.19, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.05, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.11, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight_adjustment'));
        $this->assertSame(6.86, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_exhibition_time'));
        $this->assertSame(6.89, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_exhibition_time'));
        $this->assertSame(6.88, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_exhibition_time'));
        $this->assertSame(6.80, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_exhibition_time'));
        $this->assertSame(6.81, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_exhibition_time'));
        $this->assertSame(6.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_exhibition_time'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_tilt_adjustment'));
    }

    /**
     * @return void
     */
    public function testPreviewaWithDate20170331AndRaceCode1(): void
    {
        $response = $this->scraper->scrapePreviews('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(7, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(2, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.15, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.22, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.19, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.05, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.11, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight_adjustment'));
        $this->assertSame(6.86, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_exhibition_time'));
        $this->assertSame(6.89, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_exhibition_time'));
        $this->assertSame(6.88, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_exhibition_time'));
        $this->assertSame(6.80, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_exhibition_time'));
        $this->assertSame(6.81, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_exhibition_time'));
        $this->assertSame(6.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_exhibition_time'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_tilt_adjustment'));
    }

    /**
     * @return void
     */
    public function testPreviewsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = $this->scraper->scrapePreviews('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(7, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(2, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.15, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.22, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.19, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.18, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.05, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.11, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame(1, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_boat_number'));
        $this->assertSame(54.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight'));
        $this->assertSame(54.2, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight'));
        $this->assertSame(52.6, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight'));
        $this->assertSame(51.2, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight'));
        $this->assertSame(51.6, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight'));
        $this->assertSame(47.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_weight_adjustment'));
        $this->assertSame(0.0, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_weight_adjustment'));
        $this->assertSame(6.86, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_exhibition_time'));
        $this->assertSame(6.89, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_exhibition_time'));
        $this->assertSame(6.88, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_exhibition_time'));
        $this->assertSame(6.80, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_exhibition_time'));
        $this->assertSame(6.81, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_exhibition_time'));
        $this->assertSame(6.76, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_exhibition_time'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(1)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(2)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(3)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(4)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(5)->get('racer_tilt_adjustment'));
        $this->assertSame(-0.5, $response->get(24)->get(1)->get('boats')->get(6)->get('racer_tilt_adjustment'));
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceStadiumCode24(): void
    {
        $response = $this->scraper->scrapeResults('2017-03-31', 24);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_technique_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(3, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_place_id'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_place_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(3)->get('racer_place_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_place_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(5)->get('racer_place_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_place_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('places')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('places')->get(2)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('places')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('places')->get(4)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('places')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('places')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('places')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('places')->get(2)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('places')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('places')->get(4)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('places')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('places')->get(6)->get('racer_name'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.25, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.28, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.23, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.24, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame([460], $response->get(24)->get(1)->get('refunds')->get('trifecta')->all());
        $this->assertSame([320], $response->get(24)->get(1)->get('refunds')->get('trio')->all());
        $this->assertSame([180], $response->get(24)->get(1)->get('refunds')->get('exacta')->all());
        $this->assertSame([150], $response->get(24)->get(1)->get('refunds')->get('quinella')->all());
        $this->assertSame([110, 240, 280], $response->get(24)->get(1)->get('refunds')->get('quinella_place')->all());
        $this->assertSame([100], $response->get(24)->get(1)->get('refunds')->get('win')->all());
        $this->assertSame([100, 150], $response->get(24)->get(1)->get('refunds')->get('place')->all());
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceCode1(): void
    {
        $response = $this->scraper->scrapeResults('2017-03-31', null, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_technique_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(3, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_place_id'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_place_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(3)->get('racer_place_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_place_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(5)->get('racer_place_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_place_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('places')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('places')->get(2)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('places')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('places')->get(4)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('places')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('places')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('places')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('places')->get(2)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('places')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('places')->get(4)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('places')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('places')->get(6)->get('racer_name'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.25, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.28, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.23, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.24, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame([460], $response->get(24)->get(1)->get('refunds')->get('trifecta')->all());
        $this->assertSame([320], $response->get(24)->get(1)->get('refunds')->get('trio')->all());
        $this->assertSame([180], $response->get(24)->get(1)->get('refunds')->get('exacta')->all());
        $this->assertSame([150], $response->get(24)->get(1)->get('refunds')->get('quinella')->all());
        $this->assertSame([110, 240, 280], $response->get(24)->get(1)->get('refunds')->get('quinella_place')->all());
        $this->assertSame([100], $response->get(24)->get(1)->get('refunds')->get('win')->all());
        $this->assertSame([100, 150], $response->get(24)->get(1)->get('refunds')->get('place')->all());
    }

    /**
     * @return void
     */
    public function testResultsWithDate20170331AndRaceStadiumCode24AndRaceCode1(): void
    {
        $response = $this->scraper->scrapeResults('2017-03-31', 24, 1);
        $this->assertSame('2017-03-31', $response->get(24)->get(1)->get('race_date'));
        $this->assertSame(24, $response->get(24)->get(1)->get('race_stadium_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_code'));
        $this->assertSame(1, $response->get(24)->get(1)->get('race_technique_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('race_wind'));
        $this->assertSame(11, $response->get(24)->get(1)->get('race_wind_direction_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('race_wave'));
        $this->assertSame(3, $response->get(24)->get(1)->get('race_weather_id'));
        $this->assertSame(13.0, $response->get(24)->get(1)->get('race_temperature'));
        $this->assertSame(14.0, $response->get(24)->get(1)->get('race_water_temperature'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_place_id'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_place_id'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(3)->get('racer_place_id'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_place_id'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(5)->get('racer_place_id'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_place_id'));
        $this->assertSame(1, $response->get(24)->get(1)->get('places')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('places')->get(2)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('places')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('places')->get(4)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('places')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('places')->get(6)->get('racer_boat_number'));
        $this->assertSame(3833, $response->get(24)->get(1)->get('places')->get(1)->get('racer_number'));
        $this->assertSame(3773, $response->get(24)->get(1)->get('places')->get(2)->get('racer_number'));
        $this->assertSame(3800, $response->get(24)->get(1)->get('places')->get(3)->get('racer_number'));
        $this->assertSame(4574, $response->get(24)->get(1)->get('places')->get(4)->get('racer_number'));
        $this->assertSame(3471, $response->get(24)->get(1)->get('places')->get(5)->get('racer_number'));
        $this->assertSame(4924, $response->get(24)->get(1)->get('places')->get(6)->get('racer_number'));
        $this->assertSame('中辻 博訓', $response->get(24)->get(1)->get('places')->get(1)->get('racer_name'));
        $this->assertSame('津留 浩一郎', $response->get(24)->get(1)->get('places')->get(2)->get('racer_name'));
        $this->assertSame('牧 宏次', $response->get(24)->get(1)->get('places')->get(3)->get('racer_name'));
        $this->assertSame('東 潤樹', $response->get(24)->get(1)->get('places')->get(4)->get('racer_name'));
        $this->assertSame('赤峰 和也', $response->get(24)->get(1)->get('places')->get(5)->get('racer_name'));
        $this->assertSame('中北 涼', $response->get(24)->get(1)->get('places')->get(6)->get('racer_name'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_course_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_course_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_course_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_course_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_course_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_course_number'));
        $this->assertSame(1, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_boat_number'));
        $this->assertSame(2, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_boat_number'));
        $this->assertSame(3, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_boat_number'));
        $this->assertSame(4, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_boat_number'));
        $this->assertSame(5, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_boat_number'));
        $this->assertSame(6, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_boat_number'));
        $this->assertSame(0.25, $response->get(24)->get(1)->get('courses')->get(1)->get('racer_start_timing'));
        $this->assertSame(0.28, $response->get(24)->get(1)->get('courses')->get(2)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(3)->get('racer_start_timing'));
        $this->assertSame(0.31, $response->get(24)->get(1)->get('courses')->get(4)->get('racer_start_timing'));
        $this->assertSame(0.23, $response->get(24)->get(1)->get('courses')->get(5)->get('racer_start_timing'));
        $this->assertSame(0.24, $response->get(24)->get(1)->get('courses')->get(6)->get('racer_start_timing'));
        $this->assertSame([460], $response->get(24)->get(1)->get('refunds')->get('trifecta')->all());
        $this->assertSame([320], $response->get(24)->get(1)->get('refunds')->get('trio')->all());
        $this->assertSame([180], $response->get(24)->get(1)->get('refunds')->get('exacta')->all());
        $this->assertSame([150], $response->get(24)->get(1)->get('refunds')->get('quinella')->all());
        $this->assertSame([110, 240, 280], $response->get(24)->get(1)->get('refunds')->get('quinella_place')->all());
        $this->assertSame([100], $response->get(24)->get(1)->get('refunds')->get('win')->all());
        $this->assertSame([100, 150], $response->get(24)->get(1)->get('refunds')->get('place')->all());
    }

    /**
     * @return void
     */
    public function testStadiumsWithDate20170331(): void
    {
        $this->assertSame($this->stadiums, $this->scraper->scrapeStadiums('2017-03-31')->all());
    }

    /**
     * @return void
     */
    public function testStadiumIdsWithDate20170331(): void
    {
        $this->assertSame(array_keys($this->stadiums), $this->scraper->scrapeStadiumIds('2017-03-31')->all());
    }

    /**
     * @return void
     */
    public function testStadiumNamesWithDate20170331(): void
    {
        $this->assertSame(array_values($this->stadiums), $this->scraper->scrapeStadiumNames('2017-03-31')->all());
    }
}
