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
}
