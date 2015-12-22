<?php

$analysis = <<<EOL
children: 3
cats: 7
samoyeds: 2
pomeranians: 3
akitas: 0
vizslas: 0
goldfish: 5
trees: 3
cars: 2
perfumes: 1
EOL;

$attributes = [];
foreach (explode("\n", $analysis) as $line) {
    list($attribute, $quantity) = explode(': ', $line);
    $attributes[$attribute] = (int) $quantity;
}

$sues = [];
$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);
foreach ($input as $line) {
    preg_match("/Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)/", $line, $matches);
    $sue = array_combine(array_keys($attributes), array_fill(0, count($attributes), null));
    $sue[$matches[2]] = (int) $matches[3];
    $sue[$matches[4]] = (int) $matches[5];
    $sue[$matches[6]] = (int) $matches[7];

    $sues[(int) $matches[1]] = $sue;
}