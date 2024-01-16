<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;


class ModelDatabaseCallsInRepository
{
    public function getPeople(): array
    {

        return MyModel::where('name', 'Tommy'); // OK;
    }

}

