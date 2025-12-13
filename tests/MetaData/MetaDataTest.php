<?php

declare(strict_types=1);

namespace SeoHelper\Tests\MetaData;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\MetaData\MetaData;

final class MetaDataTest extends TestCase
{
    public function testSimpleSetGet(): void
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertEmpty($metaData->get());

        $this->assertNull($metaData->getCanonical());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setCanonical('canonical-url'));
        $this->assertEquals(['canonical-url'], $metaData->getCanonical());
    }

    public function testAdd(): void
    {
        $metaData = new MetaData();
        $this->assertEmpty($metaData->get());

        $this->assertNull($metaData->getTitle());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('First title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('Second title'));
        $this->assertEquals(['First title', 'Second title'], $metaData->getTitle());
    }

    public function testReset(): void
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertEmpty($metaData->get());

        $this->assertNull($metaData->getCanonical());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setCanonical('canonical-url'));
        $this->assertEquals(['canonical-url'], $metaData->getCanonical());

        $this->assertInstanceOf(BaseMetaData::class, $metaData->resetCanonical('new-canonical-url'));
        $this->assertEquals(['new-canonical-url'], $metaData->getCanonical());

        $this->assertInstanceOf(BaseMetaData::class, $metaData->resetCanonical());
        $this->assertNull($metaData->getCanonical());
    }

    public function testResetAll(): void
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertEmpty($metaData->get());

        $this->assertInstanceOf(BaseMetaData::class, $metaData->setTitle('title'));
        $this->assertEquals(['title'], $metaData->getTitle());

        $this->assertInstanceOf(BaseMetaData::class, $metaData->setCanonical('canonical-url'));
        $this->assertEquals(['canonical-url'], $metaData->getCanonical());

        $this->assertNotEmpty($metaData->get());

        $metaData->resetAll();

        $this->assertEmpty($metaData->get());
        $this->assertNull($metaData->getCanonical());
        $this->assertNull($metaData->getTitle());
    }


    public function testNoAlias(): void
    {
        $metaData = new MetaData();
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('First title'));
        $this->assertInstanceOf(BaseMetaData::class, $metaData->addTitle('Second title'));
        $this->assertEquals(['First title', 'Second title'], $metaData->getTitle());
        $this->assertNull($metaData->getOgTitle());
        $this->assertNull($metaData->getTwitterTitle());
    }

    public function testAlias(): void
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

    public function testUnknownMethod(): void
    {
        $metaData = new MetaData();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/Method 'unknown' not found/");
        $metaData->unknown('asdf');
    }
}
