<?php

$niceStringCount = 0;

$input = fopen(__DIR__ . '/input', 'r');

while ($line = fgets($input)) {
    $niceStringCount += (int) isNice($line);
}

fclose($input);

echo "Number of nice strings: $niceStringCount\n";

