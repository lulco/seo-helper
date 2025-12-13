<?php

declare(strict_types=1);

namespace SeoHelper\Renderer;

interface RendererInterface
{
    /**
     * initialize renderer
     */
    public function init(): void;

    /**
     * @return array types which will be rendered with this renderer
     */
    public function getTypes(): array;

    /**
     * @return string|array|null rendered item(s) or null on failure
     */
    public function render(string $type, string $key, mixed $value): string|array|null;
}
