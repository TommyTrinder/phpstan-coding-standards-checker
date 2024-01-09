<?php

function noIfConditionStatements(int $number): void
{
    if ($number > 10) {} // ERROR
}

function noIfConditionStatementsWithElse(int $number): void
{
    if ($number > 10) {} // ERROR
    else {
        echo 'Number is less than 10';
    }
}

function noElseConditionStatements(int $number): void
{
    if ($number > 10) {
        echo 'Number is greater than 10';
    } else {} // ERROR
}

function noElseIfConditionStatements(int $number): void
{
    if ($number > 10) {
        echo 'Number is greater than 10';
    } elseif ($number < 10) { // ERROR
    } else {
        echo 'Number is 10';
    }
}


function multipleElseIfConditionStatements(int $number): void
{
    if ($number > 10) {
        echo 'Number is greater than 10';
    } elseif ($number < 6) {
        echo 'Number is less than 6';
    } elseif ($number < 7) {
        echo 'Number is less than 7';
    } elseif ($number < 8) { // ERROR
    } elseif ($number < 9) {
        echo 'Number is less than 9';
    } else {
        echo 'Number is 10';
    }
}


function correctUsageOfIf(int $number): void
{
    if ($number > 10) {
        echo 'Number is greater than 10';
    } elseif ($number < 10) {
        echo 'Number is less than 10';
    } else {
        echo 'Number is 10';
    }
}
