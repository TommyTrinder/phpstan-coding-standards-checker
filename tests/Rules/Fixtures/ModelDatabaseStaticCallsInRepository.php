<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;


class ModelDatabaseStaticCallsInRepository
{
    public function callDatabaseStaticMethodOnModel(): array
    {
        return MyModel::where('name', 'Tommy'); // OK;
    }

    public function callDatabaseStaticMethodOnNoneModel(): array
    {
        return AService::where('name', 'Tommy'); // OK;
    }


}

