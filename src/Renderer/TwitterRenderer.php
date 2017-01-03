<?php

namespace SeoHelper\Renderer;

class TwitterRenderer extends AbstractRenderer
{
    protected $types = [
        'twitter' => '<meta property="{$key}" content="{$value}">',
    ];

    protected function initPreprocessors()
    {
        $this->setPreprocessor('twitter:title', function ($value) {
            return htmlspecialchars(strip_tags(implode(' | ', array_reverse($value))));
        });
        $this->setPreprocessor('twitter:description', function ($value) {
            return htmlspecialchars(strip_tags(implode(' ', $value)));
        });
    }
}
