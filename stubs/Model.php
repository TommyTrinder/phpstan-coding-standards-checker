<?php

namespace Illuminate\Database\Eloquent;

class Model
{
    public function __get(string $name)
    {
        return $this->$name;
    }

    public static function where(string $name, string $value): array
    {
        return [];
    }

    public function save(): void
    {
    }
}
