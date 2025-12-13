<?php

declare(strict_types=1);

namespace SeoHelper\Generator;

use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\Renderer\RendererInterface;

class BaseGenerator implements GeneratorInterface
{
    /** @var RendererInterface[] */
    private array $renderers = [];

    public function render(BaseMetaData $metaData): string
    {
        return implode("\n", $this->prepare($metaData));
    }

    private function prepare(BaseMetaData $metaData): array
    {
        $items = [];
        foreach ($this->sortMetaData($metaData->get()) as $key => $value) {
            $keyParts = explode(':', $key);
            $type = current($keyParts);
            /* @var $renderer RendererInterface */
            $renderer = $this->findRenderer($type);
            if (!$renderer) {
                continue;
            }
            $item = $renderer->render($type, $key, $value);
            if (!$item) {
                continue;
            }
            if (!is_array($item)) {
                $item = [$item];
            }
            $items = array_merge($items, $item);
        }
        return $items;
    }

    public function addRenderer(RendererInterface $renderer): static
    {
        $renderer->init();
        foreach ($renderer->getTypes() as $type) {
            $this->renderers[$type] = $renderer;
        }
        return $this;
    }

    protected function sortMetaData(array $metaData): array
    {
        return $metaData;
    }

    private function findRenderer($type): ?RendererInterface
    {
        $renderer = $this->renderers[$type] ?? null;
        return $renderer ?: ($this->renderers['default'] ?? null);
    }
}
