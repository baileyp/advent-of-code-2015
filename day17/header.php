<?php

define('VOLUME', 150);

$containers = array_map(function($volume)
{
    return (int) $volume;
}, file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES));

rsort($containers);
