<?php

namespace TommyTrinder\PhpstanRules\Helpers;

use PHPStan\Analyser\Scope;

final class TypeDetector
{
    public static function isInRepositoryClass(Scope $scope): bool
    {
        $callingClass = $scope->getClassReflection()?->getName();

        return ($callingClass !== null) && str_ends_with($callingClass, 'Repository');
    }
}
