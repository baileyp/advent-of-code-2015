<?php

function isNice($string)
{
    return  preg_match("/(..).*\\1/", $string)
        &&  preg_match("/(.).\\1/", $string);
}

include 'runner.php';