<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use Carbon\CarbonImmutable as Carbon;

/**
 * @author shimomo
 */
final class ResultScraperDataProvider
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
                    'race_wind' => 5,
                    'race_wind_direction_number' => 11,
                    'race_wave' => 4,
                    'race_weather_number' => 3,
                    'race_temperature' => 13.0,
                    'race_water_temperature' => 14.0,
                    'race_technique_number' => 1,
                    'courses' => [
                        1 => [
                            'racer_course_number' => 1,
                            'racer_boat_number' => 1,
                            'racer_start_timing' => 0.25,
                        ],
                        2 => [
                            'racer_course_number' => 2,
                            'racer_boat_number' => 2,
                            'racer_start_timing' => 0.28,
                        ],
                        3 => [
                            'racer_course_number' => 3,
                            'racer_boat_number' => 3,
                            'racer_start_timing' => 0.31,
                        ],
                        4 => [
                            'racer_course_number' => 4,
                            'racer_boat_number' => 4,
                            'racer_start_timing' => 0.31,
                        ],
                        5 => [
                            'racer_course_number' => 5,
                            'racer_boat_number' => 5,
                            'racer_start_timing' => 0.23,
                        ],
                        6 => [
                            'racer_course_number' => 6,
                            'racer_boat_number' => 6,
                            'racer_start_timing' => 0.24,
                        ],
                    ],
                    'places' => [
                        1 => [
                            'racer_place_id' => 1,
                            'racer_boat_number' => 1,
                            'racer_number' => 3833,
                            'racer_name' => '中辻 博訓',
                        ],
                        2 => [
                            'racer_place_id' => 2,
                            'racer_boat_number' => 2,
                            'racer_number' => 3773,
                            'racer_name' => '津留 浩一郎',
                        ],
                        3 => [
                            'racer_place_id' => 3,
                            'racer_boat_number' => 5,
                            'racer_number' => 3800,
                            'racer_name' => '牧 宏次',
                        ],
                        4 => [
                            'racer_place_id' => 4,
                            'racer_boat_number' => 4,
                            'racer_number' => 4574,
                            'racer_name' => '東 潤樹',
                        ],
                        5 => [
                            'racer_place_id' => 5,
                            'racer_boat_number' => 3,
                            'racer_number' => 3471,
                            'racer_name' => '赤峰 和也',
                        ],
                        6 => [
                            'racer_place_id' => 6,
                            'racer_boat_number' => 6,
                            'racer_number' => 4924,
                            'racer_name' => '中北 涼',
                        ],
                    ],
                    'refunds' => [
                        'trifecta' => [460],
                        'trio' => [320],
                        'exacta' => [180],
                        'quinella' => [150],
                        'quinella_place' => [110, 240, 280],
                        'win' => [100],
                        'place' => [100, 150],
                    ],
                ],
            ],
            [
                'arguments' => [Carbon::parse('2019-10-14'), 2, 1],
                'expected' => [
                    'race_date' => '2019-10-14',
                    'race_stadium_number' => 2,
                    'race_number' => 1,
                    'race_wind' => null,
                    'race_wind_direction_number' => null,
                    'race_wave' => null,
                    'race_weather_number' => null,
                    'race_temperature' => null,
                    'race_water_temperature' => null,
                    'race_technique_number' => null,
                    'courses' => [
                        1 => [
                            'racer_course_number' => 1,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                        2 => [
                            'racer_course_number' => 2,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                        3 => [
                            'racer_course_number' => 3,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                        4 => [
                            'racer_course_number' => 4,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                        5 => [
                            'racer_course_number' => 5,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                        6 => [
                            'racer_course_number' => 6,
                            'racer_boat_number' => null,
                            'racer_start_timing' => null,
                        ],
                    ],
                    'places' => [
                        1 => [
                            'racer_place_id' => 1,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                        2 => [
                            'racer_place_id' => 2,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                        3 => [
                            'racer_place_id' => 3,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                        4 => [
                            'racer_place_id' => 4,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                        5 => [
                            'racer_place_id' => 5,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                        6 => [
                            'racer_place_id' => 6,
                            'racer_boat_number' => null,
                            'racer_number' => null,
                            'racer_name' => null,
                        ],
                    ],
                    'refunds' => [
                        'trifecta' => [],
                        'trio' => [],
                        'exacta' => [],
                        'quinella' => [],
                        'quinella_place' => [],
                        'win' => [],
                        'place' => [],
                    ],
                ],
            ],
        ];
    }
}
