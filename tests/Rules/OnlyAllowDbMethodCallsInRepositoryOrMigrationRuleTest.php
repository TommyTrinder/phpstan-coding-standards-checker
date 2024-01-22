<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowModelDbMethodCallsInRepositoryOrMigrationRule;

/** @extends AbstractRuleTestCase<OnlyAllowModelDbMethodCallsInRepositoryOrMigrationRule> */
final class OnlyAllowDbMethodCallsInRepositoryOrMigrationRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowModelDbMethodCallsInRepositoryOrMigrationRule($this->createReflectionProvider());
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

    public function testDatabaseCallsInMigration(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/ModelDatabaseMethodCallsInMigration.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call Model Database calls from here. Move code to a Repository.';
    }
}
