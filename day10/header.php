<?php

define('SEQUENCE', '1321131112');

function lookAndSay($sequence) {
    $newSequence = '';
    $currentDigit = '';
    $currentDigitCount = 0;

    for ($i = 0, $l = strlen($sequence); $i < $l; $i++) {
        if ($i === 0) {
            $currentDigit = $sequence{$i};
            $currentDigitCount = 1;
            continue;
        }

        $newDigit = $sequence{$i};
        if ($newDigit === $currentDigit) {
            $currentDigitCount += 1;
        } else {
            $newSequence .= $currentDigitCount . $currentDigit;
            $currentDigit = $newDigit;
            $currentDigitCount = 1;
        }
    }

    $newSequence .= $currentDigitCount . $currentDigit;

    return $newSequence;
}

