<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Equal> */
final class DontUseEqualRule implements Rule
{
    public function getNodeType(): string
    {
        return Equal::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't use equal comparison (==). User strict comparison (===) instead.")->build(),
        ];
    }
}
