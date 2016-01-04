<?php

include 'header.php';
include 'inventory.php';

$losingBudgets = [];

$player = new Player(100, 0, 0);
$boss = new Player(100, 8, 2);

// Just weapon
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    $bill = $weapon->price();

    $player->revive();
    $boss->revive();

    $player->unequipAll();
    $player->equip($weapon);

    if (duel($player, $boss) === $boss) {
        $losingBudgets[] = $bill;
    }
}

// Weapon and armor
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    /* @var $armorPiece Item */
    foreach ($armor as $armorPiece) {
        $bill = $weapon->price() + $armorPiece->price();

        $player->revive();
        $boss->revive();

        $player->unequipAll();
        $player->equip($weapon);
        $player->equip($armorPiece);

        if (duel($player, $boss) === $boss) {
            $losingBudgets[] = $bill;
        }
    }
}

// Weapon and one ring
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    /* @var $ring Item */
    foreach ($rings as $ring) {
        $bill = $weapon->price() + $ring->price();

        $player->revive();
        $boss->revive();

        $player->unequipAll();
        $player->equip($weapon);
        $player->equip($ring);

        if (duel($player, $boss) === $boss) {
            $losingBudgets[] = $bill;
        }
    }
}

// Weapon and two rings
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    /* @var $ring1 Item */
    foreach ($rings as $ring1) {
        /* @var $ring2 Item */
        foreach ($rings as $ring2) {
            $bill = $weapon->price() + $ring1->price();

            $player->revive();
            $boss->revive();

            $player->unequipAll();
            $player->equip($weapon);
            $player->equip($ring1);
            if ($ring1 != $ring2) {
                $player->equip($ring2);
                $bill +=  $ring2->price();
            }

            if (duel($player, $boss) === $boss) {
                $losingBudgets[] = $bill;
            }
        }
    }
}

// Weapon, armor, and one ring
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    /* @var $armorPiece Item */
    foreach ($armor as $armorPiece) {
        /* @var $ring Item */
        foreach ($rings as $ring) {
            $bill = $weapon->price() + $armorPiece->price() + $ring->price();

            $player->revive();
            $boss->revive();

            $player->unequipAll();
            $player->equip($weapon);
            $player->equip($armorPiece);
            $player->equip($ring);

            if (duel($player, $boss) === $boss) {
                $losingBudgets[] = $bill;
            }
        }
    }
}

// Weapon, armor, and two rings
/* @var $weapon Item */
foreach ($weapons as $weapon) {
    /* @var $armorPiece Item */
    foreach ($armor as $armorPiece) {
        /* @var $ring1 Item */
        foreach ($rings as $ring1) {
            /* @var $ring2 Item */
            foreach ($rings as $ring2) {
                $bill = $weapon->price() + $armorPiece->price() + $ring1->price();

                $player->revive();
                $boss->revive();

                $player->unequipAll();
                $player->equip($weapon);
                $player->equip($armorPiece);
                $player->equip($ring1);
                if ($ring1 != $ring2) {
                    $player->equip($ring2);
                    $bill +=  $ring2->price();
                }

                if (duel($player, $boss) === $boss) {
                    $losingBudgets[] = $bill;
                }
            }
        }
    }
}

echo max($losingBudgets);
