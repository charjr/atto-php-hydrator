<?php

declare(strict_types=1);

namespace Atto\Hydrator\TestFixtures\Scalars\Nullable\WithDefault;

use Atto\Hydrator\Attribute\SerializationStrategy;
use Atto\Hydrator\Attribute\SerializationStrategyType;
use Atto\Hydrator\TestFixtures\Fixture;

final class Bools implements Fixture
{
    public function __construct(
        private ?bool $default = false,
        #[SerializationStrategy(SerializationStrategyType::Json)]
        private ?bool $json = false,
        #[SerializationStrategy(SerializationStrategyType::CommaDelimited)]
        private ?bool $commaDelimited = false,
        #[SerializationStrategy(SerializationStrategyType::PipeDelimited)]
        private ?bool $pipeDelimited = false,
    ) {
    }

    /** @return Fixture[] */
    public static function getExampleObjects(): array
    {
        $newSelf = fn($p) => new self(...array_fill(0, 4, $p));

        return [
            'null' => $newSelf(null),
            'defaults only' => new self(),
            'true' => $newSelf(true),
            'false' => $newSelf(false),
        ];
    }

    public function getExpectedArray(): array
    {
        return [
            'default' => $this->default,
            'json' => $this->json,
            'commaDelimited' => $this->commaDelimited,
            'pipeDelimited' => $this->pipeDelimited,
        ];
    }
}
