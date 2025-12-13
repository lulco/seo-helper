<?php

declare(strict_types=1);

namespace SeoHelper\Renderer;

use function array_map;
use function array_reverse;
use function array_unique;
use function htmlspecialchars;
use function implode;
use function strip_tags;

class DefaultRenderer extends AbstractRenderer
{
    protected array $types = [
        'default' => '<meta name="{$key}" content="{$value}">',
        'title' => '<title>{$value}</title>',
        'canonical' => '<link rel="canonical" href="{$value}">',
        'next' => '<link rel="next" href="{$value}">',
        'prev' => '<link rel="prev" href="{$value}">',
    ];

    protected function getPattern($type): ?string
    {
        return parent::getPattern($type) ?: $this->types['default'];
    }

    protected function initPreprocessors(): void
    {
        $this->setPreprocessor('default', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, (array)$value);
        });
        $this->setPreprocessor('title', function ($value) {
            return strip_tags(implode(' | ', array_reverse($value)));
        });
        $this->setPreprocessor('description', function ($value) {
            return htmlspecialchars(strip_tags(implode(' ', $value)));
        });
        $this->setPreprocessor('keywords', function ($value) {
            return htmlspecialchars(strip_tags(implode(', ', array_unique($value))));
        });
        $this->setPreprocessor('canonical', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
        });
        $this->setPreprocessor('next', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
        });
        $this->setPreprocessor('prev', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
        });
    }

    protected function preprocessValue($key, $value)
    {
        $preprocessor = $this->preprocessors[$key] ?? $this->preprocessors['default'];
        return $preprocessor($value);
    }
}
