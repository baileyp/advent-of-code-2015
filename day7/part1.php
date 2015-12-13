<?php

include 'header.php';

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

$circuit = new Day7\Circuit();

foreach ($input as $line) {
    $circuit->addSignal(new Day7\SignalBlueprint($line));
}

$circuit->run();

echo $circuit->readWire('a');