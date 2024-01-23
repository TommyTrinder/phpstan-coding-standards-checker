<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;

class CheckNamesInRepository extends Model
{
    public function persist(): void // OK
    {}

    public function save(): void // ERROR Use the name 'persist' for this method
    {}

    public function delete(): void // OK
    {}

    public function remove(): void // ERROR Use the name 'delete' for this method
    {}

    public function findMyModel(): ?MyModel // OK
    {
        return new MyModel();
    }

    public function getModel(): MyModel // OK
    {
        return new MyModel();
    }

    public function findMyModelWrong(): MyModel // ERROR find methods must have nullable in return type
    {
        return new MyModel();
    }

    public function getModelWrong(): ?MyModel // ERROR get methods must NOT have nullable in return type
    {
        return new MyModel();
    }

    public function getCount(): int // OK
    {
        return 1;
    }

    public function getCountWrong(): ?int // ERROR get methods must NOT have nullable in return type
    {
        return 1;
    }
}