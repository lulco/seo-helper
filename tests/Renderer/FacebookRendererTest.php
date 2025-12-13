<?php

declare(strict_types=1);

namespace SeoHelper\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use SeoHelper\Renderer\FacebookRenderer;

final class FacebookRendererTest extends TestCase
{
    public function testTypes(): void
    {
        $renderer = new FacebookRenderer();
        $this->assertTrue(is_array($renderer->getTypes()));
        $this->assertEquals(['og', 'fb'], $renderer->getTypes());
    }

    public function testDefault(): void
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertNull($renderer->render('something', 'some-meta-name', 'some-meta-value'));
    }

    public function testOgTitle(): void
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="og:title" content="Second title | First title">', $renderer->render('og', 'og:title', ['First title', 'Second <strong>title</strong>']));
        $this->assertEquals('<meta property="og:title" content="&quot;Second&quot; title | &#039;First&#039; title">', $renderer->render('og', 'og:title', ['\'First\' title', '"Second" <strong>title</strong>']));
        $this->assertEquals('<meta property="og:title" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('og', 'og:title', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testDescription(): void
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="og:description" content="First description Second description">', $renderer->render('og', 'og:description', ['First <strong>description</strong>', 'Second description']));
        $this->assertEquals('<meta property="og:description" content="&#039;First&#039; description &quot;Second&quot; description">', $renderer->render('og', 'og:description', ['\'First\' <strong>description</strong>', '"Second" description']));
        $this->assertEquals('<meta property="og:description" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('og', 'og:description', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testUrl(): void
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertEquals(['<meta property="og:url" content="og-url">'], $renderer->render('og', 'og:url', ['og-url']));
    }
}
