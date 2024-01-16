<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowDbStaticCallsInRepositoryRule;

/** @extends AbstractRuleTestCase<OnlyAllowDbStaticCallsInRepositoryRule> */
final class OnlyAllowDbStaticCallsInRepositoryRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowDbStaticCallsInRepositoryRule();
    }

    public function testDatabaseCallsNotInRepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DbCallInService.php'
        );
    }

    public function testDatabaseCallsInRepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DbCallInRepository.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call DB calls from here. Move code to a Repository.';
    }
}
