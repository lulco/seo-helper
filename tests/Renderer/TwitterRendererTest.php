<?php

declare(strict_types=1);

namespace SeoHelper\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use SeoHelper\Renderer\TwitterRenderer;
use function is_array;

final class TwitterRendererTest extends TestCase
{
    public function testTypes(): void
    {
        $renderer = new TwitterRenderer();
        $this->assertTrue(is_array($renderer->getTypes()));
        $this->assertEquals(['twitter'], $renderer->getTypes());
    }

    public function testDefault(): void
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertNull($renderer->render('something', 'some-meta-name', 'some-meta-value'));
    }

    public function testOgTitle(): void
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="twitter:title" content="Second title | First title">', $renderer->render('twitter', 'twitter:title', ['First title', 'Second <strong>title</strong>']));
        $this->assertEquals('<meta property="twitter:title" content="&quot;Second&quot; title | &#039;First&#039; title">', $renderer->render('twitter', 'twitter:title', ['\'First\' title', '"Second" <strong>title</strong>']));
        $this->assertEquals('<meta property="twitter:title" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('twitter', 'twitter:title', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testDescription(): void
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="twitter:description" content="First description Second description">', $renderer->render('twitter', 'twitter:description', ['First <strong>description</strong>', 'Second description']));
        $this->assertEquals('<meta property="twitter:description" content="&#039;First&#039; description &quot;Second&quot; description">', $renderer->render('twitter', 'twitter:description', ['\'First\' <strong>description</strong>', '"Second" description']));
        $this->assertEquals('<meta property="twitter:description" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('twitter', 'twitter:description', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testUrl(): void
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertEquals(['<meta property="twitter:url" content="twitter-url">'], $renderer->render('twitter', 'twitter:url', ['twitter-url']));
    }
}
