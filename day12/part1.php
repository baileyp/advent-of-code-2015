<?php

$input = file_get_contents(__DIR__ . '/input');
$data = json_decode($input, true);

echo array_sum_recursive($data);

function array_sum_recursive($array)
{
    $sum = 0;
    foreach ($array as $value) {
        if (is_array($value)) {
            $sum += array_sum_recursive($value);
        }
        elseif (is_int($value)) {
            $sum += $value;
        }
    }
    return $sum;
}

