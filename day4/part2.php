<?php

define('KEY', 'ckczppom');

$i = 0;
do {
    $i += 1;
    $hash = md5(KEY . $i);
}
while (strpos($hash, '000000') !== 0);

echo 'Lowest positive number: ', $i, PHP_EOL;
