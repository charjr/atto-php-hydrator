<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Extract;

final class Enum
{
    private const EXTRACT_FORMAT = '%s->value';
    private const EXTRACT_FORMAT_WITH_NULL = '%1$s === null ? null : %1$s->value';

    use BasicExtract;
}
