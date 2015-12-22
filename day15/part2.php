<?php

include 'header.php';

function scoreMix($mix, $properties) {
    $scores = array_map(function($ingredients) use ($mix) {
        $i = 0;
        $score = 0;
        foreach ($ingredients as $value) {
            $score += $value * $mix[$i];
            $i++;
        }
        return max(0, $score);

    }, $properties);

    if ($scores['calories'] === 500) {
        unset($scores['calories']);
        return array_product($scores);
    }
    return 0;
}

$mixes = [];
foreach ($mixtures as $mix) {
    $mixes[] = scoreMix($mix, $properties);
}
echo max($mixes);