<?php

define('NORTH', '^');
define('SOUTH', 'v');
define('EAST', '>');
define('WEST', '<');

$input = fopen(__DIR__ . '/input', 'r');

class Santa
{
    protected $x = 0;
    protected $y = 0;
    protected $neighborhood;

    public function __construct(Neighborhood $neighborhood)
    {
        $this->neighborhood = $neighborhood;
    }

    public function position()
    {
        return $this->x . ',' . $this->y;
    }

    /**
     * @return static
     */
    public function move($direction)
    {
        switch ($direction) {
            case NORTH:
                $this->y += 1;
                break;

            case SOUTH:
                $this->y -= 1;
                break;

            case EAST:
                $this->x += 1;
                break;

            case WEST:
                $this->x -= 1;
                break;
        }
        return $this;
    }

    /**
     * @return static
     */
    public function deliverPresent()
    {
        $this->neighborhood->receivePresent($this->position());
        return $this;
    }
}

class Neighborhood implements Countable
{
    protected $houses = [];

    public function receivePresent($coordinate)
    {
        if (!array_key_exists($coordinate, $this->houses)) {
            $this->houses[$coordinate] = 0;
        }

        $this->houses[$coordinate] += 1;
    }

    public function count()
    {
        return count($this->houses);
    }
}
