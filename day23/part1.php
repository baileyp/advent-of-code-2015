<?php

include 'header.php';

$computer = new Computer(
    explode("\n", file_get_contents(__DIR__ . '/input'))
);

$computer->run();

echo $computer->register('b');