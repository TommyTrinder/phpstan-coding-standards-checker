<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Routing\Controller;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<MethodCall> */
final class LimitedRepositoryAccessFromControllerRule implements Rule
{
    public function __construct(
    ) {
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $callingClass = $scope->getClassReflection();

        if ($callingClass === null) {
            return [];
        }

        if (!$callingClass->isSubclassOf(Controller::class)) {
            return [];
        }

        $methodName = $node->name;

        if (!$methodName instanceof Node\Identifier) {
            return [];
        }

        $methodName = $methodName->toLowerString();

        if (str_starts_with(haystack: $methodName, needle: 'get')) {
            return [];
        }

        if (str_starts_with(haystack: $methodName, needle: 'find')) {
            return [];
        }

        $varType = $scope->getType($node->var);

        foreach ($varType->getReferencedClasses() as $referencedClass) {
            $isRepository = str_ends_with(haystack: $referencedClass, needle: 'Repository');

            if ($isRepository) {
                return [
                    RuleErrorBuilder::message(
                        'Accessing Repositories in a Controller is limited to get* and find* methods only.'
                    )->build(),
                ];
            }
        }

        return [];
    }
}
