<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $number
 */
class DynamicPropertyAccessModel extends Model
{
    public string $name;

    public function getNumber(): int
    {
        return $this->number; // OK
    }

    public function setNumber(int $number): void
    {
        $this->number = $number; // OK
    }

}


$class = new DynamicPropertyAccessModel();


echo $class->name; // OK

echo $class->number; // ERROR

echo $class->getNumber(); // OK

$class->setNumber(20); // OK

$class->number = 20; // ERROR

$class->name = 'Trinder'; // OK
