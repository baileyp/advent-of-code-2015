<?php

namespace Day7
{
    class SignalBlueprint
    {
        protected $connection;
        protected $inputs = [];
        protected $wire;

        public function __construct($rawInstruction)
        {
            if (preg_match('/^(.+?) -> (.+)$/', $rawInstruction, $parts)) {
                list(, $formula, $wire) = $parts;

                $this->wire = $wire;

                $tokens = explode(' ', $formula);
                switch (count($tokens)) {
                    case 3:
                        $this->connection = $this->getOperation($tokens[1]);
                        $this->inputs = [$tokens[0], $tokens[2]];
                        break;

                    case 2:
                        $this->connection = $this->getOperation($tokens[0]);
                        $this->inputs = [$tokens[1]];
                        break;

                    case 1:
                        $this->connection = function($signal) {
                            return $signal;
                        };
                        $this->inputs = [$tokens[0]];
                        break;
                }
            }
        }

        public function wire()
        {
            return $this->wire;
        }

        public function connect()
        {
            return $this->connection;
        }

        public function inputs()
        {
            return $this->inputs;
        }

        protected function getOperation($operator)
        {
            return [
                'AND' => function($a, $b) {
                    return $a & $b;
                },
                'OR' => function($a, $b) {
                    return $a | $b;
                },
                'NOT' => function($x) {
                    $mask = 0x8000;

                    if ($x < 0) {
                        $x &= 0x7FFF;
                        $x = ~$x;

                        return $x ^ $mask;
                    } else {
                        $x = $x ^ 0x7FFF;

                        return $x | $mask;
                    }
                },
                'LSHIFT' => function($a, $b) {
                    return $a << $b;
                },
                'RSHIFT' => function($a, $b) {
                    return $a >> $b;
                }
            ][$operator];
        }
    }

    class Circuit
    {
        protected $wires = [];
        protected $signals = [];

        public function run()
        {
            foreach ($this->signals as $signal) {
                $signal();
            }
        }

        public function reset()
        {
            $this->wires = [];
        }

        public function readWire($id)
        {
            return $this->wires[$id];
        }

        public function addSignal(SignalBlueprint $blueprint)
        {
            $this->signals[$blueprint->wire()] = function() use ($blueprint)
            {
                if (!array_key_exists($blueprint->wire(), $this->wires))
                {
                    $this->wires[$blueprint->wire()] = call_user_func_array($blueprint->connect(), array_map(function($input)
                    {
                        return $this->read($input);
                    }, $blueprint->inputs()));
                }
                return $this->wires[$blueprint->wire()];
            };
        }

        protected function read($signal)
        {
            if (is_numeric($signal)) {
                return (int) $signal;
            }
            return $this->signals[$signal]();
        }
    }
}
