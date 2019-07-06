<?php


namespace HW15;

use ArrayObject;

class Utils
{
    /**
     * Thanks to https://github.com/mjacobsz/php_array_subarrays/blob/master/main.php
     * @param $array
     * @return array
     */
    public static function subArrays(array $array): array
    {
        $arrayKeys = array_keys($array);
        // Create an container array to store all subsets
        $subArrays = [];

        // Get all subsets in this loop
        $numberOfSubsets = 2 ** count($array);
        for ($i = 0; $i < $numberOfSubsets; $i++) {
            // New subArray
            $subArray = [];
            // Create the bitmap
            // Reverse the bitstring, so it matches array ordering
            $binaryMap = str_split(strrev(decbin($i)));
            $lengthOfBinaryMap = count($binaryMap);
            for ($j = 0; $j < $lengthOfBinaryMap; $j++) {
                // Insert the element when we encounter a '1'
                if ($binaryMap[$j] === '1') {
                    if (is_string($arrayKeys[$j])) {
                        // When the key is a string, we want to copy this key to the subArray
                        $subArray[$arrayKeys[$j]] = $array[$arrayKeys[$j]];
                    } else {
                        // When the key is a integer, just do the regular index numbering
                        $subArray[] = $array[$arrayKeys[$j]];
                    }
                }
            }
            // Add subArray to the list of results
            $subArrays[] = $subArray;
        }
        return $subArrays;
    }

    /**
     * Serialize conditions to redis key
     *
     * @param array $conditions
     * @return string
     */
    public static function buildKeyByConditions(array $conditions): string
    {
        $arrayCopy = (new ArrayObject($conditions))->getArrayCopy();
        asort($arrayCopy);
        return http_build_query($conditions);
    }
}
