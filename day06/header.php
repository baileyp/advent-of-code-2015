<?php

namespace Day6 {

    use \Countable;
    use \DomainException;
    use \OutOfBoundsException;

    class InstructionFactory
    {
        const TOGGLE = 'toggle';
        const ON = 'turn on';
        const OFF = 'turn off';

        protected $pattern;
        protected $actions;

        public function __construct($pattern)
        {
            $this->pattern = $pattern;
            $this->actions = [
                self::OFF => function($bit) {
                    return 0;
                },
                self::ON => function($bit) {
                    return 1;
                },
                self::TOGGLE => function($bit) {
                    return $bit ? 0 : 1;
                },
            ];
        }

        public function create($rawInstruction)
        {
            if (!preg_match($this->pattern, $rawInstruction, $parsed)) {
                throw new DomainException("Invalid instruction: $rawInstruction");
            }
            return new Instruction(
                $this->actions[$parsed[1]],
                new Coordinate($parsed[2], $parsed[3]),
                new Coordinate($parsed[4], $parsed[5])
            );
        }
    }

    class Instruction
    {
        protected $action;
        protected $from;
        protected $to;

        public function __construct(callable $action, Coordinate $from, Coordinate $to)
        {
            $this->action = $action;
            $this->from = $from;
            $this->to = $to;
        }

        public function execute($input)
        {
            return call_user_func($this->action, $input);
        }

        /**
         * @return Coordinate
         */
        public function from()
        {
            return $this->from;
        }

        /**
         * @return Coordinate
         */
        public function to()
        {
            return $this->to;
        }
    }

    class Coordinate
    {
        protected $x;
        protected $y;

        public function __construct($x, $y)
        {
            $this->x = (int) $x;
            $this->y = (int) $y;
        }

        public function x()
        {
            return $this->x;
        }

        public function y()
        {
            return $this->y;
        }
    }

    class Grid implements Countable
    {
        protected $grid;

        public function __construct($width, $height)
        {
            $this->grid = array_fill(0, (int) $height, array_fill(0, (int) $width, 0));
        }

        public function followInstruction(Instruction $instruction)
        {
            $fromRow = $instruction->from()->y();
            $toRow = $instruction->to()->y();
            $fromCol = $instruction->from()->x();
            $toCol = $instruction->to()->x();

            // Brute force!
            for ($row = $fromRow; $row <= $toRow; $row++) {
                for ($col = $fromCol; $col <= $toCol; $col++) {
                    if (!array_key_exists($row, $this->grid) || !array_key_exists($col, $this->grid[$row]) ) {
                        throw new OutOfBoundsException("Instruction addresses a point outside the grid!");
                    }
                    $this->grid[$row][$col] = $instruction->execute($this->grid[$row][$col]);
                }
            }
        }

        public function count()
        {
            return array_reduce($this->grid, function($carry, $row)
            {
                return $carry + array_sum($row);
            }, 0);
        }
    }
}

namespace {

    $input = fopen(__DIR__ . '/input', 'r');

    $pattern = sprintf(
        "/(%s|%s|%s) ([0-9]+),([0-9]+) through ([0-9]+),([0-9]+)/",
        preg_quote(Day6\InstructionFactory::OFF),
        preg_quote(Day6\InstructionFactory::ON),
        preg_quote(Day6\InstructionFactory::TOGGLE)
    );

    $grid = new Day6\Grid(1000, 1000);
}