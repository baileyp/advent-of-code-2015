<?php

include 'header.php';

function scoreMix($mix, $properties) {
    unset($properties['calories']);
    $scores = array_map(function($ingredients) use ($mix) {
        $i = 0;
        $score = 0;
        foreach ($ingredients as $name => $value) {
            $score += $value * $mix[$i];
            $i++;
        }
        return max(0, $score);

    }, $properties);

    return array_product($scores);
}

$mixes = [];
foreach ($mixtures as $mix) {
    $mixes[] = scoreMix($mix, $properties);
}

echo max($mixes);