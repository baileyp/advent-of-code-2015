<?php

class HappinessSeatingOrganizer
{
    protected $map;

    public function __construct(array $happinessMap)
    {
        $this->map = $happinessMap;
    }

    public function findMaxHappinessScore()
    {
        $happinessCalcuations = [];

        foreach ($this->permute(array_keys($this->map)) as $seatingOrder) {
            $happinessCalcuations[] = $this->scoreHappiness($seatingOrder);
        }

        return max($happinessCalcuations);
    }

    protected function scoreHappiness(array $seatingOrder)
    {
        $happiness = 0;
        for ($i = 0, $l = count($seatingOrder); $i < $l - 1; $i++) {
            $happiness += $this->map[$seatingOrder[$i]][$seatingOrder[$i + 1]];
            $happiness += $this->map[$seatingOrder[$i + 1]][$seatingOrder[$i]];
        }
        $happiness += $this->map[$seatingOrder[0]][$seatingOrder[$i]];
        $happiness += $this->map[$seatingOrder[$i]][$seatingOrder[0]];

        return $happiness;
    }

    function permute($set)
    {
        $length = count($set);
        $inner = function($values = []) use ($set, $length, &$inner) {
            for ($i = 0; $i < $length; $i++) {
                if (in_array($i, $values)) {
                    continue;
                }

                if (count($values) === $length - 1) {
                    $toYield = [];
                    foreach (array_merge($values, [$i]) as $index) {
                        $toYield[] = $set[$index];
                    }
                    yield $toYield;
                }

                foreach ($inner(array_merge($values, [$i])) as $permutation) {
                    yield $permutation;
                }
            }
        };
        return $inner();
    }
}

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

$happinessMap = [];
foreach ($input as $line) {
    preg_match("/(\S+) would (lose|gain) (\d+).+ (\S+)\./", $line, $matches);
    list (, $person, $dir, $amount, $neighbor) = $matches;
    $happinessMap[$person][$neighbor] = $dir === 'lose' ? -(int) $amount : (int) $amount;
}

unset($input);
