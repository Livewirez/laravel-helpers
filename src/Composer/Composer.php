<?php

namespace Livewirez\LaravelHelpers;

use stdClass;
use ArrayAccess;
use Iterator;
use Illuminate\Contracts\Support\Arrayable;

class Composer extends stdClass implements ArrayAccess, Iterator, Arrayable
{
    private int $position = 0;

    public function __construct(?object $composerautoload = null) {
        foreach (get_object_vars($composerautoload) as $name => $value) {
            $this->$name = $value;
        }
    }

    public function check_files_is_empty(): bool
    {
        return is_null($this->autoload?->files) || $this->autoload->files === [];
    }

    public function __toString()
    {
       return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    
    /* Methods */
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
       return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
       unset($this->$offset);
    }

    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $vars = [];
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $vars[$property->getName()] = $this->{$property->getName()};
        }
        return $vars;
        // return (array) $this;
    }

    // Return the key of the current element
    public function key(): mixed
    {
        $keys = array_keys($this->toArray());
        return $keys[$this->position];
    }

    // Return the current element
    public function current(): mixed
    {
        return $this->{$this->key()};
    }

    // Move forward to next element
    public function next(): void
    {
        $this->position++;
    }

    // Rewind the iterator to the first element
    public function rewind(): void
    {
        $this->position = 0;
    }

    // Check if current position is valid
    public function valid():bool
    {
        $keys = array_keys((array) $this);
        return isset($keys[$this->position]);
    }
}