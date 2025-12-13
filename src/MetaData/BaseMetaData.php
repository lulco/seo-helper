<?php

declare(strict_types=1);

namespace SeoHelper\MetaData;

use InvalidArgumentException;
use function array_merge;
use function is_array;
use function lcfirst;
use function str_replace;
use function str_starts_with;
use function strlen;
use function strtolower;
use function strtoupper;

class BaseMetaData
{
    private array $data = [];

    private array $aliases = [];

    public function __call($name, $arguments)
    {
        if (str_starts_with($name, 'get')) {
            $propertyName = $this->createPropertyName(str_replace('get', '', $name));
            return $this->get($propertyName);
        } elseif (str_starts_with($name, 'set')) {
            $propertyName = $this->createPropertyName(str_replace('set', '', $name));
            return $this->set($propertyName, $arguments[0]);
        } elseif (str_starts_with($name, 'add')) {
            $propertyName = $this->createPropertyName(str_replace('add', '', $name));
            return $this->add($propertyName, $arguments[0]);
        } elseif (str_starts_with($name, 'reset')) {
            $propertyName = $this->createPropertyName(str_replace('reset', '', $name));
            return $this->reset($propertyName, $arguments[0] ?? null);
        }
        throw new InvalidArgumentException("Method '$name' not found");
    }

    final public function set(string $key, string|array $value): static
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        foreach ($this->findAliases($key) as $alias) {
            $this->data[$alias] = $value;
        }
        return $this;
    }

    final public function reset(string $key, string|array|null $newValue = null): static
    {
        if ($newValue !== null) {
            return $this->set($key, $newValue);
        }

        foreach ($this->findAliases($key) as $alias) {
            unset($this->data[$alias]);
        }
        return $this;
    }

    final public function resetAll(): void
    {
        $this->data = [];
        $this->aliases = [];
    }

    final public function add(string $key, string|array $value): static
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
     * @return array|null all data if $key is null or data for $key as array or null if $key is not set in data
     */
    final public function get(?string $key = null): ?array
    {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? null;
    }

    /**
     * alias(es) for type
     * for example title => [og:title, twitter:title], in this case there is no need to set all types, because they will be set automatically with main type
     */
    final public function alias(string $type, string|array $alias): static
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

    private function createPropertyName(string $camelCase): string
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

    private function findAliases(string $key): array
    {
        $aliases = $this->aliases[$key] ?? [];
        return array_merge([$key], $aliases);
    }
}
