<?php

$input = fopen(__DIR__ . '/input', 'r');

$charCount = 0;
$charCountEncoded = 0;
while ($line = trim(fgets($input), " \n")) {
    $charCount += strlen($line);
    $charCountEncoded += strlen(addslashes($line)) + 2;
}

fclose($input);

echo $charCountEncoded - $charCount, PHP_EOL;
