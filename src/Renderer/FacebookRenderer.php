<?php

namespace SeoHelper\Renderer;

class FacebookRenderer extends AbstractRenderer
{
    protected $types = [
        'og' => '<meta property="{$key}" content="{$value}">',
        'fb' => '<meta property="{$key}" content="{$value}">',
    ];

    protected function initPreprocessors()
    {
        $this->setPreprocessor('og:title', function ($value) {
            return htmlspecialchars(strip_tags(implode(' | ', array_reverse($value))));
        });
        $this->setPreprocessor('og:description', function ($value) {
            return htmlspecialchars(strip_tags(implode(' ', $value)));
        });
        $this->setPreprocessor('og:url', function ($value) {
            return htmlspecialchars(strip_tags(implode($value)));
        });
    }
}
