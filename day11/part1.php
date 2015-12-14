<?php

include 'header.php';

$password = 'hxbxwxba';
do {
    $password = $generator->nextPassword($password);
}
while (!$generator->valid($password));

echo "New password: $password\n";