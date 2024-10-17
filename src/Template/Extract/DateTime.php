<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Extract;

use Atto\Hydrator\Attribute\SerializationStrategyType;
use Atto\Hydrator\Template\ObjectReference;

final class DateTime
{
    const EXTRACT_FORMAT = '%s->format(\DATE_ATOM)';
    const EXTRACT_FORMAT_WITH_NULL = '%1$s?->format(\DATE_ATOM)';

    use BasicExtract;
}
