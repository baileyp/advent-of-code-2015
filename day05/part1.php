<?php

function isNice($string)
{
    return  preg_match("/[aeiou].*[aeiou].*[aeiou]/", $string)
        &&  preg_match("/(.)\\1/", $string)
        &&  !preg_match("/(ab|cd|pq|xy)/", $string);
}

include 'runner.php';