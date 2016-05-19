<?php

namespace SeoHelper\Renderer;

interface RendererInterface
{
    /**
     * initialize renderer
     * @return RendererInterface
     */
    public function init();
    
    /**
     * @return array types which will be rendered with this renderer
     */
    public function getTypes();

    /**
     * @param string $type
     * @param string $key
     * @param mixed $value
     * @return string|array|boolean rendered item(s) or false on failure
     */
    public function render($type, $key, $value);
}
