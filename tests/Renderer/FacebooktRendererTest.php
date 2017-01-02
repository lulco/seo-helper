<?php

namespace SeoHelper\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use SeoHelper\Renderer\FacebookRenderer;

class FacebooktRendererTest extends PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $renderer = new FacebookRenderer();
        $this->assertTrue(is_array($renderer->getTypes()));
        $this->assertEquals(['og', 'fb'], $renderer->getTypes());
    }

    public function testDefault()
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertFalse($renderer->render('something', 'some-meta-name', 'some-meta-value'));
    }

    public function testOgTitle()
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="og:title" content="Second title | First title">', $renderer->render('og', 'og:title', ['First title', 'Second <strong>title</strong>']));
        $this->assertEquals('<meta property="og:title" content="&quot;Second&quot; title | \'First\' title">', $renderer->render('og', 'og:title', ['\'First\' title', '"Second" <strong>title</strong>']));
    }

    public function testDescription()
    {
        $renderer = new FacebookRenderer();
        $renderer->init();
        $this->assertEquals('<meta property="og:description" content="First description Second description">', $renderer->render('og', 'og:description', ['First <strong>description</strong>', 'Second description']));
        $this->assertEquals('<meta property="og:description" content="\'First\' description &quot;Second&quot; description">', $renderer->render('og', 'og:description', ['\'First\' <strong>description</strong>', '"Second" description']));
    }
}
