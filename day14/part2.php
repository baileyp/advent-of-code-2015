<?php

include 'header.php';

class NewRace extends Race
{
    protected $standings;

    public function readySetGo()
    {
        foreach ($this->participants as $participant) {
            $this->standings[$participant->name()] = 0;
        }

        parent::readySetGo();
    }

    protected function tick()
    {
        parent::tick();
        foreach ($this->leaders() as $leader) {
            $this->standings[$leader] += 1;
        }
    }

    protected function leaders()
    {
        return array_keys($this->leaderboard, max($this->leaderboard));
    }

    public function results()
    {
        return $this->standings;
    }
}

$race = new NewRace($reindeer, 2503);
$race->readySetGo();

echo max($race->results());
