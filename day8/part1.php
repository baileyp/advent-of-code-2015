<?php

$input = fopen(__DIR__ . '/input', 'r');

$charCount = 0;
$charCountEncoded = 0;
while ($line = trim(fgets($input), " \n")) {
    $charCount += strlen($line);
    $charCountEncoded += eval("return strlen($line);");
}

fclose($input);

echo $charCount - $charCountEncoded, PHP_EOL;
