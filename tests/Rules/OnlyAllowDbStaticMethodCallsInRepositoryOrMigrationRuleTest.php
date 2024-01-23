<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\OnlyAllowModelDbStaticMethodCallsInRepositoryOrMigrationRule;

/** @extends AbstractRuleTestCase<OnlyAllowModelDbStaticMethodCallsInRepositoryOrMigrationRule> */
final class OnlyAllowDbStaticMethodCallsInRepositoryOrMigrationRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new OnlyAllowModelDbStaticMethodCallsInRepositoryOrMigrationRule($this->createReflectionProvider());
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

    public function testDatabaseCallsInMigration(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DatabaseStaticCallsInMigration.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Do not call Model Database calls from here. Move code to a Repository.';
    }
}
