<?php

declare(strict_types=1);

namespace BVP\Scraper\Tests\Factories;

use BVP\Scraper\Factories\HttpBrowserFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author shimomo
 */
final class HttpBrowserFactoryTest extends TestCase
{
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
