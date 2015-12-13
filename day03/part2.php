<?php

include 'header.php';

$neighborhood = new Neighborhood();
$santa = new Santa($neighborhood);
$roboSanta = new Santa($neighborhood);

$santa->deliverPresent();

$i = 0;
while ($direction = fgetc($input)) {
    if ($i % 2 === 0) {
        $santa->move($direction)->deliverPresent();
    } else {
        $roboSanta->move($direction)->deliverPresent();
    }
    $i++;
}

fclose($input);

echo "Houses with at least one present: ", count($neighborhood), PHP_EOL;
