<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

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
        $methodNameNode = $node->name;

        if (!$methodNameNode instanceof Identifier) {
            return [];
        }

        if (!in_array($methodNameNode->name, self::DATABASE_METHOD_NAMES)) {
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

        $callingClass = $scope->getClassReflection()?->getName();

        if (($callingClass !== null) && str_ends_with($callingClass, 'Repository')) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Do not call Model Database calls from here. Move code to a Repository.')->build(),
        ];
    }
}
