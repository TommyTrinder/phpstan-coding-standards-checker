<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;


class ModelDatabaseMethodCallsInRepository
{
    public function persist(MyModel $myModel): void
    {
        $myModel->save(); // OK;
    }

    public function persistNoneModel(AService $aService): void
    {
        $aService->save(); // OK;
    }

}

