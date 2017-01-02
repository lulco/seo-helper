<?php

namespace SeoHelper\Tests\Component;

use PHPUnit_Framework_TestCase;
use SeoHelper\Bridge\Nette\Components\MetaData\MetaDataControl;
use SeoHelper\Generator\BaseGenerator;
use SeoHelper\Generator\DefaultGenerator;
use SeoHelper\MetaData\MetaData;
use SeoHelper\Renderer\DefaultRenderer;

class MetaDataControlTest extends PHPUnit_Framework_TestCase
{
    public function testComponentWithDefaultGenerator()
    {
        $metaData = new MetaData();
        $metaData->addTitle('First title');
        $metaData->addTitle('Second title');
        $metaData->setDescription('My description');
        $metaData->addOgImage('og-image-1');
        $metaData->addOgImage('og-image-2');

        $generator = new DefaultGenerator($metaData);

        $component = new MetaDataControl($metaData, $generator);

        ob_start();
        $component->render();
        $result = ob_get_contents();
        ob_end_clean();
        $this->assertEquals("<title>Second title | First title</title>\n<meta name=\"description\" content=\"My description\">\n<meta property=\"og:image\" content=\"og-image-1\">\n<meta property=\"og:image\" content=\"og-image-2\">", $result);
    }

    public function testComponentWithEmptyBaseGenerator()
    {
        $metaData = new MetaData();
        $metaData->addTitle('First title');
        $metaData->addTitle('Second title');
        $metaData->setDescription('My description');
        $metaData->addOgImage('og-image-1');
        $metaData->addOgImage('og-image-2');

        $generator = new BaseGenerator($metaData);

        $component = new MetaDataControl($metaData, $generator);

        ob_start();
        $component->render();
        $result = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('', $result);
    }

    public function testComponentWithBaseGenerator()
    {
        $metaData = new MetaData();
        $metaData->addTitle('First title');
        $metaData->addTitle('Second title');
        $metaData->setDescription('My description');
        $metaData->addOgImage('og-image-1');
        $metaData->addOgImage('og-image-2');

        $generator = new BaseGenerator($metaData);
        $renderer = new DefaultRenderer();
        $generator->addRenderer($renderer);

        $component = new MetaDataControl($metaData, $generator);

        ob_start();
        $component->render();
        $result = ob_get_contents();
        ob_end_clean();
        $this->assertEquals("<title>Second title | First title</title>\n<meta name=\"description\" content=\"My description\">\n<meta name=\"og:image\" content=\"og-image-1\">\n<meta name=\"og:image\" content=\"og-image-2\">", $result);
    }
}
