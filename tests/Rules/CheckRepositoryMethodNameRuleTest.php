<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\CheckRepositoryMethodNamesRule;

/** @extends AbstractRuleTestCase<CheckRepositoryMethodNamesRule> */
final class CheckRepositoryMethodNameRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new CheckRepositoryMethodNamesRule();
    }

    public function testRepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/CheckNamesInRepository.php'
        );
    }

    public function testNotARepository(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/CheckNamesInService.php'
        );
    }
}
