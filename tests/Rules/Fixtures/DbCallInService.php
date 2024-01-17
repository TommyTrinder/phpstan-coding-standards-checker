<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DbCallInService
{
    public function aMethod(): void
    {
        AService::where('foo', 'bar'); // OK
        DB::select('foo', []); // ERROR
    }
}