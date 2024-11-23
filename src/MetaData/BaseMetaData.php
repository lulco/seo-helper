<?php

namespace SeoHelper\MetaData;

use InvalidArgumentException;

class BaseMetaData
{
    private $data = [];

    private $aliases = [];

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $propertyName = $this->createPropertyName(str_replace('get', '', $name));
            return $this->get($propertyName);
        } elseif (substr($name, 0, 3) == 'set') {
            $propertyName = $this->createPropertyName(str_replace('set', '', $name));
            return $this->set($propertyName, $arguments[0]);
        } elseif (substr($name, 0, 3) == 'add') {
            $propertyName = $this->createPropertyName(str_replace('add', '', $name));
            return $this->add($propertyName, $arguments[0]);
        } elseif (substr($name, 0, 5) == 'reset') {
            $propertyName = $this->createPropertyName(str_replace('reset', '', $name));
            return $this->reset($propertyName, isset($arguments[0]) ? $arguments[0] : null);
        }
        throw new InvalidArgumentException("Method '$name' not found");
    }

    /**
     * @param string $key
     * @param string|array $value
     * @return BaseMetaData
     */
    final public function set($key, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        foreach ($this->findAliases($key) as $alias) {
            $this->data[$alias] = $value;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string|array|null $newValue
     * @return BaseMetaData
     */
    final public function reset($key, $newValue = null)
    {
        if ($newValue !== null) {
            return $this->set($key, $newValue);
        }

        foreach ($this->findAliases($key) as $alias) {
            unset($this->data[$alias]);
        }
        return $this;
    }

    final public function resetAll()
    {
        $this->data = [];
        $this->aliases = [];
    }

    /**
     * @param string $key
     * @param string|array $value
     * @return BaseMetaData
     */
    final public function add($key, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        foreach ($this->findAliases($key) as $alias) {
            if (!isset($this->data[$alias])) {
                $this->data[$alias] = [];
            }
            $this->data[$alias] = array_merge($this->data[$alias], $value);
        }
        return $this;
    }

    /**
     * @param string $key
     * @return array|false all data if $key is null or data for $key as array or false if $key is not set in data
     */
    final public function get($key = null)
    {
        if ($key === null) {
            return $this->data;
        }
        return isset($this->data[$key]) ? $this->data[$key] : false;
    }

    /**
     * alias(es) for type
     * for example title => [og:title, twitter:title], in this case there is no need to set all types, because they will be set automatically with main type
     * @param string $type
     * @param string|array $alias
     */
    final public function alias($type, $alias)
    {
        if (!isset($this->aliases[$type])) {
            $this->aliases[$type] = [];
        }
        if (!is_array($alias)) {
            $this->aliases[$type][] = $alias;
            return $this;
        }

        $this->aliases[$type] = array_merge($this->aliases[$type], $alias);
        return $this;
    }

    private function createPropertyName($camelCase)
    {
        $length = strlen($camelCase);
        $lowerCamelCase = lcfirst($camelCase);
        $propertyName = '';
        for ($i = 0; $i < $length; $i++) {
            if ($lowerCamelCase[$i] == strtoupper($lowerCamelCase[$i])) {
                $propertyName .= ':';
            }
            $propertyName .= strtolower($lowerCamelCase[$i]);
        }
        return $propertyName;
    }

    private function findAliases($key)
    {
        $aliases = isset($this->aliases[$key]) ? $this->aliases[$key] : [];
        return array_merge([$key], $aliases);
    }
}
