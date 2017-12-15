<?php

include 'header.php';

$computer = new Computer(
    explode("\n", file_get_contents(__DIR__ . '/input')),
    1
);

$computer->run();

echo $computer->register('b');