<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowModelDbMethodCallsInRepositoryRule;

/** @extends AbstractRuleTestCase<OnlyAllowModelDbMethodCallsInRepositoryRule> */
final class OnlyAllowDbMethodCallsInRepositoryRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowModelDbMethodCallsInRepositoryRule($this->createReflectionProvider());
    }

    public function testDatabaseCallsInModel(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DatabaseMethodCallsInModel.php'
        );
    }

    public function testDatabaseCallsInRepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/ModelDatabaseMethodCallsInRepository.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call Model Database calls from here. Move code to a Repository.';
    }
}
