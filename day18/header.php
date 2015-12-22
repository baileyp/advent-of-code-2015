<?php

define('ON', '#');
define('OFF', '.');

class Grid implements ArrayAccess, Countable
{
    protected $grid;
    protected $neighborFinder;

    public function __construct(array $rawData)
    {
        foreach ($rawData as $y => $data) {
            for ($x = 0, $cols = strlen($data); $x < $cols; $x++) {
                $this["$x,$y"] = $data{$x};
            }
        }
        $this->neighborFinder = memoize([$this, 'findNeighbors']);
    }

    public function findNeighbors($x, $y)
    {
        $neighbors = [];
        foreach ([-1, 0, 1] as $offsetY) {
            foreach ([-1, 0, 1] as $offsetX) {
                $newX = (int) $x + $offsetX;
                $newY = (int) $y + $offsetY;

                $coord = "$newX,$newY";
                if (isset($this[$coord]) && $coord !== "$x,$y") {
                    $neighbors[] = $coord;
                }
            }
        }
        return $neighbors;
    }

    protected function countOnNeighbors($x, $y)
    {
        $neighbors = call_user_func($this->neighborFinder, $x, $y);
        return count(array_filter($neighbors, function($value)
        {
            return $this[$value] === ON;
        }));
    }

    public function update()
    {
        $updated = clone $this;
        foreach ($this->grid as $coord => $value) {
            list ($x, $y) = explode(',', $coord);
            $onNeighbors = $this->countOnNeighbors($x, $y);

            switch ($value) {
                case ON:
                    if ($onNeighbors < 2 || $onNeighbors > 3) {
                        $updated[$coord] = OFF;
                    }
                    break;
                case OFF;
                    if ($onNeighbors === 3) {
                        $updated[$coord] = ON;
                    }
                    break;
            }
        }
        return $updated;
    }

    public function count()
    {
        return array_sum(array_map(function($value) {
            return $value === ON ? 1 : 0;
        }, $this->grid));
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->grid);
    }

    public function offsetGet($offset)
    {
        return $this->grid[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->grid[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        // no implementation
    }
}

function memoize($func)
{
    return function() use ($func)
    {
        static $cache = [];

        $args = func_get_args();
        $key = md5(serialize($args));

        if ( ! isset($cache[$key])) {
            $cache[$key] = call_user_func_array($func, $args);
        }

        return $cache[$key];
    };
}
