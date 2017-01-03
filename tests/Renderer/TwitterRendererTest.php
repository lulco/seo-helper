<?php

namespace SeoHelper\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use SeoHelper\Renderer\TwitterRenderer;

class TwittertRendererTest extends PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $renderer = new TwitterRenderer();
        $this->assertTrue(is_array($renderer->getTypes()));
        $this->assertEquals(['twitter'], $renderer->getTypes());
    }

    public function testDefault()
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertFalse($renderer->render('something', 'some-meta-name', 'some-meta-value'));
    }

    public function testOgTitle()
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="twitter:title" content="Second title | First title">', $renderer->render('twitter', 'twitter:title', ['First title', 'Second <strong>title</strong>']));
        $this->assertEquals('<meta property="twitter:title" content="&quot;Second&quot; title | \'First\' title">', $renderer->render('twitter', 'twitter:title', ['\'First\' title', '"Second" <strong>title</strong>']));
        $this->assertEquals('<meta property="twitter:title" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('twitter', 'twitter:title', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testDescription()
    {
        $renderer = new TwitterRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="twitter:description" content="First description Second description">', $renderer->render('twitter', 'twitter:description', ['First <strong>description</strong>', 'Second description']));
        $this->assertEquals('<meta property="twitter:description" content="\'First\' description &quot;Second&quot; description">', $renderer->render('twitter', 'twitter:description', ['\'First\' <strong>description</strong>', '"Second" description']));
        $this->assertEquals('<meta property="twitter:description" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('twitter', 'twitter:description', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }
}
