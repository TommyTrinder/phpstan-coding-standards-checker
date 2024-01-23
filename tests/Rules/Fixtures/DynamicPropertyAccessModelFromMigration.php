<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;


/**
 * @property int $number
 */
class DynamicPropertyAccessModelFromMigration extends Model
{

}

new class extends Migration
{
    public function getNumber(DynamicPropertyAccessModelFromMigration $myModel): int
    {
        return $myModel->number; // OK in a migration
    }

};

