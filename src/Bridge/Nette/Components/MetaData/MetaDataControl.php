<?php

namespace SeoHelper\Bridge\Nette\Components\MetaData;

use Nette\Application\UI\Control;
use SeoHelper\Generator\GeneratorInterface;
use SeoHelper\MetaData\BaseMetaData;

class MetaDataControl extends Control
{
    private $metaData;

    private $generator;

    public function __construct(BaseMetaData $metaData, GeneratorInterface $generator)
    {
        $this->metaData = $metaData;
        $this->generator = $generator;
    }

    public function render()
    {
        echo $this->generator->render($this->metaData);
    }
}
