<?php

include 'header.php';

$scores = [];
foreach ($sues as $number => $sue) {
    $score = 0;

    foreach ($sue as $attribute => $value) {
        if (null === $value) {
            continue;
        }
        switch ($attribute) {
            case 'cats':
            case 'trees':
                if ($value > $attributes[$attribute]) {
                    $score += 1;
                }
                break;
            case 'pomeranians':
            case 'goldfish':
                if ($value < $attributes[$attribute]) {
                    $score += 1;
                }
                break;
            default:
                if ($value === $attributes[$attribute]) {
                    $score += 1;
                }
                break;
        }
    }
    $scores[$number] = $score;
}

echo array_search(max($scores), $scores);
