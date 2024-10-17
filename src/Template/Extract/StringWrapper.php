<?php

declare(strict_types=1);

namespace Atto\Hydrator\Template\Extract;

final class StringWrapper
{
    const EXTRACT_FORMAT = '(string) %s';
    const EXTRACT_FORMAT_WITH_NULL = '%1$s !== null ? (string) %s : null';

    use BasicExtract;
}
