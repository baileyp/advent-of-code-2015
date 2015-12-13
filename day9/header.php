<?php

function distanceBetween($from, $to, $list) {
    foreach ($list as $city => $neighbors) {
        if ($city === $to && array_key_exists($from, $neighbors)) {
            return $list[$to][$from];
        }
    }
    return $list[$from][$to];
}

function permutate($items, $permutations=[]) {
		static $allPermutations;
		if (empty($items)) {
        $allPermutations[] = $permutations;
		} else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
            $newitems = $items;
            $newPermutations = $permutations;
            list($nextItem) = array_splice($newitems, $i, 1);
            array_unshift($newPermutations, $nextItem);
            permutate($newitems, $newPermutations);
        }
		}
		return $allPermutations;
}

$distances = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

$cityList = [];
$adjencyList = [];
foreach ($distances as $distance) {
    if (preg_match("/(\S+) to (\S+) = (\d+)/", $distance, $matches)) {
        list (, $from, $to, $distance) = $matches;

        $adjencyList[$from][$to] = (int) $distance;
        $cityList[] = $from;
        $cityList[] = $to;
    }
}
unset($distances);

$permutations = permutate(array_unique($cityList));
$distances = [];

foreach ($permutations as $permutation) {
    $distance = 0;
    for ($i = 0; $i < count($permutation); $i++) {
        $distance += distanceBetween($permutation[$i], $permutation[$i+1], $adjencyList);
    }
    $distances[] = $distance;
}

unset($permutations);
