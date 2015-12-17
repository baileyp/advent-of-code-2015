<?php

include 'header.php';

$race = new Race($reindeer, 2503);
$race->readySetGo();

echo max($race->results());
