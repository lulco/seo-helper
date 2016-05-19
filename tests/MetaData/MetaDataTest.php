<?php

namespace SeoHelper\Tests\MetaData;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\MetaData\MetaData;

class MetaDataTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleSetGet()
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertTrue(empty($metaData->get()));
        
        $this->assertFalse($metaData->getCanonical());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setCanonical('canonical-url'));
        $this->assertEquals(['canonical-url'], $metaData->getCanonical());
    }
    
    public function testAdd()
    {
        $metaData = new MetaData();
        $this->assertTrue(empty($metaData->get()));
        
        $this->assertFalse($metaData->getTitle());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('First title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('Second title'));
        $this->assertEquals(['First title', 'Second title'], $metaData->getTitle());
    }
    
    public function testReset()
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertTrue(empty($metaData->get()));
        
        $this->assertFalse($metaData->getCanonical());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setCanonical('canonical-url'));
        $this->assertEquals(['canonical-url'], $metaData->getCanonical());
        
        $this->assertInstanceOf(BaseMetaData::class, $metaData->resetCanonical('new-canonical-url'));
        $this->assertEquals(['new-canonical-url'], $metaData->getCanonical());
        
        $this->assertInstanceOf(BaseMetaData::class, $metaData->resetCanonical());
        $this->assertFalse($metaData->getCanonical());
    }
    
    public function testNoAlias()
    {
        $metaData = new MetaData();
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('First title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('Second title'));
        $this->assertEquals(['First title', 'Second title'], $metaData->getTitle());
        $this->assertFalse($metaData->getOgTitle());
        $this->assertFalse($metaData->getTwitterTitle());
    }
    
    public function testAlias()
    {
        $metaData = new MetaData();
        $this->assertInstanceOf(BaseMetaData::class, $metaData->alias('title', 'og:title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->alias('title', ['twitter:title']));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('First title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('Second title'));
        $this->assertEquals(['First title', 'Second title'], $metaData->getTitle());
        $this->assertEquals(['First title', 'Second title'], $metaData->getOgTitle());
        $this->assertEquals(['First title', 'Second title'], $metaData->getTwitterTitle());
    }
    
    public function testUnknownMethod()
    {
        $metaData = new MetaData();
        $this->setExpectedExceptionRegExp(InvalidArgumentException::class, "/Method 'unknown' not found/");
        $metaData->unknown('asdf');
    }
}
