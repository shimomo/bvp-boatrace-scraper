<?php

declare(strict_types=1);

namespace BVP\Scraper\Factories;

use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author shimomo
 */
final class HttpBrowserFactory
{
    /**
     * Chrome major version known to be accepted on {@see self::ANCHOR_DATE},
     * and the release cadence used to carry it forward.
     *
     * @var int
     */
    private const int ANCHOR_MAJOR = 149;

    /**
     * @var non-empty-string
     */
    private const string ANCHOR_DATE = '2026-08-07';

    /**
     * Chrome has shipped a stable major roughly every four weeks since 2021.
     *
     * @var int
     */
    private const int RELEASE_INTERVAL_DAYS = 28;

    /**
     * How far ahead of the extrapolation to claim to be. See
     * {@see self::chromeMajorVersion()} for why overshooting is the safe side.
     *
     * @var int
     */
    private const int LEAD_MAJORS = 2;

    /**
     * The Chrome major version this factory claims to be.
     *
     * ⭐Derived from the calendar rather than pinned, because the pin is a
     * cliff and it ages. boatrace.jp sits behind Akamai, which puts requests
     * from an out-of-date Chrome into an 8–10 second tarpit — a fixed,
     * quantised edge delay, not load. Measured against the live site on
     * 2026-08-07 (all cache MISS, interleaved, headers the only variable):
     *
     *   Chrome/70 … 145 → `server-timing: edge; dur=8012–10033`
     *   Chrome/146 … 300 → `edge; dur=12–28`
     *
     * Three properties of that table decide this design:
     *
     *   1. The cutoff is a **cliff**: 145 is tarpitted, 146 is not. There is
     *      no gradient to notice early.
     *   2. **Overshooting is free.** Chrome/300 — a version that will not
     *      exist for a decade — is served as fast as the real one. Only the
     *      UA major is read; a Sec-CH-UA that disagrees with it still passes.
     *   3. The floor (146) sat just three majors below the then-current
     *      stable (149), i.e. it tracks Chrome's calendar rather than being
     *      a fixed number.
     *
     * Because the penalty is asymmetric — one major too low costs ~9s on
     * every request, arbitrarily too high costs nothing — this deliberately
     * does not try to be accurate. It extrapolates and then adds
     * {@see self::LEAD_MAJORS} on top. Do not "fix" the drift by fetching the
     * real current version over the network: accuracy buys nothing here, and
     * it would put a network dependency and a failure mode inside the scrape
     * path.
     *
     * ⚠The lead is deliberately small. Nothing rejects an implausibly future
     * version today, but "too far ahead" is exactly the kind of rule that can
     * be added later, so this stays a couple of months ahead rather than
     * years.
     *
     * ⚠This defends against one rule shape only. If the delay ever comes back
     * for a different reason (a header that does not exist yet, a TLS
     * fingerprint check), the calendar will not save it — measure
     * `server-timing: edge; dur` and alert on it.
     *
     * @param ?\Carbon\CarbonInterface $now
     * @return int
     */
    public static function chromeMajorVersion(?CarbonInterface $now = null): int
    {
        $elapsedDays = Carbon::parse(self::ANCHOR_DATE)->startOfDay()
            ->diffInDays(($now ?? Carbon::now())->startOfDay(), false);

        // A clock behind the anchor must not walk the version backwards, which
        // is the one direction that is expensive.
        $elapsedDays = max(0, (int) $elapsedDays);

        return self::ANCHOR_MAJOR
            + intdiv($elapsedDays, self::RELEASE_INTERVAL_DAYS)
            + self::LEAD_MAJORS;
    }

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
     * ⚠The Sec-* headers below are not decoration. Dropping them puts the
     * request into the same tarpit an out-of-date Chrome lands in, even with
     * a current UA — measured at 8–10s per request. Either the Sec-CH-UA
     * group or the Sec-Fetch group is enough on its own today; both are sent
     * because a real Chrome sends both.
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
        $chromeMajorVersion = self::chromeMajorVersion();

        $httpBrowser->setServerParameters(array_merge([
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 ' .
                "(KHTML, like Gecko) Chrome/{$chromeMajorVersion}.0.0.0 Safari/537.36",
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,' .
                'image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'HTTP_ACCEPT_LANGUAGE' => 'ja,en-US;q=0.9,en;q=0.8',
            'HTTP_CACHE_CONTROL' => 'max-age=0',
            'HTTP_CONNECTION' => 'keep-alive',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
            'HTTP_SEC_CH_UA' => "\"Google Chrome\";v=\"{$chromeMajorVersion}\", " .
                "\"Chromium\";v=\"{$chromeMajorVersion}\", \"Not)A;Brand\";v=\"24\"",
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
