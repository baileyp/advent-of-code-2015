<?php

include 'header.php';

class BetterInstructionFactory extends Day6\InstructionFactory
{
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
        $this->actions = [
            self::OFF => function($brightness) {
                return max($brightness - 1, 0);
            },
            self::ON => function($brightness) {
                return $brightness + 1;
            },
            self::TOGGLE => function($brightness) {
                return $brightness + 2;
            },
        ];
    }
}

$factory = new BetterInstructionFactory($pattern);

while ($line = fgets($input)) {
    $grid->followInstruction($factory->create($line));
}

echo "Total Brightness: ", count($grid), PHP_EOL;




