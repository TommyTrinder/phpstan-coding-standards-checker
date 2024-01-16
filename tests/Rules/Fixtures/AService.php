<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

use Illuminate\Database\Eloquent\Model;

class AService
{
    public static function where(string $name, string $value): array
    {
        return [];
    }

    public function save(): void
    {

    }
}