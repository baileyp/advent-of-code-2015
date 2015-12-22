<?php

include 'header.php';

$grid = new Grid(file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES));

for ($i = 0; $i < 100; $i++) {
    $grid = $grid->update();
}

echo $grid->count(), PHP_EOL;
