<?php

$input = file_get_contents(__DIR__ . '/input');
$data = json_decode($input);

echo array_sum_recursive($data);

function array_sum_recursive($array)
{
    if (is_object($array) && false !== array_search('red', (array) $array, true)) {
        return 0;
    }
    $sum = 0;
    foreach ((array) $array as $value) {
        if (is_object($value) || is_array($value)) {
            $sum += array_sum_recursive($value);
        }
        elseif (is_int($value)) {
            $sum += $value;
        }
    }
    return $sum;
}
