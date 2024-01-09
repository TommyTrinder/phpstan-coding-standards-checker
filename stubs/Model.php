<?php

namespace Illuminate\Database\Eloquent;

class Model
{
    public function __get(string $name)
    {
        return $this->$name;
    }
}
