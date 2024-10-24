<?php

declare(strict_types=1);

namespace Atto\Hydrator\Exception;

final class AttributeMissing extends \RuntimeException
{
    public function __construct(
        string $attributeName,
        string $propertyType,
        string $propertyName,
    ) {
        parent::__construct(sprintf(
            '%s is missing from %s property $%s',
            $attributeName,
            $propertyType,
            $propertyName,
        ));
    }

    public static function subtype(string $propertyType, string $propertyName): self
    {
        return new self('subtype', $propertyType, $propertyName);
    }
}
