<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;

class DatabaseMethodCallsInModel extends Model
{
    public function persist(): void
    {
        $this->save(); // ERROR
    }

    public function anotherMethod(): void
    {
        // Empty method
    }

    public function aMethod(): void
    {
        $this->anotherMethod(); // OK
    }

    public function saveOnService(AService $service): void
    {
        $service->save(); // OK
    }
}

$service = new AService();
$service->save(); // OK


$person = new DatabaseMethodCallsInModel();

$person->save(); // ERROR

$person->persist(); // OK