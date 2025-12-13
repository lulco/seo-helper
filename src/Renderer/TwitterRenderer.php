<?php

namespace SeoHelper\Renderer;

class TwitterRenderer extends AbstractRenderer
{
    protected array $types = [
        'twitter' => '<meta property="{$key}" content="{$value}">',
    ];

    protected function initPreprocessors(): void
    {
        $this->setPreprocessor('twitter:title', function ($value) {
            return htmlspecialchars(strip_tags(implode(' | ', array_reverse($value))));
        });
        $this->setPreprocessor('twitter:description', function ($value) {
            return htmlspecialchars(strip_tags(implode(' ', $value)));
        });
        $this->setPreprocessor('twitter:url', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
        });
    }
}
