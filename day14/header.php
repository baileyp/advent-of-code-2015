<?php

class Reindeer
{
    protected $name;
    protected $speed;
    protected $flyDuration;
    protected $restDuration;
    protected $stamina;

    public function __construct($name, $speed, $flyDuration, $restDuration)
    {
        $this->name = $name;
        $this->speed = $speed;
        $this->flyDuration = $flyDuration;
        $this->restDuration = $restDuration;
        $this->stamina = $flyDuration;
    }

    public function name()
    {
        return $this->name;
    }

    public function advance()
    {
        if ($this->isResting()) {
            $this->rest();
            return 0;
        }
        $this->run();
        return $this->speed;
    }

    protected function isResting()
    {
        return $this->stamina < 0;
    }

    protected function run()
    {
        $this->stamina -= 1;
        if (0 === $this->stamina) {
            $this->stamina = -$this->restDuration;
        }
    }

    protected function rest()
    {
        $this->stamina += 1;
        if (0 === $this->stamina) {
            $this->stamina = $this->flyDuration;
        }
    }
}

class Race
{
    protected $participants;
    protected $leaderboard;
    protected $duration;

    public function __construct(array $reindeer, $duration)
    {
        $this->participants = $reindeer;
        $this->duration = (int) $duration;
    }

    public function readySetGo()
    {
        foreach ($this->participants as $participant) {
            $this->leaderboard[$participant->name()] = 0;
        }

        for ($i = 0; $i < $this->duration; $i++) {
            $this->tick();
        }
    }

    public function results()
    {
        return $this->leaderboard;
    }

    protected function tick()
    {
        /* @var $participant Reindeer */
        foreach ($this->participants as $participant) {
            $this->leaderboard[$participant->name()] += $participant->advance();
        }
    }
}

$reindeer = [];
foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line)
{
    preg_match("/(\S+) can fly (\d+).+?(\d+).+?(\d+)/", $line, $matches);

    $reindeer[] = new Reindeer($matches[1], (int) $matches[2], (int) $matches[3], (int) $matches[4]);
}

