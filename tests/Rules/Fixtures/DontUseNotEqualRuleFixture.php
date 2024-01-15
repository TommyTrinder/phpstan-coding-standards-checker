<?php

function comparisons(?int $number): void
{
    if ($number != null) { // ERROR
        echo 'Not null';
    }

    if ($number !== null) {
        echo 'Not null';
    }

    if ($number != 1) { // ERROR
        echo 'Not 1';
    }

    if ($number !== 1) {
        echo 'Not 1';
    }
}
