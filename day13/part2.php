<?php

define('ME', 'Peter');

include 'header.php';

$me = [];
foreach ($happinessMap as $person => $relationships) {
    $happinessMap[$person][ME] = 0;
    $me[$person] = 0;
}
$happinessMap[ME] = $me;

$seatingOrganizer = new HappinessSeatingOrganizer($happinessMap);
echo $seatingOrganizer->findMaxHappinessScore();

