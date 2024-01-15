<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\DontUseEqualRule;

/** @extends AbstractRuleTestCase<DontUseEqualRule> */
final class DontUseEqualRuleTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontUseEqualRule();
    }

    public function testRule(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/DontUseEqualRuleFixture.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return "Don't use equal comparison (==). User strict comparison (===) instead.";
    }
}
