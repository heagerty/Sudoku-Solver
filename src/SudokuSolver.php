<?php

namespace App;

class SudokuSolver

{

    function array_flatten($array = null) {
        $result = array();

        if (!is_array($array)) {
            $array = func_get_args();
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, SudokuSolver::array_flatten($value));  //not static for codewars
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }

        return $result;
    }

    public function sudokuSolver(array $coordinates)
    {

        $size = 9;
        $numbersUsed = range(1, 9);

        $rows = $coordinates;

        for ($i = 0; $i < $size; $i++) {
            $col = [];
            for ($j = 0; $j < $size; $j++) {
                $col[] = $coordinates[$j][$i];
            }
            $columns[] = $col;
        }

        $squareSize = sqrt($size);
        for ($i = 0; $i < $size; $i += $squareSize) {
            for ($j = 0; $j < $size; $j += $squareSize) {
                $square = [];
                for ($k = $i; $k < $i + $squareSize; $k++) {
                    for ($l = $j; $l < $j + $squareSize; $l++) {
                        $square[] = $coordinates[$k][$l];
                    }
                }
                $boxes[] = $square;
            }
        }

        // Now we have lines, columns and boxes


        while (in_array(0, SudokuSolver::array_flatten($rows))) {
            for ($i = 0; $i < 9; $i++) {
                for ($j = 0; $j < 9; $j++) {
                    if ($coordinates[$i][$j] == 0) {
                        $otherNumbers[] = $rows[$i];
                        $otherNumbers[] = $columns[$j]; //todo check that it works
                        if ($j < 3) {
                            if ($i < 3) {
                                $boxnumber = 0;
                            }
                        } elseif ($j > 5) {
                            if ($i < 3) {
                                $boxnumber = 2;
                            }
                        } elseif  ($i < 3) {
                            $boxnumber = 1;
                        } elseif ($i > 5) {
                            if ($j < 3) {
                                $boxnumber = 6;
                            }
                        } elseif  ($i > 5) {
                            if ($j > 5) {
                                $boxnumber = 8;
                            }
                        } elseif  ($i > 5) {
                                $boxnumber = 7;
                        } elseif ($j < 3) {
                                $boxnumber = 3;
                        } elseif  ($j > 5) {
                                $boxnumber = 5;
                        } else {
                            $boxnumber = 4;
                        }


                        echo "\n"."\n"."\n".'Big box number: '. $boxnumber."\n";

                        $otherNumbers[] = $boxes[$boxnumber];



                        $flat = SudokuSolver::array_flatten($otherNumbers);

                        $flatUnique = array_unique($flat);



                        if (($key = array_search(0, $flatUnique)) !== false) {
                            unset($flatUnique[$key]);
                        }

                        echo ' Box: '.$i.' down and '.$j.' across';
                        var_dump(implode("|",$flatUnique));

                        $diff = array_diff($numbersUsed, $flatUnique);

                        var_dump($diff);

                        $arr = array_values($diff);


                        if (count($arr) == 1 ) {


                            $newValue = $arr[0];

                            echo ' new value: '.$newValue;
                            echo "\n";

                            echo $coordinates[$i][$j].'  was replaced by  '.$newValue."\n";
                            $coordinates[$i][$j] = $newValue;

                            echo " New line: "."\n". implode("|",$coordinates[$i])."\n";
                            echo " In my box: ";


                        }









                    }

                }
                var_dump(implode("|",$coordinates));
                return [];


            }


        }




        var_dump($coordinates);
        return $coordinates;

    }



}
