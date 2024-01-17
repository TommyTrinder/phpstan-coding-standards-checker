<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

class MyRepository
{

    public function getById(int $id): int
    {
        return 10;
    }

    public function findById(int $id): ?int
    {
        return $id > 10 ? 10 : null;
    }

    public function persist(): void
    {
        // do nothing
    }
}