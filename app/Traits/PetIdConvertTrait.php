<?php

namespace App\Traits;

/**
 * Trait PetIdConvertTrait
 */
trait PetIdConvertTrait
{

    /**
     * Convert petID to UserID Method
     *
     * @param $petID
     * @return string
     */
    function decode($petID) {
        $petID = (string)$petID;
        $ALPHABET = explode(',', "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
        $MULTIPLIER = count($ALPHABET);

        if (strlen($petID) > 1) {
            $a = $petID[0];
            $b = $petID[1];
            $userID = substr($petID, 2, strlen($petID) - 2);
            $part_B = array_search(strtoupper($b), $ALPHABET);
            $part_A = array_search(strtoupper($a), $ALPHABET);
            $userID = ($userID * $MULTIPLIER * $MULTIPLIER) + ($part_B * $MULTIPLIER) + $part_A;
        } else {
            $userID = array_search($petID, $ALPHABET);
        }

        return $userID;
    }

    function encode($petID) {
        $copiedID = (int)$petID;
        $ALPHABET = explode(',', "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
        $MULTIPLIER = count($ALPHABET);

        $aIndex = $copiedID % $MULTIPLIER;
        $part_A = strtolower($ALPHABET[$aIndex]);
        $copiedID /= $MULTIPLIER;
        $bIndex = $copiedID % $MULTIPLIER;
        $part_B = strtolower($ALPHABET[$bIndex]);
        $copiedID /= $MULTIPLIER;

        return $part_A . $part_B . (int)$copiedID;
    }

}
