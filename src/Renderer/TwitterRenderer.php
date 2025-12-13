<?php

declare(strict_types=1);

namespace SeoHelper\Renderer;

use function array_map;
use function array_reverse;
use function htmlspecialchars;
use function implode;
use function strip_tags;

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
