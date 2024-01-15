<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

use Illuminate\Routing\Controller;

class RepositoryAccessNotInAController
{

    public function __construct(
        private readonly MyRepository $myRepository,
        private readonly MyService $notARepository,
    ) {
    }

    public function getSomething(int $id): string
    {
        $this->myRepository->getById($id);
        $this->myRepository->findById($id);

        $this->myRepository->persist();
        $this->notARepository->persist();

        return 'a response';
    }
}

