<?php

class MoleculeGenerator
{
    protected $replacements;

    public function calibrate(array $replacements)
    {
        foreach ($replacements as $replacement) {
            if (preg_match("/(\S+) => (\S+)/", $replacement, $matches)) {
                $this->replacements[$matches[2]] = $matches[1];
            }
        }
    }

    public function generateDistinctMolecules($molecule)
    {
        $molecules = [];
        foreach ($this->replacements as $replacement => $atom) {
            for ($i = 0, $l = strlen($molecule); $i < $l; $i++) {
                $atomSize = strlen($atom);
                if (substr($molecule, $i, $atomSize) === $atom) {
                    $molecules[] = substr_replace($molecule, $replacement, $i, $atomSize);
                }
            }
        }
        return array_unique($molecules);
    }
}
