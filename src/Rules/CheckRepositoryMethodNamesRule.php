<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Type;
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

        $returnType = $scope->getClassReflection()?->getMethod($methodName, $scope)->getVariants()[0]->getReturnType();

        if ($returnType === null) {
            return [];
        }

        if (str_starts_with(haystack: $methodName, needle: 'find')) {
            return $this->processFindMethod($returnType);
        }

        if (str_starts_with(haystack: $methodName, needle: 'get')) {
            return $this->processGetMethod($returnType);
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

    /** @return list<RuleError> */
    private function processFindMethod(Type $returnType): array
    {
        $nullable = $returnType->isNull();
        $iterable = $returnType->isIterable();

        // Only returns iterable - that's fine
        if ($iterable->yes()) {
            return [];
        }

        // Returns iterable or null, that is not allowed
        if ($nullable->maybe() && $iterable->maybe()) {
            return [
                RuleErrorBuilder::message('find methods must NOT be nullable if returning an iterable')->build(),
            ];
        }

        // Does not return nullable, not OK.
        if ($nullable->no()) {
            return [
                RuleErrorBuilder::message('find methods must have nullable in return type')->build(),
            ];
        }

        return [];
    }

    /** @return list<RuleError> */
    private function processGetMethod(Type $returnType): array
    {
        if (!$returnType->isNull()->no()) {
            return [
                RuleErrorBuilder::message('get methods must NOT have nullable in return type')->build(),
            ];
        }

        return [];
    }
}
