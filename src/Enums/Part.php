<?php

declare(strict_types=1);

namespace BVP\Scraper\Enums;

use ValueError;

/**
 * The parts exchange column of the preview page. The table prints the short name, and the
 * legend on the same page maps it to the full name. The values follow the order of that legend.
 *
 * @author shimomo
 */
enum Part: int
{
    case ピストン = 1;
    case ピストンリング = 2;
    case 電気一式 = 3;
    case キャブレター = 4;
    case シリンダ = 5;
    case クランクシャフト = 6;
    case ギヤケース = 7;
    case キャリアボデー = 8;

    /**
     * @return non-empty-string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return non-empty-string
     */
    public function shortName(): string
    {
        return match ($this) {
            self::ピストン => 'ピストン',
            self::ピストンリング => 'リング',
            self::電気一式 => '電気',
            self::キャブレター => 'キャブ',
            self::シリンダ => 'シリンダ',
            self::クランクシャフト => 'シャフト',
            self::ギヤケース => 'ギヤ',
            self::キャリアボデー => 'キャリボ',
        };
    }

    /**
     * @param ?string $name
     * @return ?self
     * @throws \ValueError
     */
    public static function fromName(?string $name): ?self
    {
        if ($name === null) {
            return null;
        }

        foreach (self::cases() as $case) {
            if ($case->name() === $name) {
                return $case;
            }
        }

        throw new ValueError(
            "{$name} is not a valid name for enum " . self::class
        );
    }

    /**
     * @param ?string $shortName
     * @return ?self
     * @throws \ValueError
     */
    public static function fromShortName(?string $shortName): ?self
    {
        if ($shortName === null) {
            return null;
        }

        foreach (self::cases() as $case) {
            if ($case->shortName() === $shortName) {
                return $case;
            }
        }

        throw new ValueError(
            "{$shortName} is not a valid name for enum " . self::class
        );
    }

    /**
     * @return list<array{
     *     number: int,
     *     name: non-empty-string,
     *     short_name: non-empty-string,
     * }>
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'number' => $case->value,
            'name' => $case->name(),
            'short_name' => $case->shortName(),
        ], self::cases());
    }
}
