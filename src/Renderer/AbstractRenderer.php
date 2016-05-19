<?php

namespace SeoHelper\Renderer;

use Closure;

abstract class AbstractRenderer implements RendererInterface
{
    protected $types = [];
    
    protected $preprocessors = [];
    
    public final function init()
    {
        $this->initPreprocessors();
    }
    
    /**
     * @return array
     */
    public function getTypes()
    {
        return array_keys($this->types);
    }
    
    /**
     * @param string $type
     * @param string $key
     * @param mixed $value
     * @return string|array|boolean rendered item(s) or false on failure
     */
    public function render($type, $key, $value)
    {
        $pattern = $this->getPattern($type);
        if (!$pattern) {
            return false;
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
    
    /**
     * @param string $type
     * @param Closure $closure function with one argument: $value
     * @return AbstractRenderer
     */
    public function setPreprocessor($type, Closure $closure)
    {
        $this->preprocessors[$type] = $closure;
        return $this;
    }
    
    protected function getPattern($type)
    {
        return isset($this->types[$type]) ? $this->types[$type] : null;
    }
    
    abstract protected function initPreprocessors();
    
    private function preprocessValue($key, $value)
    {
        $preprocessor = isset($this->preprocessors[$key]) ? $this->preprocessors[$key] : null;
        if (!$preprocessor) {
            return $value;
        }
        return $preprocessor($value);
    }
}
