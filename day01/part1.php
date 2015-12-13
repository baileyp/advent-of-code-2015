<?php

include 'header.php';

while ($instruction = fgetc($input)) {
    if ($instruction === UP) {
        $floor += 1;
    }
    elseif ($instruction === DOWN) {
        $floor -= 1;
    }
}

fclose($input);

echo "Delivery Floor: $floor\n";