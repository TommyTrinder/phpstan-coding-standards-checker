<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;

class DatabaseStaticCallsInModel extends Model
{
    public function getPeople(): array
    {
        return self::where('name', 'Tommy'); // ERROR;
    }

    public static function aStaticMethod(): void
    {
        // Empty method
    }

    public function aMethod(): void
    {
        self::aStaticMethod(); // OK
    }
}


$person = new DatabaseStaticCallsInModel();

$people = $person::where('foo', 'bar'); // ERROR

$people2 = DatabaseStaticCallsInModel::where('foo', 'bar'); // ERROR

$person::aStaticMethod(); // OK