<?php

declare(strict_types=1);

namespace BVP\Scraper\Factories;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author shimomo
 */
final class HttpBrowserFactory
{
    /**
     * Builds a UA-spoofed HttpBrowser. $extraParameters lets a caller layer
     * in per-instance server params (e.g. a proxy-specific header) so that
     * multiple Scraper instances can each carry their own browser identity.
     *
     * $httpClient exists so a caller can set transport options — above all a
     * timeout — without giving up the UA spoofing above. Symfony's default
     * client times out at `default_socket_timeout` (60s on most builds) and
     * has no `max_duration` cap at all, so a hung boatrace.jp response blocks
     * for a minute per attempt, and {@see \BVP\Scraper\Retry\RetryPolicy}
     * multiplies that by its attempt count. A batch caller sweeping a full
     * day's grid should pass a client with explicit `timeout`/`max_duration`
     * rather than inherit that.
     *
     * @param array<non-empty-string, non-empty-string> $extraParameters
     * @param ?\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @return \Symfony\Component\BrowserKit\HttpBrowser
     */
    public static function create(
        array $extraParameters = [],
        ?HttpClientInterface $httpClient = null,
    ): HttpBrowser {
        $httpBrowser = new HttpBrowser($httpClient);

        $httpBrowser->setServerParameters(array_merge([
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 ' .
                '(KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36',
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,' .
                'image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'HTTP_ACCEPT_LANGUAGE' => 'ja,en-US;q=0.9,en;q=0.8',
            'HTTP_CACHE_CONTROL' => 'max-age=0',
            'HTTP_CONNECTION' => 'keep-alive',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
            'HTTP_SEC_CH_UA' => '"Google Chrome";v="149", "Chromium";v="149", "Not)A;Brand";v="24"',
            'HTTP_SEC_CH_UA_PLATFORM' => '"Windows"',
            'HTTP_SEC_CH_UA_MOBILE' => '?0',
            'HTTP_SEC_FETCH_SITE' => 'none',
            'HTTP_SEC_FETCH_MODE' => 'navigate',
            'HTTP_SEC_FETCH_USER' => '?1',
            'HTTP_SEC_FETCH_DEST' => 'document',
            'HTTP_PRIORITY' => 'u=0, i',
        ], $extraParameters));

        return $httpBrowser;
    }
}
