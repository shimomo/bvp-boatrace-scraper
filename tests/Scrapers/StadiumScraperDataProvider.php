<?php

declare(strict_types=1);

namespace BVP\BoatraceScraper\Tests\Scrapers;

use Carbon\CarbonImmutable as Carbon;

/**
 * @author shimomo
 */
final class StadiumScraperDataProvider
{
    /**
     * @return array
     */
    public static function scrapeStadiumsProvider(): array
    {
        return [
            [
                'arguments' => [Carbon::parse('2017-03-31')],
                'expected' => [
                    4 => '平和島',
                    5 => '多摩川',
                    6 => '浜名湖',
                    10 => '三国',
                    15 => '丸亀',
                    18 => '徳山',
                    23 => '唐津',
                    24 => '大村',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function scrapeStadiumNumbersProvider(): array
    {
        return [
            [
                'arguments' => [Carbon::parse('2017-03-31')],
                'expected' => [4, 5, 6, 10, 15, 18, 23, 24],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function scrapeStadiumNamesProvider(): array
    {
        return [
            [
                'arguments' => [Carbon::parse('2017-03-31')],
                'expected' => ['平和島', '多摩川', '浜名湖', '三国', '丸亀', '徳山', '唐津', '大村'],
            ],
        ];
    }
}
