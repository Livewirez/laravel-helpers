<?php

namespace Livewirez\LaravelHelpers\Composer;

use stdClass;
use ArrayAccess;

class Composer extends stdClass implements ArrayAccess
{
    public function __construct(?object $composerautoload = null) {
        foreach (get_object_vars($composerautoload) as $name => $value) {
            $this->$name = $value;
        }
    }

    public function composer_has_files(): bool
    {
        if (property_exists($this, 'autoload')) {
            return ! is_null($this->autoload?->files) || $this->autoload->files !== [];
        }

        return false;
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
}