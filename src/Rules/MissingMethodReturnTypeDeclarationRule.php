<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<ClassMethod> */
final class MissingMethodReturnTypeDeclarationRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->returnType !== null) {
            return [];
        }

        if ('__construct' === $node->name->toLowerString()) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Missing return type declaration')->build(),
        ];
    }
}
