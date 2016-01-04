<?php

class Player
{
    protected $maxHitPoints;
    protected $hitPoints;
    protected $baseDamage;
    protected $baseArmor;

    /**
     * @var Item
     */
    protected $equippedWeapon;

    /**
     * @var Item
     */
    protected $equippedArmor;

    /**
     * @var Item
     */
    protected $equippedLeftRing;

    /**
     * @var Item
     */
    protected $equippedRightRing;

    public function __construct($hitPoints, $damage, $armor)
    {
        $this->hitPoints = $this->maxHitPoints = (int) $hitPoints;
        $this->baseDamage = (int) $damage;
        $this->baseArmor = (int) $armor;
    }

    public function unequipAll()
    {
        $this->equippedArmor = null;
        $this->equippedWeapon = null;
        $this->equippedLeftRing = null;
        $this->equippedRightRing = null;
    }

    public function revive()
    {
        $this->hitPoints = $this->maxHitPoints;
    }

    public function health()
    {
        return $this->hitPoints;
    }

    public function dead()
    {
        return $this->hitPoints === 0;
    }

    public function attack(Player $target)
    {
        return $target->defend($this->damage());
    }

    public function defend($damage)
    {
        $damage = max([(int) $damage - $this->armor(), 1]);
        $this->hitPoints = max([$this->hitPoints - $damage, 0]);
        return $damage;
    }

    public function equipped()
    {
        $equipped = [];
        if ($this->equippedArmor) {
            $equipped[] = $this->equippedArmor;
        }
        if ($this->equippedWeapon) {
            $equipped[] = $this->equippedWeapon;
        }
        if ($this->equippedLeftRing) {
            $equipped[] = $this->equippedLeftRing;
        }
        if ($this->equippedRightRing) {
            $equipped[] = $this->equippedRightRing;
        }
        return $equipped;
    }

    public function armor()
    {
        $armor = $this->baseArmor;
        foreach ($this->equipped() as $item) {
            $armor += $item->armor();
        }
        return $armor;
    }

    public function damage()
    {
        $damage = $this->baseDamage;
        foreach ($this->equipped() as $item) {
            $damage += $item->damage();
        }
        return $damage;
    }

    public function equip(Item $item)
    {
        if ($item instanceof Weapon) {
            $this->equippedWeapon = $item;
        }
        elseif ($item instanceof Armor) {
            $this->equippedArmor = $item;
        }
        elseif ($item instanceof Ring) {
            if (null === $this->equippedLeftRing) {
                $this->equippedLeftRing = $item;
            }
            elseif (null === $this->equippedRightRing) {
                $this->equippedRightRing = $item;
            }
        }
    }
}

abstract class Item
{
    protected $value;
    protected $armor;
    protected $damage;

    public function __construct($value, $damage, $armor)
    {
        $this->value = (int) $value;
        $this->damage = (int) $damage;
        $this->armor = (int) $armor;
    }

    public function price()
    {
        return $this->value;
    }

    public function damage()
    {
        return $this->damage;
    }

    public function armor()
    {
        return $this->armor;
    }
}

class Weapon extends Item {}
class Armor extends Item {}
class Ring extends Item {}

function duel(Player $player1, Player $player2, $debug=false) {
    if ($debug) {
        echo "Player1\n";
        print_r($player1);
        echo "Player2\n";
        print_r($player2);
    }
    while (true) {
        if ($player1->dead()) {
            if ($debug) {
                echo "Player 1 is dead. Player 2 wins!\n";
            }
            return $player2;
        }
        $player1->attack($player2);
        if ($debug) {
            printf(
                "Player 1 hits Player 2 for %d points of damage, leaving Player 2 with %d hit points\n",
                $player1->attack($player2),
                $player2->health()
            );
        }

        if ($player2->dead()) {
            if ($debug) {
                echo "Player 2 is dead. Player 1 wins!\n";
            }
            return $player1;
        }
        $player2->attack($player1);
        if ($debug) {
            printf(
                "Player 2 hits Player 1 for %d points of damage, leaving Player 1 with %d hit points\n",
                $player2->attack($player1),
                $player1->health()
            );
        }
    }
}