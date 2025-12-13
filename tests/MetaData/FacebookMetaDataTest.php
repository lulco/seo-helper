<?php

declare(strict_types=1);

namespace SeoHelper\Tests\MetaData;

use PHPUnit\Framework\TestCase;
use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\MetaData\MetaData;

final class FacebookMetaDataTest extends TestCase
{
    public function testOgSiteName(): void
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertEmpty($metaData->get());

        $this->assertNull($metaData->getOgSiteName());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setOgSiteName('site-name'));
        $this->assertEquals(['site-name'], $metaData->getOgSiteName());
    }

    public function testFbAppId(): void
    {
        $metaData = new MetaData();
        $this->assertTrue(is_array($metaData->get()));
        $this->assertEmpty($metaData->get());

        $this->assertNull($metaData->getFbAppId());
        $this->assertInstanceOf(BaseMetaData::class, $metaData->setFbAppId('fb-app-id'));
        $this->assertEquals(['fb-app-id'], $metaData->getFbAppId());
    }
}
