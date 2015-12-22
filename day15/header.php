<?php

define('TEASPOONS', 100);

/**
 *
 * @param int $quantity
 * @param int $sum
 * @param int $min
 *
 * @return \Generator
 */
function mixtures($quantity, $sum, $min) {
    $initialValue = $quantity === 1 ? $sum : $min;

    for ($i = $initialValue; $i <= $sum; $i++) {
        $remaining = $sum - $i;
        if ($quantity > 1) {
            foreach (mixtures($quantity - 1, $remaining, $min) as $yield) {
                array_unshift($yield, $i);
                yield $yield;
            }
        }
        elseif ($i >= $min) {
            yield [$i];
        }
    }
}

$ingredients = [];
$properties = [];

foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line)
{
    preg_match("/(\S+): (\w+) ([-\d]+), (\w+) ([-\d]+), (\w+) ([-\d]+), (\w+) ([-\d]+), (\w+) ([-\d]+)/", $line, $matches);

    $ingredients[$matches[1]] = [
        $matches[2] => (int) $matches[3],
        $matches[4] => (int) $matches[5],
        $matches[6] => (int) $matches[7],
        $matches[8] => (int) $matches[9],
        $matches[10] => (int) $matches[11],
    ];

    $properties[$matches[2]][$matches[1]] = (int) $matches[3];
    $properties[$matches[4]][$matches[1]] = (int) $matches[5];
    $properties[$matches[6]][$matches[1]] = (int) $matches[7];
    $properties[$matches[8]][$matches[1]] = (int) $matches[9];
    $properties[$matches[10]][$matches[1]] = (int) $matches[11];
}

$mixtures = mixtures(count($ingredients), TEASPOONS, 1);
