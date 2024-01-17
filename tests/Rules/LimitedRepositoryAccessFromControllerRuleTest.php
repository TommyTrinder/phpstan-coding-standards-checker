<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\LimitedRepositoryAccessFromControllerRule;

/** @extends AbstractRuleTestCase<LimitedRepositoryAccessFromControllerRule> */
final class LimitedRepositoryAccessFromControllerRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new LimitedRepositoryAccessFromControllerRule();
    }

    public function testInController(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/RepositoryAccessWithinController.php'
        );
    }

    public function testOutsideController(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/RepositoryAccessNotInAController.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Accessing Repositories in a Controller is limited to get* and find* methods only.';
    }
}
