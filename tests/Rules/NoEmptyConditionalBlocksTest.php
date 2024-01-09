<?php

namespace TommyTrinder\PhpstanRules\Tests\Rules;

use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use TommyTrinder\PhpstanRules\Rules\NoEmptyConditionalBlocksRule;

/** @extends AbstractRuleTestCase<NoEmptyConditionalBlocksRule> */
final class NoEmptyConditionalBlocksTest extends AbstractRuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoEmptyConditionalBlocksRule();
    }

    public function testRule(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/NoEmptyConditionalBlocksFixture.php'
        );
    }

    protected function getErrorFormatter(): string
    {
        return 'Empty conditional blocks are not allowed';
    }
}
