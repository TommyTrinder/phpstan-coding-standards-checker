<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\DontUseNotEqualRule;

/** @extends AbstractRuleTestCase<DontUseNotEqualRule> */
final class DontUseNotEqualRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontUseNotEqualRule();
    }

    public function testRule(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DontUseNotEqualRuleFixture.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return "Don't use not equal comparison (!=). User strict not equal comparison (!==) instead.";
    }
}
