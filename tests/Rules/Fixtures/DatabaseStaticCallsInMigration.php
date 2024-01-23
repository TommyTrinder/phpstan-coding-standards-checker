<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Migrations\Migration;

new class extends Migration
{
    public function getPeople(): array
    {
        return MyModel::where('name', 'Tommy'); // OK;
    }
};
