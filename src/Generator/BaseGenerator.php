<?php

namespace SeoHelper\Generator;

use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\Renderer\RendererInterface;

class BaseGenerator implements GeneratorInterface
{
    private $renderers = [];

    public function render(BaseMetaData $metaData)
    {
        return implode("\n", $this->prepare($metaData));
    }

    private function prepare(BaseMetaData $metaData)
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

    public function addRenderer(RendererInterface $renderer)
    {
        $renderer->init();
        foreach ($renderer->getTypes() as $type) {
            $this->renderers[$type] = $renderer;
        }
        return $this;
    }

    protected function sortMetaData($metaData)
    {
        return $metaData;
    }

    private function findRenderer($type)
    {
        $renderer = isset($this->renderers[$type]) ? $this->renderers[$type] : null;
        return $renderer ?: (isset($this->renderers['default']) ? $this->renderers['default'] : null);
    }
}
