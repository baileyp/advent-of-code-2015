<?php

include 'header.php';

$combinations = [];
for ($i = pow(2, count($containers)) - 1; $i > 0; $i--) {
    $volume = 0;
    $containersUsed = 0;
    foreach ($containers as $place => $value) {
        if ($i & (1 << $place)) {
            $volume += $value;
            $containersUsed += 1;
        }
    }
    if ($volume === VOLUME) {
        $combinations[$containersUsed] += 1;
    }
}

echo $combinations[min(array_keys($combinations))];