<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Parsers;

use BVP\Scraper\Parsers\PreviewParser;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class PreviewParserTest extends TestCase
{
    public function testParsePartsReportsAnAbsentCellAsMissing(): void
    {
        $this->assertSame(['parts' => null], PreviewParser::parseParts(null));
    }

    public function testParsePartsReportsACellHoldingNoExchangeAsAnEmptyList(): void
    {
        $this->assertSame(['parts' => []], PreviewParser::parseParts([]));
    }

    public function testParsePartsReadsTheQuantityWhenItIsPrinted(): void
    {
        $this->assertSame(
            [
                'parts' => [
                    [
                        'part_number_source' => 'ピストン',
                        'part_number' => 1,
                        'quantity' => 2,
                    ],
                ],
            ],
            PreviewParser::parseParts(['ピストン×2'])
        );
    }

    public function testParsePartsLeavesTheQuantityMissingWhenItIsNotPrinted(): void
    {
        $this->assertSame(
            [
                'parts' => [
                    [
                        'part_number_source' => 'シリンダ',
                        'part_number' => 5,
                        'quantity' => null,
                    ],
                ],
            ],
            PreviewParser::parseParts(['シリンダ'])
        );
    }

    public function testParsePartsKeepsAnUnknownShortName(): void
    {
        $this->assertSame(
            [
                'parts' => [
                    [
                        'part_number_source' => '未知部品',
                        'part_number' => null,
                        'quantity' => 3,
                    ],
                ],
            ],
            PreviewParser::parseParts(['未知部品×3'])
        );
    }

    public function testParsePartsSkipsBlankEntries(): void
    {
        $this->assertSame(['parts' => []], PreviewParser::parseParts(['', '   ']));
    }

    public function testParsePropellerPassesTheWordingThrough(): void
    {
        $this->assertSame(['propeller' => '新'], PreviewParser::parsePropeller('新'));
        $this->assertSame(['propeller' => null], PreviewParser::parsePropeller(''));
        $this->assertSame(['propeller' => null], PreviewParser::parsePropeller(null));
    }
    public function testParseWeatherAsOfReportsAnAbsentHeadingAsMissing(): void
    {
        $this->assertSame(
            [
                'weather_as_of_source' => null,
                'weather_as_of_race_number' => null,
                'weather_as_of_time' => null,
            ],
            PreviewParser::parseWeatherAsOf(null)
        );
    }

    /**
     * A race other than the first carries the reading of the race before it and
     * freezes on it, so the race number is what tells a caller the reading is
     * the one it will keep.
     */
    public function testParseWeatherAsOfReadsTheRaceTheReadingWasTakenAt(): void
    {
        $this->assertSame(
            [
                'weather_as_of_source' => '11R時点',
                'weather_as_of_race_number' => 11,
                'weather_as_of_time' => null,
            ],
            PreviewParser::parseWeatherAsOf('水面気象情報　11R時点')
        );
    }

    /**
     * Race 1 has no race before it, so its heading states a clock time and is
     * restated all day - it never settles.
     */
    public function testParseWeatherAsOfReadsTheClockTimeOfALiveReading(): void
    {
        $this->assertSame(
            [
                'weather_as_of_source' => '18:04現在',
                'weather_as_of_race_number' => null,
                'weather_as_of_time' => '18:04',
            ],
            PreviewParser::parseWeatherAsOf('水面気象情報　18:04現在')
        );
    }

    /**
     * A wording we have not seen keeps the heading but leaves both values null,
     * so that it cannot be mistaken for a settled reading.
     */
    public function testParseWeatherAsOfLeavesAnUnknownWordingUnparsed(): void
    {
        $this->assertSame(
            [
                'weather_as_of_source' => '計測中',
                'weather_as_of_race_number' => null,
                'weather_as_of_time' => null,
            ],
            PreviewParser::parseWeatherAsOf('水面気象情報　計測中')
        );
    }

    /**
     * The caption is dropped whether or not the ideographic space is present.
     */
    public function testParseWeatherAsOfDropsTheCaptionWithoutASeparator(): void
    {
        $this->assertSame(
            [
                'weather_as_of_source' => '3R時点',
                'weather_as_of_race_number' => 3,
                'weather_as_of_time' => null,
            ],
            PreviewParser::parseWeatherAsOf('水面気象情報3R時点')
        );
    }

}
