<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Param;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Param> */
final class MissingArgumentTypeDeclarationRule implements Rule
{
    public function getNodeType(): string
    {
        return Param::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->type !== null) {
            return [];
        }

        if (!$node->var instanceof Node\Expr\Variable) {
            return [];
        }

        $parameterName = $node->var->name;

        if (!is_string($parameterName)) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Missing parameter type declaration for '.$parameterName)->build(),
        ];
    }
}
