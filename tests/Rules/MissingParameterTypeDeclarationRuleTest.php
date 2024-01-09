<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\MissingArgumentTypeDeclarationRule;

/** @extends AbstractRuleTestCase<MissingArgumentTypeDeclarationRule> */
final class MissingParameterTypeDeclarationRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new MissingArgumentTypeDeclarationRule();
    }

    public function testRule(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/MissingParameterTypeDeclarationRuleFixture.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Missing parameter type declaration for {0}';
    }
}
