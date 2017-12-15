<?php

class Computer
{
    private $instructions = [];
    private $registers = ['a' => 0, 'b' => 0];
    private $cursor = 0;

    public function __construct(array $instructions, int $aStart = 0)
    {
        $this->registers['a'] = $aStart;

        // Convert raw instructions into simple callables
        $this->instructions = array_map(function (string $instruction) {
            if (preg_match("/^([a-z]+) ([ab])$/", $instruction, $matches)) {
                //        print_r($matches);
                return function() use ($matches) {
                    call_user_func([$this, $matches[1]], $matches[2]);
                };
            }

            if (preg_match("/^jmp ([-+][\d]+)/", $instruction, $matches)) {
                return function() use ($matches) {
                    $this->jmp((int) $matches[1]);
                };
            }

            if (preg_match("/^(ji[eo]) ([ab]), ([-+][\d]+)/", $instruction, $matches)) {
                return function() use ($matches) {
                    call_user_func([$this, $matches[1]], $matches[2], (int)$matches[3]);
                };
            }
        }, $instructions);
    }

    public function register(string $register): int
    {
        return $this->registers[$register];
    }

    public function run()
    {
        while (array_key_exists($this->cursor, $this->instructions)) {
            call_user_func($this->instructions[$this->cursor]);
        }
    }

    public function hlf(string $register)
    {
        $this->registers[$register] /= 2;
        $this->cursor++;
    }

    public function tpl(string $register)
    {
        $this->registers[$register] *= 3;
        $this->cursor++;
    }

    public function inc(string $register)
    {
        $this->registers[$register]++;
        $this->cursor++;
    }

    public function jmp(int $amount)
    {
        $this->cursor += $amount;
    }

    public function jie(string $register, int $amount)
    {
        if (!($this->registers[$register] & 1)) {
            $this->cursor += $amount;
        } else {
            $this->cursor++;
        }
    }

    public function jio(string $register, int $amount)
    {
        if ($this->registers[$register] === 1) {
            $this->cursor += $amount;
        } else {
            $this->cursor++;
        }
    }
}
