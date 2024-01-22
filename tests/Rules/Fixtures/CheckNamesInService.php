<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;

class CheckNamesInService extends Model
{
    public function persist(): void // OK
    {}

    public function save(): void // OK
    {}

    public function delete(): void // OK
    {}

    public function remove(): void // OK
    {}

    public function findMyModel(): ?MyModel // OK
    {
        return new MyModel();
    }

    public function getModel(): MyModel // OK
    {
        return new MyModel();
    }

    public function findMyModelWrong(): MyModel // OK
    {
        return new MyModel();
    }

    public function getModelWrong(): ?MyModel // OK
    {
        return new MyModel();
    }

    public function getCount(): int // OK
    {
        return 1;
    }

    public function getCountWrong(): ?int // OK
    {
        return 1;
    }
}