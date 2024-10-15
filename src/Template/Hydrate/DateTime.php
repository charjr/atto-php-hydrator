<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Hydrate;

use Atto\Hydrator\Attribute\SerializationStrategyType;
use Atto\Hydrator\Template\ArrayReference;
use Atto\Hydrator\Template\ObjectReference;

final class DateTime
{
    private readonly string $className;

    private const HYDRATE_FORMAT = 'new \%2$s(%1$s)';
    private const HYDRATE_FORMAT_WITH_NULL = '%1$s === null ? null : new \%2$s(%1$s)';

    private const DESERIALISE = [
        SerializationStrategyType::Json->value => 'array_map(fn($value) => %s, json_decode(%s, true))',
        SerializationStrategyType::CommaDelimited->value => 'array_map(fn($value) => %s, explode(\',\', %s))'
    ];
    private const DESERIALISE_WITH_NULL = [
        SerializationStrategyType::Json->value => 'array_map(fn($value) => %1s$, json_decode(%2$s, true))',
        SerializationStrategyType::CommaDelimited->value => 'isset(%2$s) ? array_map(fn($value) => %1$s, explode(\',\', %2$s)): null',
    ];

    private const ASSIGNMENT = '%s = %s;';
    private const ASSIGNMENT_WITH_NULL = '%s = %s ?? null;';

    private const CHECKS = <<<'EOF'
        if (
            isset(%1$s) ||
            isset(%2$s) &&
            array_key_exists('%3$s', $values)
        ) {
            %4$s
        }
        EOF;

    private ArrayReference $arrayReference;
    private ObjectReference $objectReference;

    public function __construct(
        private readonly string|\Stringable $propertyName,
        private readonly ?SerializationStrategyType $serializationStrategy,
        string $className,
        private readonly bool $needsChecks,
    )
    {
        if ($className === \DateTimeInterface::class) {
            $className = \DateTime::class;
        }

        $this->arrayReference = new ArrayReference($this->propertyName);
        $this->objectReference = new ObjectReference($this->propertyName);
        $this->className = $className;
    }

    public function __toString(): string
    {
        if ($this->serializationStrategy === null) {
            $assignment = sprintf(
                $this->needsChecks ? self::ASSIGNMENT : self::ASSIGNMENT_WITH_NULL,
                $this->objectReference,
                sprintf(
                    $this->needsChecks ?
                        self::HYDRATE_FORMAT :
                        self::HYDRATE_FORMAT_WITH_NULL,
                    $this->arrayReference,
                    $this->className
                )
            );
        } else {
            $assignment = sprintf(
                $this->needsChecks ? self::ASSIGNMENT : self::ASSIGNMENT_WITH_NULL,
                $this->objectReference,
                sprintf(
                    $this->needsChecks ?
                        self::DESERIALISE[$this->serializationStrategy->value] :
                        self::DESERIALISE_WITH_NULL[$this->serializationStrategy->value],
                    sprintf(
                        $this->needsChecks ?
                            self::HYDRATE_FORMAT :
                            self::HYDRATE_FORMAT_WITH_NULL,
                        '$value',
                        $this->className,
                    ),
                    $this->arrayReference
                ));
        }

        return $this->needsChecks ?
            sprintf(
                self::CHECKS,
                $this->arrayReference,
                $this->objectReference,
                $this->propertyName,
                $assignment
            ) :
            $assignment;
    }
}
