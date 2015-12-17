<?php

include 'header.php';

$seatingOrganizer = new HappinessSeatingOrganizer($happinessMap);
echo $seatingOrganizer->findMaxHappinessScore();
