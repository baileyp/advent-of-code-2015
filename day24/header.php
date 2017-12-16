<?php

function findPermutations(array $values, int $targetSum, array $permutation = [], array $permutations = [])
{
    while (array_sum($permutation) + array_sum($values) >= $targetSum) {
        // Input is sorted, so always grab the largest values first
        $value = array_pop($values);
        $permutation[] = $value;
        $permutationSum = array_sum($permutation);

        if ($permutationSum === $targetSum) {
            // All of this logic here ensures that we only push new permutations into the collection
            // if they are valid, which means they have the same or fewer elements than the permutations
            // which are already stored
            if (count($permutations)) {
                $targetPermutationSize = count($permutations[0]);
                $thisPermutationsSize = count($permutation);
                if ($thisPermutationsSize < $targetPermutationSize) {
                    // This new permutation is smaller than all previous - replace permutations with a new
                    // array containing just this permutations
                    $permutations = [$permutation];
                }
                elseif ($thisPermutationsSize === $targetPermutationSize) {
                    // This new permutation is the same as the smallest
                    $permutations[] = $permutation;
                }
            } else {
                $permutations[] = $permutation;
            }
        }
        elseif ($permutationSum < $targetSum) {
            $permutations = findPermutations($values, $targetSum, $permutation, $permutations);
        }
        array_pop($permutation);
    }
    return $permutations;
}