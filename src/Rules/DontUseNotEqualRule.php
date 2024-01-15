<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<NotEqual> */
final class DontUseNotEqualRule implements Rule
{
    public function getNodeType(): string
    {
        return NotEqual::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't use not equal comparison (!=). User strict not equal comparison (!==) instead.")->build(),
        ];
    }
}
