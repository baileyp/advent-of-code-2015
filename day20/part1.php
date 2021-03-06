<?php

define('PRESENTS', 29000000);

ini_set('memory_limit', '256M');

$limit = PRESENTS / 10;
$houses = [];
for ($elf = 1; $elf <= $limit; $elf++) {
    for ($house = $elf; $house <= $limit; $house += $elf) {
        $houses[$house] += $elf * 10;
    }
}

foreach ($houses as $number => $presents) {
    if ($presents >= PRESENTS) {
        echo $number;
        break;
    }
}
