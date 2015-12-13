<?php

include 'header.php';

$factory = new Day6\InstructionFactory($pattern);

while ($line = fgets($input)) {
    $grid->followInstruction($factory->create($line));
}

echo "Number of lights lit: ", count($grid), PHP_EOL;




