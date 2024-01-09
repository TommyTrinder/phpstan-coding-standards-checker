<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

final class MissingMethodReturnTypeDeclarationRuleFixture
{
    public function __construct()
    {
    }

    public function returnsVoid(): void
    {
    }

    public function missingReturnTypeDeclaration() // ERROR
    {
        return "string";
    }

    /**
     * @return string
     */
    public function missingReturnTypeDeclarationWithDocblock() // ERROR
    {
        return "string";
    }


    public function valid(): int
    {
        return 1;
    }

}
