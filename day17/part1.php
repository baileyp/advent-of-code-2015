<?php

include 'header.php';

$combinations = 0;
for ($i = pow(2, count($containers)) - 1; $i > 0; $i--) {
    $volume = 0;
    foreach ($containers as $place => $value) {
        if ($i & (1 << $place)) {
            $volume += $value;
        }
        if ($volume > VOLUME) {
            break 1;
        }
    }
    if ($volume === VOLUME) {
        $combinations++;
    }
}

echo $combinations;