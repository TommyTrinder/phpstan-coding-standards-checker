<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

new class extends Migration
{
    public function aMethod(): void
    {
        AService::where('foo', 'bar'); // OK
        DB::select('foo', []); // OK
    }
};