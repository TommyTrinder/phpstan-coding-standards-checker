<?php

namespace TommyTrinder\PhpstanRules\Helpers;

use Illuminate\Database\Migrations\Migration;
use PHPStan\Analyser\Scope;

final class TypeDetector
{
    public static function isInRepositoryOrMigrationClass(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();

        if ($classReflection === null) {
            return false;
        }

        if ($classReflection->isSubclassOf(Migration::class)) {
            return true;
        }

        $callingClass = $classReflection->getName();

        return str_ends_with($callingClass, 'Repository');
    }

    public static function isInRepositoryClass(Scope $scope): bool
    {
        $className = $scope->getClassReflection()?->getName();
        if ($className === null) {
            return false;
        }

        return str_ends_with(haystack: $className, needle: 'Repository');
    }
}
