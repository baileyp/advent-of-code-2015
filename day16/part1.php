<?php

include 'header.php';

$scores = [];
foreach ($sues as $number => $sue) {
    $score = 0;

    foreach ($sue as $attribute => $value) {
        if ($value === $attributes[$attribute]) {
            $score += 1;
        }
    }
    $scores[$number] = $score;
}

echo array_search(max($scores), $scores);
