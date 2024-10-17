<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Extract;

final class Enum
{
    const EXTRACT_FORMAT = '%s->value';
    const EXTRACT_FORMAT_WITH_NULL = '%1$s !== null ? %1$s->value : null';

    use BasicExtract;
}
