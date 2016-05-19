<?php

namespace SeoHelper\Tests\MetaData;

use PHPUnit_Framework_TestCase;
use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\MetaData\MetaData;

class FacebookMetaDataTest extends PHPUnit_Framework_TestCase
{
    public function testOgSiteName()
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertTrue(empty($metaData->get()));
        
        $this->assertFalse($metaData->getOgSiteName());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setOgSiteName('site-name'));
        $this->assertEquals(['site-name'], $metaData->getOgSiteName());
    }
}
