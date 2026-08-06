<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Scrapers;

use Carbon\CarbonImmutable as Carbon;

/**
 * @psalm-import-type RaceArguments from \BVP\Scraper\Tests\ScraperPsalmType
 * @psalm-import-type RaceExpected from \BVP\Scraper\Tests\ScraperPsalmType
 *
 * @author shimomo
 */
final class ResultScraperDataProvider
{
    /**
     * @psalm-return non-empty-list<
     *     array{
     *         arguments: RaceArguments,
     *         expected: RaceExpected,
     *     }
     * >
     *
     * @return array
     */
    public static function scrapeProvider(): array
    {
        return [
            [
                'arguments' => [Carbon::parse('2017-03-31'), 24, 1],
                'expected' => [
                    'date' => '2017-03-31',
                    'stadium_number' => 24,
                    'race_number' => 1,
                    'wind_speed_source' => '5m',
                    'wind_speed' => 5,
                    'wind_direction_number_source' => '南西',
                    'wind_direction_number' => 11,
                    'wave_height_source' => '4cm',
                    'wave_height' => 4,
                    'weather_number_source' => '雨',
                    'weather_number' => 3,
                    'air_temperature_source' => '13.0℃',
                    'air_temperature' => 13.0,
                    'water_temperature_source' => '14.0℃',
                    'water_temperature' => 14.0,
                    'technique_number_source' => '逃げ',
                    'technique_number' => 1,
                    'racers' => [
                        1 => [
                            'entry_number' => 1,
                            'course_number' => 1,
                            'start_timing_source' => '.25',
                            'start_timing' => 0.25,
                            'place_number_source' => '1',
                            'place_number' => 1,
                            'number_source' => '3833',
                            'number' => 3833,
                            'name' => '中辻 博訓',
                        ],
                        2 => [
                            'entry_number' => 2,
                            'course_number' => 2,
                            'start_timing_source' => '.28',
                            'start_timing' => 0.28,
                            'place_number_source' => '2',
                            'place_number' => 2,
                            'number_source' => '3773',
                            'number' => 3773,
                            'name' => '津留 浩一郎',
                        ],
                        3 => [
                            'entry_number' => 3,
                            'course_number' => 3,
                            'start_timing_source' => '.31',
                            'start_timing' => 0.31,
                            'place_number_source' => '5',
                            'place_number' => 5,
                            'number_source' => '3471',
                            'number' => 3471,
                            'name' => '赤峰 和也',
                        ],
                        4 => [
                            'entry_number' => 4,
                            'course_number' => 4,
                            'start_timing_source' => '.31',
                            'start_timing' => 0.31,
                            'place_number_source' => '4',
                            'place_number' => 4,
                            'number_source' => '4574',
                            'number' => 4574,
                            'name' => '東 潤樹',
                        ],
                        5 => [
                            'entry_number' => 5,
                            'course_number' => 5,
                            'start_timing_source' => '.23',
                            'start_timing' => 0.23,
                            'place_number_source' => '3',
                            'place_number' => 3,
                            'number_source' => '3800',
                            'number' => 3800,
                            'name' => '牧 宏次',
                        ],
                        6 => [
                            'entry_number' => 6,
                            'course_number' => 6,
                            'start_timing_source' => '.24',
                            'start_timing' => 0.24,
                            'place_number_source' => '6',
                            'place_number' => 6,
                            'number_source' => '4924',
                            'number' => 4924,
                            'name' => '中北 涼',
                        ],
                    ],
                    'payouts' => [
                        'trifecta' => [
                            [
                                'combination' => '1-2-5',
                                'amount' => 460,
                                'label' => null,
                            ],
                        ],
                        'trio' => [
                            [
                                'combination' => '1=2=5',
                                'amount' => 320,
                                'label' => null,
                            ],
                        ],
                        'exacta' => [
                            [
                                'combination' => '1-2',
                                'amount' => 180,
                                'label' => null,
                            ],
                        ],
                        'quinella' => [
                            [
                                'combination' => '1=2',
                                'amount' => 150,
                                'label' => null,
                            ],
                        ],
                        'quinella_place' => [
                            [
                                'combination' => '1=2',
                                'amount' => 110,
                                'label' => null,
                            ],
                            [
                                'combination' => '1=5',
                                'amount' => 240,
                                'label' => null,
                            ],
                            [
                                'combination' => '2=5',
                                'amount' => 280,
                                'label' => null,
                            ],
                        ],
                        'win' => [
                            [
                                'combination' => '1',
                                'amount' => 100,
                                'label' => null,
                            ],
                        ],
                        'place' => [
                            [
                                'combination' => '1',
                                'amount' => 100,
                                'label' => null,
                            ],
                            [
                                'combination' => '2',
                                'amount' => 150,
                                'label' => null,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'arguments' => [Carbon::parse('2019-10-14'), 2, 1],
                'expected' => [
                    'date' => '2019-10-14',
                    'stadium_number' => 2,
                    'race_number' => 1,
                    'wind_speed_source' => null,
                    'wind_speed' => null,
                    'wind_direction_number_source' => null,
                    'wind_direction_number' => null,
                    'wave_height_source' => null,
                    'wave_height' => null,
                    'weather_number_source' => null,
                    'weather_number' => null,
                    'air_temperature_source' => null,
                    'air_temperature' => null,
                    'water_temperature_source' => null,
                    'water_temperature' => null,
                    'technique_number_source' => null,
                    'technique_number' => null,
                    'racers' => [
                        1 => [
                            'entry_number' => 1,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                        2 => [
                            'entry_number' => 2,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                        3 => [
                            'entry_number' => 3,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                        4 => [
                            'entry_number' => 4,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                        5 => [
                            'entry_number' => 5,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                        6 => [
                            'entry_number' => 6,
                            'course_number' => null,
                            'start_timing_source' => null,
                            'start_timing' => null,
                            'place_number_source' => null,
                            'place_number' => null,
                            'number_source' => null,
                            'number' => null,
                            'name' => null,
                        ],
                    ],
                    'payouts' => [
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
            [
                'arguments' => [Carbon::parse('2026-07-29'), 17, 11],
                'expected' => [
                    'date' => '2026-07-29',
                    'stadium_number' => 17,
                    'race_number' => 11,
                    'wind_speed_source' => '2m',
                    'wind_speed' => 2,
                    'wind_direction_number_source' => '西',
                    'wind_direction_number' => 13,
                    'wave_height_source' => '2cm',
                    'wave_height' => 2,
                    'weather_number_source' => '晴',
                    'weather_number' => 1,
                    'air_temperature_source' => '30.0℃',
                    'air_temperature' => 30.0,
                    'water_temperature_source' => '28.0℃',
                    'water_temperature' => 28.0,
                    'technique_number_source' => 'まくり差し',
                    'technique_number' => 4,
                    'racers' => [
                        1 => [
                            'entry_number' => 1,
                            'course_number' => 1,
                            'start_timing_source' => '.12',
                            'start_timing' => 0.12,
                            'place_number_source' => '2',
                            'place_number' => 2,
                            'number_source' => '4982',
                            'number' => 4982,
                            'name' => '中村 将隆',
                        ],
                        2 => [
                            'entry_number' => 2,
                            'course_number' => 2,
                            'start_timing_source' => '.14',
                            'start_timing' => 0.14,
                            'place_number_source' => '3',
                            'place_number' => 3,
                            'number_source' => '3833',
                            'number' => 3833,
                            'name' => '中辻 博訓',
                        ],
                        3 => [
                            'entry_number' => 3,
                            'course_number' => 3,
                            'start_timing_source' => '.17',
                            'start_timing' => 0.17,
                            'place_number_source' => '5',
                            'place_number' => 5,
                            'number_source' => '4672',
                            'number' => 4672,
                            'name' => '守屋 大地',
                        ],
                        4 => [
                            'entry_number' => 4,
                            'course_number' => 4,
                            'start_timing_source' => '.17',
                            'start_timing' => 0.17,
                            'place_number_source' => '落',
                            'place_number' => 10,
                            'number_source' => '4066',
                            'number' => 4066,
                            'name' => '東本 勝利',
                        ],
                        5 => [
                            'entry_number' => 5,
                            'course_number' => 6,
                            'start_timing_source' => '.19',
                            'start_timing' => 0.19,
                            'place_number_source' => '4',
                            'place_number' => 4,
                            'number_source' => '5020',
                            'number' => 5020,
                            'name' => '宮村 勇哉',
                        ],
                        6 => [
                            'entry_number' => 6,
                            'course_number' => 5,
                            'start_timing_source' => '.14',
                            'start_timing' => 0.14,
                            'place_number_source' => '1',
                            'place_number' => 1,
                            'number_source' => '4276',
                            'number' => 4276,
                            'name' => '鈴木 勝博',
                        ],
                    ],
                    'payouts' => [
                        'trifecta' => [
                            [
                                'combination' => '6-1-2',
                                'amount' => 65790,
                                'label' => null,
                            ],
                        ],
                        'trio' => [
                            [
                                'combination' => '1=2=6',
                                'amount' => 1190,
                                'label' => null,
                            ],
                        ],
                        'exacta' => [
                            [
                                'combination' => '6-1',
                                'amount' => 13410,
                                'label' => null,
                            ],
                        ],
                        'quinella' => [
                            [
                                'combination' => '1=6',
                                'amount' => 1890,
                                'label' => null,
                            ],
                        ],
                        'quinella_place' => [
                            [
                                'combination' => '1=6',
                                'amount' => 630,
                                'label' => null,
                            ],
                            [
                                'combination' => '2=6',
                                'amount' => 580,
                                'label' => null,
                            ],
                            [
                                'combination' => '1=2',
                                'amount' => 230,
                                'label' => null,
                            ],
                        ],
                        'win' => [
                            [
                                'combination' => null,
                                'amount' => 70,
                                'label' => '特払',
                            ],
                        ],
                        'place' => [
                            [
                                'combination' => '6',
                                'amount' => 1360,
                                'label' => null,
                            ],
                            [
                                'combination' => '1',
                                'amount' => 360,
                                'label' => null,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'arguments' => [Carbon::parse('2026-07-22'), 9, 10],
                'expected' => [
                    'date' => '2026-07-22',
                    'stadium_number' => 9,
                    'race_number' => 10,
                    'wind_speed_source' => '4m',
                    'wind_speed' => 4,
                    'wind_direction_number_source' => '東北東',
                    'wind_direction_number' => 4,
                    'wave_height_source' => '2cm',
                    'wave_height' => 2,
                    'weather_number_source' => '晴',
                    'weather_number' => 1,
                    'air_temperature_source' => '37.0℃',
                    'air_temperature' => 37.0,
                    'water_temperature_source' => '35.0℃',
                    'water_temperature' => 35.0,
                    'technique_number_source' => '恵まれ',
                    'technique_number' => 6,
                    'racers' => [
                        1 => [
                            'entry_number' => 1,
                            'course_number' => 1,
                            'start_timing_source' => 'F.03',
                            'start_timing' => -0.03,
                            'place_number_source' => 'F',
                            'place_number' => 14,
                            'number_source' => '5112',
                            'number' => 5112,
                            'name' => '砂長 知輝',
                        ],
                        2 => [
                            'entry_number' => 2,
                            'course_number' => 2,
                            'start_timing_source' => '.12',
                            'start_timing' => 0.12,
                            'place_number_source' => '2',
                            'place_number' => 2,
                            'number_source' => '5289',
                            'number' => 5289,
                            'name' => '佃 來紀',
                        ],
                        3 => [
                            'entry_number' => 3,
                            'course_number' => 3,
                            'start_timing_source' => '.01',
                            'start_timing' => 0.01,
                            'place_number_source' => '1',
                            'place_number' => 1,
                            'number_source' => '5275',
                            'number' => 5275,
                            'name' => '松田 淳平',
                        ],
                        4 => [
                            'entry_number' => 4,
                            'course_number' => 4,
                            'start_timing_source' => 'F.03',
                            'start_timing' => -0.03,
                            'place_number_source' => 'F',
                            'place_number' => 14,
                            'number_source' => '5141',
                            'number' => 5141,
                            'name' => '大澤 風葵',
                        ],
                        5 => [
                            'entry_number' => 5,
                            'course_number' => 5,
                            'start_timing_source' => 'F.03',
                            'start_timing' => -0.03,
                            'place_number_source' => 'F',
                            'place_number' => 14,
                            'number_source' => '4983',
                            'number' => 4983,
                            'name' => '前田 篤哉',
                        ],
                        6 => [
                            'entry_number' => 6,
                            'course_number' => 6,
                            'start_timing_source' => 'F.09',
                            'start_timing' => -0.09,
                            'place_number_source' => 'F',
                            'place_number' => 14,
                            'number_source' => '5229',
                            'number' => 5229,
                            'name' => '吉川 晴人',
                        ],
                    ],
                    'payouts' => [
                        'trifecta' => [
                            [
                                'combination' => null,
                                'amount' => 100,
                                'label' => '不成立',
                            ],
                        ],
                        'trio' => [
                            [
                                'combination' => null,
                                'amount' => 100,
                                'label' => '不成立',
                            ],
                        ],
                        'exacta' => [
                            [
                                'combination' => '3-2',
                                'amount' => 150,
                                'label' => null,
                            ],
                        ],
                        'quinella' => [
                            [
                                'combination' => null,
                                'amount' => 100,
                                'label' => '不成立',
                            ],
                        ],
                        'quinella_place' => [
                            [
                                'combination' => null,
                                'amount' => 100,
                                'label' => '不成立',
                            ],
                        ],
                        'win' => [
                            [
                                'combination' => '3',
                                'amount' => 180,
                                'label' => null,
                            ],
                        ],
                        'place' => [
                            [
                                'combination' => null,
                                'amount' => 100,
                                'label' => '不成立',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
