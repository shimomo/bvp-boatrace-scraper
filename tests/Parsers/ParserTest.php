<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Parsers;

use BVP\Scraper\Parsers\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @author shimomo
 */
final class ParserTest extends TestCase
{
    public function testParseNameSplitsOnTheSpace(): void
    {
        $this->assertSame(['name' => '田中 太郎'], Parser::parseName('田中 太郎'));
    }

    public function testParseNameRestoresTheSpaceForAKnownUnspacedName(): void
    {
        $this->assertSame(['name' => 'マイケル 田代'], Parser::parseName('マイケル田代'));
    }

    public function testParseNameKeepsAnUnknownUnspacedName(): void
    {
        $this->assertSame(['name' => '未知野太郎'], Parser::parseName('未知野太郎'));
    }

    public function testParseNameReportsAnAbsentNameAsMissing(): void
    {
        $this->assertSame(['name' => null], Parser::parseName(null));
        $this->assertSame(['name' => null], Parser::parseName(''));
    }
}
