<?php

declare(strict_types=1);

namespace BVP\Scraper\Parsers;

use BVP\Scraper\Converters\Converter;
use BVP\Scraper\Enums\Part;
use BVP\Scraper\Enums\Weather;
use BVP\Scraper\Enums\WindDirection;

/**
 * @author shimomo
 */
final class PreviewParser
{
    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WIND_SPEED_KEYS = [
        'wind_speed_source',
        'wind_speed',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WIND_DIRECTION_NUMBER_KEYS = [
        'wind_direction_number_source',
        'wind_direction_number',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WAVE_HEIGHT_KEYS = [
        'wave_height_source',
        'wave_height',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WEATHER_AS_OF_KEYS = [
        'weather_as_of_source',
        'weather_as_of_race_number',
        'weather_as_of_time',
    ];

    /**
     * The heading of the water condition block, minus its constant caption.
     *
     * @var non-empty-string
     */
    private const string WEATHER_AS_OF_CAPTION_PATTERN = '/^水面気象情報[\s\x{3000}]*/u';

    /**
     * `12R時点` - the block is frozen at the moment the given race ran.
     *
     * @var non-empty-string
     */
    private const string WEATHER_AS_OF_RACE_PATTERN = '/\A(\d{1,2})R時点\z/u';

    /**
     * `18:04現在` - the block is a live reading taken at the given clock time.
     *
     * @var non-empty-string
     */
    private const string WEATHER_AS_OF_TIME_PATTERN = '/\A(\d{1,2}:\d{2})現在\z/u';

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WEATHER_KEYS = [
        'weather_number_source',
        'weather_number',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array AIR_TEMPERATURE_KEYS = [
        'air_temperature_source',
        'air_temperature',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WATER_TEMPERATURE_KEYS = [
        'water_temperature_source',
        'water_temperature',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array START_TIMING_KEYS = [
        'start_timing_source',
        'start_timing',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WEIGHT_KEYS = [
        'weight_source',
        'weight',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array WEIGHT_ADJUSTMENT_KEYS = [
        'weight_adjustment_source',
        'weight_adjustment',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array EXHIBITION_TIME_KEYS = [
        'exhibition_time_source',
        'exhibition_time',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array TILT_ADJUSTMENT_KEYS = [
        'tilt_adjustment_source',
        'tilt_adjustment',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array PROPELLER_KEYS = [
        'propeller',
    ];

    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array PARTS_KEYS = [
        'parts',
    ];

    /**
     * A parts exchange cell holds either the short name on its own (`キャブ`)
     * or the short name followed by a quantity (`ピストン×2`).
     *
     * @var non-empty-string
     */
    private const string PART_PATTERN = '/^(.+?)×(\d+)$/u';

    /**
     * @param ?string $value
     * @return array{
     *     wind_speed_source: ?string,
     *     wind_speed: ?int,
     * }
     */
    public static function parseWindSpeed(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WIND_SPEED_KEYS, null);
        }

        return array_combine(self::WIND_SPEED_KEYS, [
            Converter::toString($value),
            Converter::toInt($value),
        ]);
    }

    /**
     * $value is the digit already extracted from the `is-windN` CSS class by
     * WindDirectionFilter; see {@see \BVP\Scraper\Parsers\ResultParser::parseWindDirection()}.
     *
     * @param ?string $value
     * @return array{
     *     wind_direction_number_source: ?string,
     *     wind_direction_number: ?int,
     * }
     */
    public static function parseWindDirection(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WIND_DIRECTION_NUMBER_KEYS, null);
        }

        return array_combine(self::WIND_DIRECTION_NUMBER_KEYS, [
            Converter::toString(
                Converter::toEnumOrNull(fn() => WindDirection::fromValue(Converter::toIntStrict($value)))?->name()
            ),
            Converter::toInt($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     wave_height_source: ?string,
     *     wave_height: ?int,
     * }
     */
    public static function parseWaveHeight(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WAVE_HEIGHT_KEYS, null);
        }

        return array_combine(self::WAVE_HEIGHT_KEYS, [
            Converter::toString($value),
            Converter::toInt($value),
        ]);
    }

    /**
     * Reads the heading of the water condition block, which says *when* the
     * reading it shows was taken. The block itself never says so in its cells,
     * so without this a caller cannot tell a settled reading from a stale one.
     *
     * Two forms exist, and which one a page shows is decided by the race number
     * rather than by the state of the page:
     *
     * - `12R時点` - the reading taken when race 12 ran. A race's page carries the
     *   reading of the race before it, and freezes on it. Until that race has
     *   run the page shows an older one, so the same URL answers `10R時点` and
     *   then `11R時点` as the meeting proceeds. **A caller that wants the reading
     *   it will keep must compare this against its own race number minus one.**
     * - `18:04現在` - a live reading, restated as the clock moves. Race 1 has no
     *   race before it and so shows this form for the whole day, which means
     *   **race 1 never settles**: a page read after the meeting carries the last
     *   reading of the day rather than the one race 1 ran in.
     *
     * Both values come back parsed, and an unknown wording leaves them null
     * while keeping the heading in the source key, so that a form we have not
     * seen is not mistaken for a settled reading.
     *
     * @param ?string $value
     * @return array{
     *     weather_as_of_source: ?string,
     *     weather_as_of_race_number: ?int,
     *     weather_as_of_time: ?string,
     * }
     */
    public static function parseWeatherAsOf(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WEATHER_AS_OF_KEYS, null);
        }

        $source = Converter::trim(
            preg_replace(self::WEATHER_AS_OF_CAPTION_PATTERN, '', $value) ?? $value
        );

        if ($source === null || $source === '') {
            return array_fill_keys(self::WEATHER_AS_OF_KEYS, null);
        }

        return array_combine(self::WEATHER_AS_OF_KEYS, [
            Converter::toString($source),
            preg_match(self::WEATHER_AS_OF_RACE_PATTERN, $source, $matches)
                ? Converter::toInt($matches[1])
                : null,
            preg_match(self::WEATHER_AS_OF_TIME_PATTERN, $source, $matches)
                ? Converter::toString($matches[1])
                : null,
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     weather_number_source: ?string,
     *     weather_number: ?int,
     * }
     */
    public static function parseWeather(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WEATHER_KEYS, null);
        }

        return array_combine(self::WEATHER_KEYS, [
            Converter::toString($value),
            Converter::toInt(Converter::toEnumOrNull(fn() => Weather::fromName($value))?->value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     air_temperature_source: ?string,
     *     air_temperature: ?float,
     * }
     */
    public static function parseAirTemperature(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::AIR_TEMPERATURE_KEYS, null);
        }

        return array_combine(self::AIR_TEMPERATURE_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     water_temperature_source: ?string,
     *     water_temperature: ?float,
     * }
     */
    public static function parseWaterTemperature(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WATER_TEMPERATURE_KEYS, null);
        }

        return array_combine(self::WATER_TEMPERATURE_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     start_timing_source: ?string,
     *     start_timing: ?float,
     * }
     */
    public static function parseStartTiming(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::START_TIMING_KEYS, null);
        }

        if (!preg_match('/(L|F\.\d{2}|0?\.\d{2})/u', $value)) {
            return array_combine(self::START_TIMING_KEYS, [
                Converter::toString($value),
                Converter::toNull($value),
            ]);
        }

        $values = self::splitAndTrim($value, ' ');

        return array_combine(self::START_TIMING_KEYS, [
            Converter::toString(array_shift($values)),
            match (substr($value, 0, 1)) {
                'L' => Converter::toNull($value),
                'F' => Converter::toFloat('-0' . ltrim($value, 'F')),
                default => Converter::toFloat('0' . $value),
            },
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     weight_source: ?string,
     *     weight: ?float,
     * }
     */
    public static function parseWeight(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WEIGHT_KEYS, null);
        }

        return array_combine(self::WEIGHT_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     weight_adjustment_source: ?string,
     *     weight_adjustment: ?float,
     * }
     */
    public static function parseWeightAdjustment(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::WEIGHT_ADJUSTMENT_KEYS, null);
        }

        return array_combine(self::WEIGHT_ADJUSTMENT_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     exhibition_time_source: ?string,
     *     exhibition_time: ?float,
     * }
     */
    public static function parseExhibitionTime(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::EXHIBITION_TIME_KEYS, null);
        }

        return array_combine(self::EXHIBITION_TIME_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * @param ?string $value
     * @return array{
     *     tilt_adjustment_source: ?string,
     *     tilt_adjustment: ?float,
     * }
     */
    public static function parseTiltAdjustment(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::TILT_ADJUSTMENT_KEYS, null);
        }

        return array_combine(self::TILT_ADJUSTMENT_KEYS, [
            Converter::toString($value),
            Converter::toFloat($value),
        ]);
    }

    /**
     * The propeller column holds `新` when the propeller was exchanged and is
     * empty otherwise. The wording is passed through without being interpreted.
     *
     * @param ?string $value
     * @return array{
     *     propeller: ?string,
     * }
     */
    public static function parsePropeller(?string $value): array
    {
        if ($value === null || $value === '') {
            return array_fill_keys(self::PROPELLER_KEYS, null);
        }

        return array_combine(self::PROPELLER_KEYS, [
            Converter::toString($value),
        ]);
    }

    /**
     * One element per exchanged part. A missing cell, that is a preview that is
     * not published yet, gives null, while a cell holding no exchange gives an
     * empty list, so that the two are not mistaken for each other.
     *
     * Some parts are printed without a quantity, and a ring is printed as
     * `リング×1` even for a single one, so a missing quantity means the part is
     * not counted rather than one of it. The quantity is left null in that
     * case. An unknown short name keeps its element and only leaves
     * part_number null.
     *
     * @param ?list<string> $values
     * @return array{
     *     parts: ?list<array{
     *         part_number_source: ?string,
     *         part_number: ?int,
     *         quantity: ?int,
     *     }>,
     * }
     */
    public static function parseParts(?array $values): array
    {
        if ($values === null) {
            return array_fill_keys(self::PARTS_KEYS, null);
        }

        $parts = [];

        foreach ($values as $value) {
            $value = Converter::trim($value);

            if ($value === null || $value === '') {
                continue;
            }

            $shortName = $value;
            $quantity = null;

            if (preg_match(self::PART_PATTERN, $value, $matches)) {
                $shortName = $matches[1];
                $quantity = $matches[2];
            }

            $parts[] = [
                'part_number_source' => Converter::toString($shortName),
                'part_number' => Converter::toInt(
                    Converter::toEnumOrNull(fn() => Part::fromShortName($shortName))?->value
                ),
                'quantity' => Converter::toInt($quantity),
            ];
        }

        return array_combine(self::PARTS_KEYS, [$parts]);
    }

    /**
     * @param non-empty-string $value
     * @param non-empty-string $delimiter
     * @return list<?string>
     */
    private static function splitAndTrim(string $value, string $delimiter = '/'): array
    {
        return array_map(fn($v) => Converter::trim($v), explode($delimiter, $value));
    }
}
