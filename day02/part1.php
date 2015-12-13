<?php

$squareFeetOfPaper = 0;

$input = fopen(__DIR__ . '/input', 'r');

while ($line = fgets($input)) {
    $squareFeetOfPaper += call_user_func_array('calculateWrapping', explode('x', $line));
}

fclose($input);

echo 'Square Feet of Paper: ', $squareFeetOfPaper, PHP_EOL;

function calculateWrapping($length, $width, $height)
{
    $lw = $length * $width;
    $wh = $width * $height;
    $hl = $height * $length;

    $smallestSide = min([$lw, $wh, $hl]);

    return (2 * $lw) + (2 * $wh) + (2 * $hl) + $smallestSide;
}