<?php

class PasswordGenerator
{
    protected $collation = [];
    protected $requirements = [];

    public function __construct(array $collation, array $requirements)
    {
        $this->collation = $collation;
        $this->requirements = $requirements;
    }

    public function valid($password)
    {
        $valid = true;
        foreach ($this->requirements as $pattern) {
            $valid = $valid && preg_match($pattern, $password);
        }
        return $valid;
    }

    public function nextPassword($currentPassword)
    {
        $letters = str_split($currentPassword);
        $lastLetter = array_pop($letters);
        $nextLetterIndex = array_search($lastLetter, $this->collation) + 1;

        if (!array_key_exists($nextLetterIndex, $this->collation)) {
            $letters = str_split($this->nextPassword(implode('', $letters), $this->collation));
            $nextLetterIndex = 0;
        }
        $letters[] = $this->collation[$nextLetterIndex];
        return implode('', $letters);
    }
}

$alphabet = array_values(array_diff(range('a', 'z'), ['i', 'o', 'l']));

$threeLetterGroups = [];
for ($i = 0; $i < count($alphabet) - 2; $i++) {
    $threeLetterGroups[] = $alphabet[$i] . $alphabet[$i+1] . $alphabet[$i+2];
}

$generator = new PasswordGenerator($alphabet, [
    "/(" . implode('|', $threeLetterGroups) . ")/",
    "/(.)\\1.*(.)\\2/"
]);

unset($alphabet, $threeLetterGroups);
