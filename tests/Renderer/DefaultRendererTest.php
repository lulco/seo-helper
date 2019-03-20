<?php

namespace SeoHelper\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use SeoHelper\Renderer\DefaultRenderer;

class DefaultRendererTest extends PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $renderer = new DefaultRenderer();
        $this->assertTrue(is_array($renderer->getTypes()));
        $this->assertEquals(['default', 'title', 'canonical'], $renderer->getTypes());
    }

    public function testDefault()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals('<meta name="some-meta-name" content="some-meta-value">', $renderer->render('something', 'some-meta-name', 'some-meta-value'));
    }

    public function testTitle()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals('<title>Second title | First title</title>', $renderer->render('title', 'title', ['First title', 'Second <strong>title</strong>']));
        $this->assertEquals('<title>"Second" title | \'First\' title</title>', $renderer->render('title', 'title', ['\'First\' title', '"Second" <strong>title</strong>']));
    }

    public function testCanonical()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals(['<link rel="canonical" href="canonical-url">'], $renderer->render('canonical', 'canonical', ['canonical-url']));
    }

    public function testNext()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals(['<link rel="next" href="next-url">'], $renderer->render('next', 'next', ['next-url']));
    }

    public function testPrev()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals(['<link rel="prev" href="prev-url">'], $renderer->render('prev', 'prev', ['prev-url']));
    }
    
    public function testDescription()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals('<meta name="description" content="First description Second description">', $renderer->render('description', 'description', ['First <strong>description</strong>', 'Second description']));
        $this->assertEquals('<meta name="description" content="\'First\' description &quot;Second&quot; description">', $renderer->render('description', 'description', ['\'First\' <strong>description</strong>', '"Second" description']));
        $this->assertEquals('<meta name="description" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('description', 'description', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }

    public function testKeywords()
    {
        $renderer = new DefaultRenderer();
        $renderer->init();
        $this->assertEquals('<meta name="keywords" content="key1, key2, key3">', $renderer->render('keywords', 'keywords', ['key1', 'key2', 'key3']));
        $this->assertEquals('<meta name="keywords" content="key1, \'key2\', &quot;key3&quot;">', $renderer->render('keywords', 'keywords', ['key1', '\'key2\'', '"key3"']));
        $this->assertEquals('<meta name="keywords" content="&quot;Pán veľkomožný&quot; očakávam, že toto bude fungovať „bez problémov“">', $renderer->render('keywords', 'keywords', ['"Pán veľkomožný" <strong>očakávam</strong>, že toto bude fungovať „bez problémov“']));
    }
}
