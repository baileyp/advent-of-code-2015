<?php

include 'header.php';

$neighborhood = new Neighborhood();
$santa = new Santa($neighborhood);

$santa->deliverPresent();

while ($direction = fgetc($input)) {
    $santa->move($direction)->deliverPresent();
}

fclose($input);

echo "Houses with at least one present: ", count($neighborhood), PHP_EOL;
