<?php

declare(strict_types=1);

namespace SeoHelper\Renderer;

use Closure;
use function array_keys;
use function is_array;
use function str_replace;

abstract class AbstractRenderer implements RendererInterface
{
    protected array $types = [];

    protected array $preprocessors = [];

    final public function init(): void
    {
        $this->initPreprocessors();
    }

    public function getTypes(): array
    {
        return array_keys($this->types);
    }

    public function render(string $type, string $key, mixed $value): string|array|null
    {
        $pattern = $this->getPattern($type);
        if (!$pattern) {
            return null;
        }
        $finalValue = $this->preprocessValue($key, $value);
        if (!is_array($finalValue)) {
            return str_replace(['{$key}', '{$value}'], [$key, $finalValue], $pattern);
        }
        $items = [];
        foreach ($finalValue as $val) {
            $items[] = str_replace(['{$key}', '{$value}'], [$key, $val], $pattern);
        }
        return $items;
    }

    public function setPreprocessor(string $type, Closure $closure): static
    {
        $this->preprocessors[$type] = $closure;
        return $this;
    }

    protected function getPattern($type): ?string
    {
        return $this->types[$type] ?? null;
    }

    protected function preprocessValue($key, $value)
    {
        $preprocessor = $this->preprocessors[$key] ?? null;
        if (!$preprocessor) {
            return $value;
        }
        return $preprocessor($value);
    }

    abstract protected function initPreprocessors(): void;
}
