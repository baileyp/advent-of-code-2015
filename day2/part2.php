<?php

$feetOfRibbon = 0;

$input = fopen(__DIR__ . '/input', 'r');

while ($line = fgets($input)) {
    $feetOfRibbon += call_user_func_array('calculateRibbon', explode('x', $line));
}

fclose($input);

echo 'Linear Feet of Ribbon: ', $feetOfRibbon, PHP_EOL;

function calculateRibbon($length, $width, $height)
{
    $perim1 = $length + $length + $width + $width;
    $perim2 = $width + $width + $height + $height;
    $perim3 = $length + $length + $height + $height;

    $packageLength = min([$perim1, $perim2, $perim3]);
    $bowLength = $length * $width * $height;

    return $packageLength + $bowLength;
}