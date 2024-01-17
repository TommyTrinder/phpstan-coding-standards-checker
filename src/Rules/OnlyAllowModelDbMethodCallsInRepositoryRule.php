<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use TommyTrinder\PhpstanRules\Helpers\NameExtractor;
use TommyTrinder\PhpstanRules\Helpers\TypeDetector;

/** @implements Rule<MethodCall> */
final class OnlyAllowModelDbMethodCallsInRepositoryRule implements Rule
{
    private const DATABASE_METHOD_NAMES = [
        'save',
    ];

    public function __construct(
        private ReflectionProvider $reflectionProvider
    ) {
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $methodName = NameExtractor::getFunctionName($node);

        if ($methodName === null) {
            return [];
        }

        if (!in_array($methodName, self::DATABASE_METHOD_NAMES)) {
            return [];
        }

        $classType = $scope->getType($node->var);

        $isModel = false;
        foreach ($classType->getReferencedClasses() as $className) {
            if ($this->reflectionProvider->getClass($className)->isSubclassOf(Model::class)) {
                $isModel = true;
            }
        }

        if (!$isModel) {
            return [];
        }

        if (TypeDetector::isInRepositoryClass($scope)) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Do not call Model Database calls from here. Move code to a Repository.')->build(),
        ];
    }
}
