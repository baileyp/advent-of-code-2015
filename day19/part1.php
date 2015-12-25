<?php

include 'header.php';

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

$targetMolecule = array_pop($input);

$generator = new MoleculeGenerator();
$generator->calibrate($input);

echo count($generator->generateDistinctMolecules($targetMolecule));