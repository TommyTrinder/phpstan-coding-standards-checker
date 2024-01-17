<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

use Illuminate\Routing\Controller;

class RepositoryAccessWithinController extends Controller
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

        $this->myRepository->persist(); // ERROR
        $this->notARepository->persist();

        return 'a response';
    }
}

