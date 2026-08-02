<?php

declare(strict_types=1);

namespace BVP\Scraper;

use BVP\Scraper\Caching\CacheFactory;
use BVP\Scraper\Caching\CacheKeyFactory;
use BVP\Scraper\Caching\CachePolicyInterface;
use BVP\Scraper\Caching\DateBasedCachePolicy;
use BVP\Scraper\Factories\HttpBrowserFactory;
use BVP\Scraper\RateLimiting\RateLimiterInterface;
use BVP\Scraper\RateLimiting\ThrottleRateLimiter;
use BVP\Scraper\Retry\RetryPolicy;
use BVP\Scraper\Scrapers\OddsScraper;
use BVP\Scraper\Scrapers\PreviewScraper;
use BVP\Scraper\Scrapers\ProgramScraper;
use BVP\Scraper\Scrapers\ResultScraper;
use BVP\Scraper\Scrapers\StadiumScraper;
use BVP\Scraper\Validators\Validator;
use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * Instance-based entry point: every dependency (HttpBrowser, rate limiter,
 * cache, cache policy, retry policy) is scoped to the constructed instance,
 * so multiple instances (e.g. one per proxy/worker) never share pacing or
 * cache state. There is deliberately no static singleton facade — construct
 * as many instances as your use case needs.
 *
 * Bulk fan-out over a stadium/race grid now lives in {@see BatchScraper};
 * the scrape*Bulk() methods below are deprecated shims delegating to it.
 *
 * @author shimomo
 */
final class Scraper
{
    /**
     * @var \Symfony\Component\BrowserKit\HttpBrowser
     */
    private readonly HttpBrowser $httpBrowser;

    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    private readonly CacheInterface $cache;

    /**
     * @var \BVP\Scraper\Scrapers\ResultScraper
     */
    private readonly ResultScraper $resultScraper;

    /**
     * @var \BVP\Scraper\Scrapers\StadiumScraper
     */
    private readonly StadiumScraper $stadiumScraper;

    /**
     * @var \BVP\Scraper\Scrapers\ProgramScraper
     */
    private readonly ProgramScraper $programScraper;

    /**
     * @var \BVP\Scraper\Scrapers\PreviewScraper
     */
    private readonly PreviewScraper $previewScraper;

    /**
     * @var \BVP\Scraper\Scrapers\OddsScraper
     */
    private readonly OddsScraper $oddsScraper;

    /**
     * Backs the deprecated scrape*Bulk() methods only, so they and
     * {@see BatchScraper} can never drift apart.
     *
     * @var \BVP\Scraper\BatchScraper
     */
    private readonly BatchScraper $batchScraper;

