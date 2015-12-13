<?php

include 'header.php';

$position = 0;

while ($instruction = fgetc($input)) {
    $position += 1;
    if ($instruction === UP) {
        $floor += 1;
    }
    elseif ($instruction === DOWN) {
        $floor -= 1;

        if ($floor === -1) {
            break;
        }
    }
}

fclose($input);

echo "First entered basement at position $position\n";
