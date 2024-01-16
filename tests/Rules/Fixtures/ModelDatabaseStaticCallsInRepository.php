<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;


class ModelDatabaseStaticCallsInRepository
{
    public function getPeople(): array
    {

        return MyModel::where('name', 'Tommy'); // OK;
    }

}

