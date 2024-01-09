<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\NoDynamicPropertyAccessRule;

/** @extends AbstractRuleTestCase<NoDynamicPropertyAccessRule> */
final class NoDynamicPropertyAccessRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoDynamicPropertyAccessRule($this->createReflectionProvider());
    }

    public function testNotAModel(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DynamicPropertyAccessNotAModel.php'
        );
    }

    public function testModel(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DynamicPropertyAccessModel.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Accessing dynamic properties is not allowed.';
    }
}
