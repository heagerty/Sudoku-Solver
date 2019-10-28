<?php

namespace App;

class SudokuChecker

{

    public function sudokuChecker(array $coordinates)
    {

        $size = 9;
        $numbersUsed = range(1, 9);


        for ($i=0; $i<$size; $i++) {   //pass over rows
            $row = [];
            for ($j = 0; $j < $size; $j++) {   //check each row
                if (in_array($coordinates[$i][$j], $numbersUsed)) {
                    $row[] = $coordinates[$i][$j];
                } else {
                    echo '$i=' . $i . '  $j=' . $j;
                    return false;
                }
            }
            $uniqueRow = array_unique($row);
            if (sizeof($uniqueRow) !== $size) {
                return false;
            }


            $column = [];
            for ($j = 0; $j < $size; $j++) {   //check each column
                $column[] = $coordinates[$j][$i];
            }

            $uniqueColumn = array_unique($column);
            if (sizeof($uniqueColumn) !== $size) {
                return false;
            }

        }


        //check boxes
        if (sqrt($size) == floor(sqrt($size))) {   //make sure it's divisible in

            //echo "SQUARE TEST";

            $boxSize = sqrt($size);

            echo $boxSize;



            for ($i = 0; $i < $boxSize; $i++) {              //each row
                for ($j = 0; $j < $boxSize; $j++) {            //each column


                    $box = [];

                    for ($k = 0 + $boxSize*$i; $k < $boxSize + $boxSize*$i; $k++) {              //each box
                        for ($l = 0 + $boxSize*$j; $l < $boxSize + $boxSize*$j; $l++) {

                            $box[] = $coordinates[$k][$l];

                        }
                    }
                    $uniqueBox = array_unique($box);
                    if (count($uniqueBox) !== $size) {
                        return false;
                    }

                }
            }
        }


    return true;

    }



}
