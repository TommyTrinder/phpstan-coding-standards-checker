<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<PropertyFetch> */
final class NoDynamicPropertyAccessRule implements Rule
{
    public function __construct(
        private readonly ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return PropertyFetch::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        // If we are in a migration, everything is OK
        $scopeClassReflection = $scope->getClassReflection();
        if ($scopeClassReflection !== null && $scopeClassReflection->isSubclassOf(Migration::class)) {
            return [];
        }

        // Now check if attempting to access a property defined in the docblock anywhere apart from in a Model
        $property = $node->name;

        if (!$property instanceof Node\Identifier) {
            return [];
        }

        $propertyName = $property->toLowerString();

        $classes = $scope->getType($node->var)->getReferencedClasses();

        foreach ($classes as $class) {
            $classReflection = $this->reflectionProvider->getClass($class);

            if (!$classReflection->isSubclassOf(Model::class)) {
                continue;
            }

            if ($scopeClassReflection?->getName() === $classReflection->getName()) {
                continue;
            }

            if ($classReflection->hasNativeProperty($propertyName)) {
                continue;
            }

            if ($classReflection->hasProperty($propertyName)) {
                return [
                    RuleErrorBuilder::message('Accessing dynamic properties is not allowed.')->build(),
                ];
            }
        }

        return [];
    }
}
