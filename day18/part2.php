<?php

include 'header.php';

class StuckCornersGrid extends Grid
{
    protected $corners = [];

    public function __construct(array $rawData)
    {
        $height = count($rawData) - 1;
        $width = strlen($rawData[0]) - 1;

        $this->corners = ["0,0", "0,$height", "$width,0", "$width,$height"];

        parent::__construct($rawData);
    }

    public function offsetSet($offset, $value)
    {
        if (in_array($offset, $this->corners)) {
            $value = ON;
        }
        parent::offsetSet($offset, $value);
    }
}

$grid = new StuckCornersGrid(file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES));

for ($i = 0; $i < 100; $i++) {
    $grid = $grid->update();
}

echo $grid->count(), PHP_EOL;
