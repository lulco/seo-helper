<?php

namespace SeoHelper\Generator;

use SeoHelper\MetaData\BaseMetaData;

interface GeneratorInterface
{
    /**
     * @param BaseMetaData $metaData
     * @return string rendered meta data
     */
    public function render(BaseMetaData $metaData);
}
