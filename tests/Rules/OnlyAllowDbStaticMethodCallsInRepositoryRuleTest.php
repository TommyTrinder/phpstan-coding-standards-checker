<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowModelDbStaticMethodCallsInRepositoryRule;

/** @extends AbstractRuleTestCase<OnlyAllowModelDbStaticMethodCallsInRepositoryRule> */
final class OnlyAllowDbStaticMethodCallsInRepositoryRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowModelDbStaticMethodCallsInRepositoryRule($this->createReflectionProvider());
    }

    public function testDatabaseCallsInModel(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DatabaseStaticCallsInModel.php'
        );
    }

    public function testDatabaseCallsInRepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/ModelDatabaseStaticCallsInRepository.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call Model Database calls from here. Move code to a Repository.';
    }
}
