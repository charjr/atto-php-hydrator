<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Extract;

final class DateTime
{
    private const EXTRACT_FORMAT = '%s->format(\DATE_ATOM)';
    private const EXTRACT_FORMAT_WITH_NULL = '%1$s?->format(\DATE_ATOM)';

    use BasicExtract;
}
