<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


use Illuminate\Database\Migrations\Migration;

new class extends Migration
{
    public function persist(): void
    {
        $myModel = new MyModel();
        $myModel->save(); // OK - in migration
    }

};

