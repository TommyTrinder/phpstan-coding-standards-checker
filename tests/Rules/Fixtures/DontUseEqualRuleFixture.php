<?php

function comparisons(?int $number): void
{
    if ($number == null) { // ERROR
        echo 'Null';
    }

    if ($number === null) {
        echo 'Null';
    }

    if ($number == 1) { // ERROR
        echo '1';
    }

    if ($number === 1) {
        echo '1';
    }
}
