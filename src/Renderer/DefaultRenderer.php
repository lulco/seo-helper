<?php

namespace SeoHelper\Renderer;

class DefaultRenderer extends AbstractRenderer
{
    protected $types = [
        'default' => '<meta name="{$key}" content="{$value}">',
        'title' => '<title>{$value}</title>',
        'canonical' => '<link rel="canonical" href="{$value}">',
        'next' => '<link rel="next" href="{$value}">',
        'prev' => '<link rel="prev" href="{$value}">',
    ];

    protected function getPattern($type)
    {
        return parent::getPattern($type) ?: $this->types['default'];
    }

    protected function initPreprocessors()
    {
        $this->setPreprocessor('default', function ($value) {
            return array_map(function ($val) {
                return htmlspecialchars(strip_tags($val));
            }, $value);
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
        $preprocessor = isset($this->preprocessors[$key]) ? $this->preprocessors[$key] : $this->preprocessors['default'];
        return $preprocessor($value);
    }
}
