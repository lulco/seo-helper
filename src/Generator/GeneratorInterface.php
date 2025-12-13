<?php

declare(strict_types=1);

namespace SeoHelper\Generator;

use SeoHelper\MetaData\BaseMetaData;

interface GeneratorInterface
{
    public function render(BaseMetaData $metaData): string;
}
