<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use Carbon\CarbonImmutable as Carbon;

/**
 * @author shimomo
 */
final class ProgramScraperDataProvider
{
    /**
     * @return array
     */
    public static function scrapeProvider(): array
    {
        return [
            [
                'arguments' => [Carbon::parse('2017-03-31'), 24, 1],
                'expected' => [
                    'race_date' => '2017-03-31',
                    'race_stadium_number' => 24,
                    'race_number' => 1,
                    'race_closed_at' => '2017-03-31 12:00:00',
                    'race_title' => 'おおむら桜祭り競走',
                    'race_subtitle' => 'めざまし戦一般',
                    'race_distance' => 1800,
                    'boats' => [
                        1 => [
                            'racer_boat_number' => 1,
                            'racer_name' => '中辻 博訓',
                            'racer_number' => 3833,
                            'racer_class_number' => 1,
                            'racer_branch_number' => 18,
                            'racer_birthplace_number' => 18,
                            'racer_age' => 42,
                            'racer_weight' => 54.0,
                            'racer_flying_count' => 1,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.13,
                            'racer_national_top_1_percent' => 6.45,
                            'racer_national_top_2_percent' => 45.36,
                            'racer_national_top_3_percent' => 65.98,
                            'racer_local_top_1_percent' => 7.78,
                            'racer_local_top_2_percent' => 55.56,
                            'racer_local_top_3_percent' => 77.78,
                            'racer_assigned_motor_number' => 66,
                            'racer_assigned_motor_top_2_percent' => 88.89,
                            'racer_assigned_motor_top_3_percent' => 100.00,
                            'racer_assigned_boat_number' => 71,
                            'racer_assigned_boat_top_2_percent' => 37.14,
                            'racer_assigned_boat_top_3_percent' => 55.00,
                        ],
                        2 => [
                            'racer_boat_number' => 2,
                            'racer_name' => '津留 浩一郎',
                            'racer_number' => 3773,
                            'racer_class_number' => 3,
                            'racer_branch_number' => 42,
                            'racer_birthplace_number' => 42,
                            'racer_age' => 42,
                            'racer_weight' => 54.2,
                            'racer_flying_count' => 0,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.18,
                            'racer_national_top_1_percent' => 5.70,
                            'racer_national_top_2_percent' => 35.85,
                            'racer_national_top_3_percent' => 61.32,
                            'racer_local_top_1_percent' => 6.40,
                            'racer_local_top_2_percent' => 52.48,
                            'racer_local_top_3_percent' => 65.35,
                            'racer_assigned_motor_number' => 43,
                            'racer_assigned_motor_top_2_percent' => 25.00,
                            'racer_assigned_motor_top_3_percent' => 37.50,
                            'racer_assigned_boat_number' => 41,
                            'racer_assigned_boat_top_2_percent' => 28.87,
                            'racer_assigned_boat_top_3_percent' => 40.14,
                        ],
                        3 => [
                            'racer_boat_number' => 3,
                            'racer_name' => '赤峰 和也',
                            'racer_number' => 3471,
                            'racer_class_number' => 3,
                            'racer_branch_number' => 41,
                            'racer_birthplace_number' => 41,
                            'racer_age' => 47,
                            'racer_weight' => 52.6,
                            'racer_flying_count' => 0,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.21,
                            'racer_national_top_1_percent' => 4.13,
                            'racer_national_top_2_percent' => 16.50,
                            'racer_national_top_3_percent' => 33.01,
                            'racer_local_top_1_percent' => 3.95,
                            'racer_local_top_2_percent' => 14.29,
                            'racer_local_top_3_percent' => 33.33,
                            'racer_assigned_motor_number' => 59,
                            'racer_assigned_motor_top_2_percent' => 33.33,
                            'racer_assigned_motor_top_3_percent' => 44.44,
                            'racer_assigned_boat_number' => 67,
                            'racer_assigned_boat_top_2_percent' => 30.71,
                            'racer_assigned_boat_top_3_percent' => 50.71,
                        ],
                        4 => [
                            'racer_boat_number' => 4,
                            'racer_name' => '東 潤樹',
                            'racer_number' => 4574,
                            'racer_class_number' => 3,
                            'racer_branch_number' => 34,
                            'racer_birthplace_number' => 38,
                            'racer_age' => 28,
                            'racer_weight' => 51.2,
                            'racer_flying_count' => 1,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.17,
                            'racer_national_top_1_percent' => 4.88,
                            'racer_national_top_2_percent' => 33.78,
                            'racer_national_top_3_percent' => 41.89,
                            'racer_local_top_1_percent' => 4.17,
                            'racer_local_top_2_percent' => 13.04,
                            'racer_local_top_3_percent' => 30.43,
                            'racer_assigned_motor_number' => 73,
                            'racer_assigned_motor_top_2_percent' => 37.50,
                            'racer_assigned_motor_top_3_percent' => 50.00,
                            'racer_assigned_boat_number' => 34,
                            'racer_assigned_boat_top_2_percent' => 27.86,
                            'racer_assigned_boat_top_3_percent' => 42.14,
                        ],
                        5 => [
                            'racer_boat_number' => 5,
                            'racer_name' => '牧 宏次',
                            'racer_number' => 3800,
                            'racer_class_number' => 3,
                            'racer_branch_number' => 13,
                            'racer_birthplace_number' => 14,
                            'racer_age' => 43,
                            'racer_weight' => 51.6,
                            'racer_flying_count' => 0,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.20,
                            'racer_national_top_1_percent' => 5.05,
                            'racer_national_top_2_percent' => 34.48,
                            'racer_national_top_3_percent' => 45.98,
                            'racer_local_top_1_percent' => 5.00,
                            'racer_local_top_2_percent' => 37.50,
                            'racer_local_top_3_percent' => 37.50,
                            'racer_assigned_motor_number' => 52,
                            'racer_assigned_motor_top_2_percent' => 0.00,
                            'racer_assigned_motor_top_3_percent' => 0.00,
                            'racer_assigned_boat_number' => 65,
                            'racer_assigned_boat_top_2_percent' => 39.57,
                            'racer_assigned_boat_top_3_percent' => 56.83,
                        ],
                        6 => [
                            'racer_boat_number' => 6,
                            'racer_name' => '中北 涼',
                            'racer_number' => 4924,
                            'racer_class_number' => 4,
                            'racer_branch_number' => 42,
                            'racer_birthplace_number' => 23,
                            'racer_age' => 24,
                            'racer_weight' => 47.5,
                            'racer_flying_count' => 1,
                            'racer_late_count' => 0,
                            'racer_average_start_timing' => 0.18,
                            'racer_national_top_1_percent' => 1.76,
                            'racer_national_top_2_percent' => 1.96,
                            'racer_national_top_3_percent' => 1.96,
                            'racer_local_top_1_percent' => 0.00,
                            'racer_local_top_2_percent' => 0.00,
                            'racer_local_top_3_percent' => 0.00,
                            'racer_assigned_motor_number' => 64,
                            'racer_assigned_motor_top_2_percent' => 66.67,
                            'racer_assigned_motor_top_3_percent' => 88.89,
                            'racer_assigned_boat_number' => 46,
                            'racer_assigned_boat_top_2_percent' => 24.82,
                            'racer_assigned_boat_top_3_percent' => 42.55,
                        ],
                    ],
                ],
            ],
            [
                'arguments' => [Carbon::parse('2019-10-14'), 2, 1],
                'expected' => [
                    'race_date' => '2019-10-14',
                    'race_stadium_number' => 2,
                    'race_number' => 1,
                    'race_closed_at' => null,
                    'race_title' => null,
                    'race_subtitle' => null,
                    'race_distance' => null,
                    'boats' => [
                        1 => [
                            'racer_boat_number' => 1,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                        2 => [
                            'racer_boat_number' => 2,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                        3 => [
                            'racer_boat_number' => 3,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                        4 => [
                            'racer_boat_number' => 4,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                        5 => [
                            'racer_boat_number' => 5,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                        6 => [
                            'racer_boat_number' => 6,
                            'racer_name' => null,
                            'racer_number' => null,
                            'racer_class_number' => null,
                            'racer_branch_number' => null,
                            'racer_birthplace_number' => null,
                            'racer_age' => null,
                            'racer_weight' => null,
                            'racer_flying_count' => null,
                            'racer_late_count' => null,
                            'racer_average_start_timing' => null,
                            'racer_national_top_1_percent' => null,
                            'racer_national_top_2_percent' => null,
                            'racer_national_top_3_percent' => null,
                            'racer_local_top_1_percent' => null,
                            'racer_local_top_2_percent' => null,
                            'racer_local_top_3_percent' => null,
                            'racer_assigned_motor_number' => null,
                            'racer_assigned_motor_top_2_percent' => null,
                            'racer_assigned_motor_top_3_percent' => null,
                            'racer_assigned_boat_number' => null,
                            'racer_assigned_boat_top_2_percent' => null,
                            'racer_assigned_boat_top_3_percent' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
