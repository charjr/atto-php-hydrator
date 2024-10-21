<?php

declare(strict_types=1);

namespace Atto\Hydrator\TestFixtures\Objects\Nested\WithHydrationStrategy\Merge;

use Atto\Hydrator\{Attribute\HydrationStrategy, Attribute\HydrationStrategyType, TestFixtures, TestFixtures\Fixture};
use Atto\Hydrator\Attribute\SerializationStrategy;
use Atto\Hydrator\Attribute\SerializationStrategyType;

final class Floats implements Fixture
{
    public function __construct(
        #[HydrationStrategy(HydrationStrategyType::Merge)]
        private TestFixtures\Scalars\Floats $default,
        #[HydrationStrategy(HydrationStrategyType::Merge)]
        #[SerializationStrategy(SerializationStrategyType::Json)]
        private TestFixtures\Scalars\Floats $json,
        #[HydrationStrategy(HydrationStrategyType::Merge)]
        #[SerializationStrategy(SerializationStrategyType::CommaDelimited)]
        private TestFixtures\Scalars\Floats $commaDelimited,
        #[HydrationStrategy(HydrationStrategyType::Merge)]
        #[SerializationStrategy(SerializationStrategyType::PipeDelimited)]
        private TestFixtures\Scalars\Floats $pipeDelimited,
    ) {
    }

    /** @return Fixture[] */
    public static function getExampleObjects(): array
    {
        $fillProperties = fn($p) => array_fill(
            0,
            4,
            new TestFixtures\Scalars\Floats(...array_fill(0, 4, $p)),
        );

        return [
            '0.0' => new self(...$fillProperties(0.0)),
            '1.1' => new self(...$fillProperties(1.1)),
        ];
    }

    public function getExpectedArray(): array
    {
        $mergeKeys = function (string $parentProperty, array $childProperties) {
            $result = [];
            foreach ($childProperties as $childProperty => $value) {
                $result["{$parentProperty}_{$childProperty}"] = $value;
            }

            return $result;
        };

        return [
            ...$mergeKeys('default', $this->default
                ->getExpectedArray()),
            ...$mergeKeys('json', $this->json
                ->getExpectedArray()),
            ...$mergeKeys('commaDelimited', $this->commaDelimited
                ->getExpectedArray()),
            ...$mergeKeys('pipeDelimited', $this->pipeDelimited
                ->getExpectedArray()),
        ];
    }
}
