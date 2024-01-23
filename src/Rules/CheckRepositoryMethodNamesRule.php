<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use TommyTrinder\PhpstanRules\Helpers\TypeDetector;

/** @implements Rule<ClassMethod> */
class CheckRepositoryMethodNamesRule implements Rule
{
    private const ALTERNATIVE_PERSIST_METHOD_NAMES = [
        'save',
    ];

    private const ALTERNATIVE_DELETE_METHOD_NAMES = [
        'remove',
    ];

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        // Only interested in Repository class
        if (!TypeDetector::isInRepositoryClass($scope)) {
            return [];
        }

        $methodName = $node->name->toLowerString();

        $return = $this->suggestAlternativeMethodNames($methodName, 'persist', self::ALTERNATIVE_PERSIST_METHOD_NAMES);
        if ($return !== null) {
            return $return;
        }

        $return = $this->suggestAlternativeMethodNames($methodName, 'delete', self::ALTERNATIVE_DELETE_METHOD_NAMES);
        if ($return !== null) {
            return $return;
        }

        $returnType = $node->returnType;

        if (str_starts_with(haystack: $methodName, needle: 'find')) {
            if (!$returnType instanceof NullableType) {
                return [
                    RuleErrorBuilder::message('find methods must have nullable in return type')->build(),
                ];
            }
        }

        if (str_starts_with(haystack: $methodName, needle: 'get')) {
            if ($returnType instanceof NullableType) {
                return [
                    RuleErrorBuilder::message('get methods must NOT have nullable in return type')->build(),
                ];
            }
        }

        return [];
    }

    /**
     * @param list<lowercase-string> $alternativeNames
     *
     * @return list<RuleError>|null
     */
    private function suggestAlternativeMethodNames(string $methodName, string $correctName, array $alternativeNames): ?array
    {
        if ($methodName === $correctName) {
            return [];
        }

        if (in_array($methodName, $alternativeNames, true)) {
            return [
                RuleErrorBuilder::message("Use the name '$correctName' for this method")->build(),
            ];
        }

        return null;
    }
}
