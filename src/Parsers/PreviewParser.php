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
