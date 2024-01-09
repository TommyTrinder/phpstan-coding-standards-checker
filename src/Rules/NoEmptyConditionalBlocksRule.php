<?php

namespace TommyTrinder\PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Else_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Nop;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<If_> */
final class NoEmptyConditionalBlocksRule implements Rule
{
    public function getNodeType(): string
    {
        return If_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        if ($this->isConditionalBlockEmpty($node)) {
            $errors[] = $this->createError($node);
        }

        $else = $node->else;
        if ($else !== null) {
            if ($this->isConditionalBlockEmpty($else)) {
                $errors[] = $this->createError($else);
            }
        }

        foreach ($node->elseifs as $elseif) {
            if ($this->isConditionalBlockEmpty($elseif)) {
                $errors[] = $this->createError($elseif);
            }
        }

        return $errors;
    }

    private function isConditionalBlockEmpty(If_|Else_|ElseIf_ $node): bool
    {
        if (count($node->stmts) === 0) {
            return true;
        }

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Nop) {
                continue;
            }

            return false;
        }

        return true;
    }

    private function createError(Node $node): RuleError
    {
        return RuleErrorBuilder::message('Empty conditional blocks are not allowed')->line($node->getLine())->build();
    }
}
