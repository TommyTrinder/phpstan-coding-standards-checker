<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules\Fixtures;

final class MissingParameterTypeDeclarationRuleFixture
{
    public function missingParameterTypeDeclaration($foo): void // ERROR foo
    {
    }

    /**
     * @param string $bar
     */
    public function missingParameterTypeDeclarationWithDocblock($bar): void // ERROR bar
    {
    }

    public function missingParameterTypeDeclarationButSomeSupplied($baz, string $name, int $age): void // ERROR baz
    {
    }

    public function takesNoArguments(): void
    {
    }

    public function validFunction(string $name, int $age): void
    {
    }
}


function missingParameterTypeDeclaration($foo): void // ERROR foo
{
}

/**
 * @param string $bar
 */
function missingParameterTypeDeclarationWithDocblock($bar): void // ERROR bar
{
}


