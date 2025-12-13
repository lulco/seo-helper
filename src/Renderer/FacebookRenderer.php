<?php

declare(strict_types=1);

namespace SeoHelper\Renderer;

use function array_map;
use function array_reverse;
use function htmlspecialchars;
use function implode;
use function strip_tags;

class FacebookRenderer extends AbstractRenderer
{
    protected array $types = [
        'og' => '<meta property="{$key}" content="{$value}">',
        'fb' => '<meta property="{$key}" content="{$value}">',
    ];

    protected function initPreprocessors(): void
    {
        $this->setPreprocessor('og:title', function ($value) {
            return htmlspecialchars(strip_tags(implode(' | ', array_reverse($value))));
        });
        $this->setPreprocessor('og:description', function ($value) {
            return htmlspecialchars(strip_tags(implode(' ', $value)));
        });
        $this->setPreprocessor('og:url', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
        });
    }
}
