<?php

include 'header.php';

for ($sequence = SEQUENCE, $i = 0, $loops = 40; $i < $loops; $i++) {
    $sequence = lookAndSay($sequence);
}

echo strlen($sequence), PHP_EOL;


