<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

/**
 * @property int $number
 */
class DynamicPropertyAccessNotAModel
{

    public string $name;

    public function __construct(string $name, int $number)
    {
        $this->name = $name;
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number; // OK
    }

    public function setNumber(int $number): void
    {
        $this->number = $number; // OK
    }


}


$class = new DynamicPropertyAccessNotAModel('Tommy', 10);


echo $class->name; // OK

echo $class->number; // OK

echo $class->getNumber(); // OK

$class->setNumber(20); // OK

$class->number = 20; // OK

$class->name = 'Trinder'; // OK
