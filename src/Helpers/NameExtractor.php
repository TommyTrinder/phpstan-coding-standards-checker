<?php

namespace TommyTrinder\PhpstanRules\Helpers;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;

final class NameExtractor
{
    public static function getFunctionName(StaticCall|MethodCall|FuncCall $call): ?string
    {
        $name = $call->name;

        if (!$name instanceof Identifier) {
            return null;
        }

        return $name->name;
    }
}
