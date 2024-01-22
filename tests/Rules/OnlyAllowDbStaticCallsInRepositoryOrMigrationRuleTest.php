<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowDbStaticCallsInRepositoryOrMigrationRule;

/** @extends AbstractRuleTestCase<OnlyAllowDbStaticCallsInRepositoryOrMigrationRule> */
final class OnlyAllowDbStaticCallsInRepositoryOrMigrationRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowDbStaticCallsInRepositoryOrMigrationRule();
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

    public function testDatabaseCallsInMigration(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DbCallInMigration.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call DB calls from here. Move code to a Repository.';
    }
}
