<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\MissingMethodReturnTypeDeclarationRule;

/** @extends AbstractRuleTestCase<MissingMethodReturnTypeDeclarationRule> */
final class MissingMethodReturnTypeDeclarationRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new MissingMethodReturnTypeDeclarationRule();
    }

    public function testRule(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/MissingMethodReturnTypeDeclarationRuleFixture.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Missing return type declaration';
    }
}
