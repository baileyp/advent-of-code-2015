<?php

include 'header.php';

$weights = array_map('intval', explode("\n", file_get_contents(__DIR__ . '/input')));
$balancedWeight = array_sum($weights) / 3;

$perms = findPermutations($weights, $balancedWeight);

echo min(array_map('array_product', $perms));