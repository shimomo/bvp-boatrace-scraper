<?php

declare(strict_types=1);

namespace BVP\Scraper;

use Carbon\CarbonImmutable as Carbon;
use Carbon\CarbonInterface;

/**
 * Bulk counterpart to {@see Scraper}: every method fans a single-race
 * scrape out across a stadium/race grid and returns the results keyed by
 * [stadiumNumber][raceNumber].
 *
 * All work is delegated to the wrapped {@see Scraper} instance, so cache,
 * rate limiting and retry behavior are identical to scraping one race at a
 * time — and pass your own instance in to share pacing/cache state with the
 * single-race calls you make elsewhere.
 *
 * @author shimomo
 */
final class BatchScraper
{
    /**
     * @param \BVP\Scraper\Scraper $scraper
     */
    public function __construct(
        private readonly Scraper $scraper = new Scraper(),
    ) {
        //
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeResult(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeResult($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeProgram(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeProgram($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePreview(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapePreview($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeOdds(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeOdds($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeWin(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeWin($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePlace(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapePlace($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeSingle(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeSingle($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeExacta(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeExacta($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeQuinella(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeQuinella($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeQuinellaPlace(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeQuinellaPlace($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapePair(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapePair($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTrifecta(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeTrifecta($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTrio(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeTrio($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    public function scrapeTriple(
        CarbonInterface|string $date,
        array $stadiumNumbers = [],
        array $raceNumbers = [],
        bool $forceRefresh = false,
    ): array {
        return $this->batch(
            $date,
            $stadiumNumbers,
            $raceNumbers,
            fn(CarbonInterface $d, int $s, int $r): array => $this->scraper->scrapeTriple($d, $s, $r, $forceRefresh),
            $forceRefresh,
        );
    }

    /**
     * Resolves $stadiumNumbers (defaulting to all 24) against the stadiums
     * actually racing on $date, then fans $scrapeOne out across the
     * resulting stadium/race grid. Every call still routes through the
     * single-race Scraper::scrape*() methods, so cache/rate-limiter/retry
     * behavior is uniform whether called one race at a time or in batch.
     *
     * @param \Carbon\CarbonInterface|non-empty-string $date
     * @param list<int<1, 24>> $stadiumNumbers
     * @param list<int<1, 12>> $raceNumbers
     * @param callable(CarbonInterface, int<1, 24>, int<1, 12>): array<non-empty-string, mixed> $scrapeOne
     * @param bool $forceRefresh
     * @return array<int<1, 24>, array<int<1, 12>, array<non-empty-string, mixed>>>
     */
    private function batch(
        CarbonInterface|string $date,
        array $stadiumNumbers,
        array $raceNumbers,
        callable $scrapeOne,
        bool $forceRefresh = false,
    ): array {
        $parsedDate = Carbon::parse($date);

        /** @var list<int<1, 24>> $candidateStadiumNumbers */
        $candidateStadiumNumbers = array_unique($stadiumNumbers ?: range(1, 24));
        /** @var list<int<1, 12>> $uniqueRaceNumbers */
        $uniqueRaceNumbers = array_unique($raceNumbers ?: range(1, 12));

        /** @var list<int<1, 24>> $activeStadiumNumbers */
        $activeStadiumNumbers = array_keys($this->scraper->scrapeStadium($parsedDate, $forceRefresh));
        $stadiumNumbersToScrape = array_intersect($candidateStadiumNumbers, $activeStadiumNumbers);

        $response = [];
        foreach ($stadiumNumbersToScrape as $stadiumNumber) {
            foreach ($uniqueRaceNumbers as $raceNumber) {
                $response[$stadiumNumber][$raceNumber] = $scrapeOne($parsedDate, $stadiumNumber, $raceNumber);
            }
        }

        return $response;
    }
}
