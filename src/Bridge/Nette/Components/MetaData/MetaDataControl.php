<?php

declare(strict_types=1);

namespace SeoHelper\Bridge\Nette\Components\MetaData;

use Nette\Application\UI\Control;
use SeoHelper\Generator\GeneratorInterface;
use SeoHelper\MetaData\BaseMetaData;

class MetaDataControl extends Control
{
    public function __construct(
        private BaseMetaData $metaData,
        private GeneratorInterface $generator
    ) {
    }

    public function render(): void
    {
        echo $this->generator->render($this->metaData);
    }
}
