<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Factories;

use BVP\Scraper\Factories\HttpBrowserFactory;
use Carbon\CarbonImmutable as Carbon;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author shimomo
 */
final class HttpBrowserFactoryTest extends TestCase
{
    /**
     * The lowest Chrome major boatrace.jp's edge served without the 8–10s
     * tarpit when this was measured (2026-08-07). Anything below it cost ~9s
     * per request, so the claimed version must never fall back to it.
     *
     * @var int
     */
    private const int MEASURED_TARPIT_FLOOR = 146;

    public function testClaimsTheAnchorVersionOnTheAnchorDate(): void
    {
        $this->assertSame(
            149 + 2,
            HttpBrowserFactory::chromeMajorVersion(Carbon::parse('2026-08-07')),
        );
    }

    /**
     * Four weeks per stable major is the whole basis of the extrapolation.
     */
    public function testAdvancesOneMajorEveryFourWeeks(): void
    {
        $anchor = Carbon::parse('2026-08-07');

        $this->assertSame(151, HttpBrowserFactory::chromeMajorVersion($anchor->addDays(27)));
        $this->assertSame(152, HttpBrowserFactory::chromeMajorVersion($anchor->addDays(28)));
        $this->assertSame(164, HttpBrowserFactory::chromeMajorVersion($anchor->addDays(365)));
    }

    /**
     * Walking the version backwards is the one direction that costs ~9s per
     * request, so a clock behind the anchor must clamp rather than subtract.
     */
    public function testNeverGoesBackwardsBeforeTheAnchor(): void
    {
        $this->assertSame(151, HttpBrowserFactory::chromeMajorVersion(Carbon::parse('2020-01-01')));
    }

    /**
     * Guards the property the whole design rests on: overshooting is free,
     * undershooting is a cliff.
     */
    public function testStaysAboveTheMeasuredTarpitFloorForTheNextDecade(): void
    {
        $anchor = Carbon::parse('2026-08-07');

        for ($days = 0; $days <= 3650; $days += 7) {
            $this->assertGreaterThanOrEqual(
                self::MEASURED_TARPIT_FLOOR,
                HttpBrowserFactory::chromeMajorVersion($anchor->addDays($days)),
            );
        }
    }

    /**
     * A real Chrome never disagrees with itself. Akamai does not check this
     * today (a UA/Sec-CH-UA mismatch was served fast), but sending a
     * contradiction is free to avoid and not free to be caught on.
     */
    public function testUserAgentAndClientHintAgreeOnTheVersion(): void
    {
        $httpBrowser = HttpBrowserFactory::create();
        $major = HttpBrowserFactory::chromeMajorVersion();

        $this->assertStringContainsString(
            "Chrome/{$major}.0.0.0",
            (string) $httpBrowser->getServerParameter('HTTP_USER_AGENT'),
        );
        $this->assertStringContainsString(
            "\"Google Chrome\";v=\"{$major}\"",
            (string) $httpBrowser->getServerParameter('HTTP_SEC_CH_UA'),
        );
    }

    /**
     * Dropping either Sec-* group is what put a current-UA request into the
     * tarpit, so their presence is part of the contract, not styling.
     */
    public function testSendsTheHeadersThatKeepTheRequestOutOfTheTarpit(): void
    {
        $httpBrowser = HttpBrowserFactory::create();

        foreach ([
            'HTTP_SEC_CH_UA',
            'HTTP_SEC_CH_UA_PLATFORM',
            'HTTP_SEC_CH_UA_MOBILE',
            'HTTP_SEC_FETCH_SITE',
            'HTTP_SEC_FETCH_MODE',
            'HTTP_SEC_FETCH_USER',
            'HTTP_SEC_FETCH_DEST',
        ] as $header) {
            $this->assertNotSame('', (string) $httpBrowser->getServerParameter($header), $header);
        }
    }

    public function testSpoofsTheUserAgentByDefault(): void
    {
        $httpBrowser = HttpBrowserFactory::create();

        $this->assertStringContainsString(
            'Chrome/',
            (string) $httpBrowser->getServerParameter('HTTP_USER_AGENT'),
        );
    }

    public function testExtraParametersOverrideTheDefaults(): void
    {
        $httpBrowser = HttpBrowserFactory::create(['HTTP_USER_AGENT' => 'custom-agent']);

        $this->assertSame('custom-agent', $httpBrowser->getServerParameter('HTTP_USER_AGENT'));
    }

    /**
     * The injected client must actually carry the requests — that is the
     * whole point of the parameter (it is how a caller imposes a timeout) —
     * and it must not cost the caller the UA spoofing done here.
     */
    public function testUsesTheInjectedHttpClientWhileKeepingTheSpoofedHeaders(): void
    {
        $requestedUrls = [];

        $mockHttpClient = new MockHttpClient(
            function (string $method, string $url) use (&$requestedUrls): MockResponse {
                $requestedUrls[] = $url;

                return new MockResponse('<html><body>ok</body></html>');
            }
        );

        $httpBrowser = HttpBrowserFactory::create(httpClient: $mockHttpClient);
        $httpBrowser->request('GET', 'https://www.boatrace.jp/');

        $this->assertSame(['https://www.boatrace.jp/'], $requestedUrls);
        $this->assertStringContainsString(
            'Chrome/',
            (string) $httpBrowser->getServerParameter('HTTP_USER_AGENT'),
        );
    }
}