    /**
     * @param ?\Symfony\Component\BrowserKit\HttpBrowser $httpBrowser
     * @param \BVP\Scraper\RateLimiting\RateLimiterInterface $rateLimiter
     * @param ?\Psr\SimpleCache\CacheInterface $cache
     * @param \BVP\Scraper\Caching\CachePolicyInterface $cachePolicy
     * @param \BVP\Scraper\Retry\RetryPolicy $retryPolicy
     */
    public function __construct(
        ?HttpBrowser $httpBrowser = null,
        private readonly RateLimiterInterface $rateLimiter = new ThrottleRateLimiter(),
        ?CacheInterface $cache = null,
        private readonly CachePolicyInterface $cachePolicy = new DateBasedCachePolicy(),
        private readonly RetryPolicy $retryPolicy = new RetryPolicy(),
    ) {
        $this->httpBrowser = $httpBrowser ?? HttpBrowserFactory::create();
        $this->cache = $cache ?? CacheFactory::createDefault();

        $this->resultScraper = new ResultScraper($this->httpBrowser);
        $this->stadiumScraper = new StadiumScraper($this->httpBrowser);
        $this->programScraper = new ProgramScraper($this->httpBrowser);
        $this->previewScraper = new PreviewScraper($this->httpBrowser);
        $this->oddsScraper = new OddsScraper($this->httpBrowser, $this->rateLimiter);
        $this->batchScraper = new BatchScraper($this);
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeOdds(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        Validator::validateStadiumNumber($stadiumNumber);
        Validator::validateRaceNumber($raceNumber);

        $parsedDate = Carbon::parse($date);

        return $this->fetch(
            'odds',
            $parsedDate,
            $stadiumNumber,
            $raceNumber,
            fn(): array => $this->oddsScraper->scrape($parsedDate, $stadiumNumber, $raceNumber),
            forceRefresh: $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeWin(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'win',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeWin(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapePlace(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'place',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapePlace(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeSingle(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'single',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeSingle(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeExacta(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'exacta',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeExacta(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeQuinella(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'quinella',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeQuinella(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeQuinellaPlace(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'quinella_place',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeQuinellaPlace(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapePair(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'pair',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapePair(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeTrifecta(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'trifecta',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeTrifecta(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeTrio(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'trio',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeTrio(...),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeTriple(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        return $this->scrapeOddsBetType(
            'triple',
            $date,
            $stadiumNumber,
            $raceNumber,
            $this->oddsScraper->scrapeTriple(...),
            $forceRefresh,
        );
    }

    /**
     * @param non-empty-string $betType
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param callable(CarbonInterface, int<1, 24>, int<1, 12>): array<non-empty-string, mixed> $fetch
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    private function scrapeOddsBetType(
        string $betType,
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        callable $fetch,
        bool $forceRefresh = false,
    ): array {
        Validator::validateStadiumNumber($stadiumNumber);
        Validator::validateRaceNumber($raceNumber);

        $parsedDate = Carbon::parse($date);

        return $this->fetch(
            'odds',
            $parsedDate,
            $stadiumNumber,
            $raceNumber,
            fn(): array => $fetch($parsedDate, $stadiumNumber, $raceNumber),
            $betType,
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapePreview(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        Validator::validateStadiumNumber($stadiumNumber);
        Validator::validateRaceNumber($raceNumber);

        $parsedDate = Carbon::parse($date);

        return $this->fetch(
            'preview',
            $parsedDate,
            $stadiumNumber,
            $raceNumber,
            fn(): array => $this->previewScraper->scrape($parsedDate, $stadiumNumber, $raceNumber),
            forceRefresh: $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeProgram(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        Validator::validateStadiumNumber($stadiumNumber);
        Validator::validateRaceNumber($raceNumber);

        $parsedDate = Carbon::parse($date);

        return $this->fetch(
            'program',
            $parsedDate,
            $stadiumNumber,
            $raceNumber,
            fn(): array => $this->programScraper->scrape($parsedDate, $stadiumNumber, $raceNumber),
            forceRefresh: $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param bool $forceRefresh
     * @return array<int<1, 24>, non-empty-string>
     */
    public function scrapeStadium(CarbonInterface|string $date, bool $forceRefresh = false): array
    {
        $parsedDate = Carbon::parse($date);

        $cacheKey = CacheKeyFactory::makeForStadium($parsedDate);
        $cacheable = $this->cachePolicy->isCacheable('stadium', $parsedDate);

        if ($cacheable && !$forceRefresh) {
            /** @var ?array<int<1, 24>, non-empty-string> $cached */
            $cached = $this->cache->get($cacheKey);

            if ($cached !== null) {
                return $cached;
            }
        }

        $this->rateLimiter->throttle();

        /** @var array<int<1, 24>, non-empty-string> $result */
        $result = $this->retryPolicy->run(fn(): array => $this->stadiumScraper->scrape($parsedDate));

        if ($cacheable) {
            $this->cache->set($cacheKey, $result);
        }

        return $result;
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeResult()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeResultBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeResult($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeProgram()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeProgramBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeProgram($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapePreview()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePreviewBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapePreview($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeOdds()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeOddsBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeOdds($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeWin()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeWinBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeWin($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapePlace()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePlaceBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapePlace($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeSingle()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeSingleBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeSingle($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeExacta()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeExactaBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeExacta($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeQuinella()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeQuinellaBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeQuinella($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeQuinellaPlace()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeQuinellaPlaceBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeQuinellaPlace($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapePair()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePairBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapePair($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeTrifecta()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTrifectaBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeTrifecta($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeTrio()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTrioBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeTrio($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @deprecated Use {@see \BVP\Scraper\BatchScraper::scrapeTriple()} instead.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTripleBulk(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batchScraper->scrapeTriple($date, $stadiumNumbers, $raceNumbers, $forceRefresh);
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    public function scrapeResult(
        CarbonInterface|string $date,
        int $stadiumNumber,
        int $raceNumber,
        bool $forceRefresh = false,
    ): array {
        Validator::validateStadiumNumber($stadiumNumber);
        Validator::validateRaceNumber($raceNumber);

        $parsedDate = Carbon::parse($date);

        return $this->fetch(
            'result',
            $parsedDate,
            $stadiumNumber,
            $raceNumber,
            fn(): array => $this->resultScraper->scrape($parsedDate, $stadiumNumber, $raceNumber),
            forceRefresh: $forceRefresh,
        );
    }

    /**
     * Shared cache/rate-limit/retry pipeline every scrape*() method routes
     * through: a cache hit skips both the network call and the rate
     * limiter entirely; a miss throttles, fetches with retry, and (when the
     * cache policy allows it) stores the result forever.
     *
     * $forceRefresh skips the cache read (forcing a live fetch) while still
     * writing the fresh result back to the cache when the policy allows it,
     * overwriting whatever was there. This is the escape hatch for the rare
     * case where boatrace.jp corrects an already-finalized past race.
     *
     * @param non-empty-string $type
     * @param \Carbon\CarbonInterface $date
     * @param int<1, 24> $stadiumNumber
     * @param int<1, 12> $raceNumber
     * @param callable(): array<non-empty-string, mixed> $fetch
     * @param ?non-empty-string $betType
     * @param bool $forceRefresh
     * @return array<non-empty-string, mixed>
     */
    private function fetch(
        string $type,
        CarbonInterface $date,
        int $stadiumNumber,
        int $raceNumber,
        callable $fetch,
        ?string $betType = null,
        bool $forceRefresh = false,
    ): array {
        $cacheKey = CacheKeyFactory::make($type, $date, $stadiumNumber, $raceNumber, $betType);
        $cacheable = $this->cachePolicy->isCacheable($type, $date);

        if ($cacheable && !$forceRefresh) {
            /** @var ?array<non-empty-string, mixed> $cached */
            $cached = $this->cache->get($cacheKey);

            if ($cached !== null) {
                return $cached;
            }
        }

        $this->rateLimiter->throttle();

        /** @var array<non-empty-string, mixed> $result */
        $result = $this->retryPolicy->run($fetch);

        if ($cacheable) {
            $this->cache->set($cacheKey, $result);
        }

        return $result;
    }
}
