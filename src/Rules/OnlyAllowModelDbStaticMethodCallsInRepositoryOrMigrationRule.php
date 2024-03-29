<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use TommyTrinder\PhpstanRules\Helpers\NameExtractor;
use TommyTrinder\PhpstanRules\Helpers\TypeDetector;

/** @implements Rule<StaticCall> */
final class OnlyAllowModelDbStaticMethodCallsInRepositoryOrMigrationRule implements Rule
{
    private const DATABASE_METHOD_NAMES = [
        'all',
        'first',
        'firstOrFail',
        'get',
        'getConnection',
        'getModel',
        'where',
        'query',
        'count',
    ];

    public function __construct(
        private ReflectionProvider $reflectionProvider
    ) {
    }

    public function getNodeType(): string
    {
        return StaticCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $methodName = NameExtractor::getFunctionName($node);

        if ($methodName === null) {
            return [];
        }

        if (!in_array($methodName, self::DATABASE_METHOD_NAMES, true)) {
            return [];
        }

        $class = $node->class;

        if ($class instanceof Expr) {
            $classType = $scope->getType($class);

            $isModel = false;
            foreach ($classType->getReferencedClasses() as $className) {
                if ($this->reflectionProvider->getClass($className)->isSubclassOf(Model::class)) {
                    $isModel = true;
                }
            }

            if (!$isModel) {
                return [];
            }
        } else {
            $className = $scope->resolveName($class);

            $classReflection = $this->reflectionProvider->getClass($className);
            if (!$classReflection->isSubclassOf(Model::class)) {
                return [];
            }
        }

        if (TypeDetector::isInRepositoryOrMigrationClass($scope)) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Do not call Model Database calls from here. Move code to a Repository.')->build(),
        ];
    }
}
