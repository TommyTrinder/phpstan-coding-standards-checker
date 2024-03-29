<?php

namespace TommyTrinder\PhpstanRules\Rules;

use Illuminate\Support\Facades\DB;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use TommyTrinder\PhpstanRules\Helpers\TypeDetector;

/** @implements Rule<StaticCall> */
final class OnlyAllowDbStaticCallsInRepositoryOrMigrationRule implements Rule
{
    public function getNodeType(): string
    {
        return StaticCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $class = $node->class;

        $isDbCall = false;

        if ($class instanceof Expr) {
            $classType = $scope->getType($class);

            foreach ($classType->getReferencedClasses() as $className) {
                if ($className === DB::class) {
                    $isDbCall = true;
                }
            }
        } else {
            $className = $scope->resolveName($class);
            if ($className === DB::class) {
                $isDbCall = true;
            }
        }

        if (!$isDbCall) {
            return [];
        }

        if (TypeDetector::isInRepositoryOrMigrationClass($scope)) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Do not call DB calls from here. Move code to a Repository.')->build(),
        ];
    }
}
