<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Support\Facades\DB;

class DbCallInRepository
{
    public function aMethod(): void
    {
        AService::where('foo', 'bar'); // OK
        DB::select('foo', []); // OK
    }
}