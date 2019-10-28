<?php

namespace App;

class SudokuSolver

{

    public function array_flatten($array = null) {
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

    public function getCluesForBox($rows, $columns, $boxes, $y, $x) {
        $otherNumbers[] = $rows[$y];
        $otherNumbers[] = $columns[$x];
        if ($x < 3) {               //1st column
            if ($y < 3) {
                $boxnumber = 0;
            }
            elseif ($y > 5) {
                $boxnumber = 6;
            }
            else {
                $boxnumber = 3;
            }
        } elseif ($x > 5) {           //3rd column
            if ($y < 3) {
                $boxnumber = 2;
            }
            elseif ($y > 5) {
                $boxnumber = 8;
            }
            else {
                $boxnumber = 5;
            }
        } else {                       //2nd column
            if ($y < 3) {
                $boxnumber = 1;
            } elseif ($y > 5) {
                $boxnumber = 7;
            } else {
                $boxnumber = 4;
            }
        }


        //echo "\n"."\n"."\n".'Big box number: '. $boxnumber."\n";

        $thisBox = $boxes[$boxnumber];

        //echo "\n".'CluesRow : '.implode("|",$rows[$y])."\n";
        //echo "\n".'CluesColumn: '.implode("|",$columns[$x])."\n";
        //echo "\n".'CluesBox: '.implode("|",$boxes[$boxnumber])."\n";



        $newOne = array_merge($thisBox, $rows[$y], $columns[$x]);
        $flatUnique = array_unique($newOne);

        while (($key = array_search(0, $flatUnique)) !== false) {
            unset($flatUnique[$key]);
        }

        return $flatUnique;

    }

    public function setVariables($coordinates) {

        $rows = $coordinates;

        for ($i = 0; $i < 9; $i++) {
            $col = [];
            for ($j = 0; $j < 9; $j++) {
                $col[] = $coordinates[$j][$i];
            }
            $columns[] = $col;
        }

        for ($i = 0; $i < 9; $i += 3) {
            for ($j = 0; $j < 9; $j += 3) {
                $square = [];
                for ($k = $i; $k < $i + 3; $k++) {
                    for ($l = $j; $l < $j + 3; $l++) {
                        $square[] = $coordinates[$k][$l];
                    }
                }
                $boxes[] = $square;
            }
        }
        return [$rows, $columns, $boxes];
    }

    public function sudokuSolver(array $coordinates)
    {


        $numbersUsed = range(1, 9);

        $variables = SudokuSolver::setVariables($coordinates);

        $rows = $variables[0];
        $columns = $variables[1];
        $boxes = $variables[2];


        // Now we have lines, columns and boxes

        $count = 0;

        $flatRows = SudokuSolver::array_flatten($rows);


        while (in_array(0, $flatRows)) {
            //echo "\n".'FLAT ROWS: '.implode("|",$flatRows)."\n";
            for ($i = 0; $i < 9; $i++) {
                for ($j = 0; $j < 9; $j++) {
                    if ($coordinates[$i][$j] == 0) {
                        $count++;

                        $flatUnique = SudokuSolver::getCluesForBox($rows, $columns, $boxes, $i, $j);


                                    if ($j < 3) {               //1st column
                                        if ($i < 3) {
                                            $boxnumber = 0;
                                        }
                                        elseif ($i > 5) {
                                            $boxnumber = 6;
                                        }
                                        else {
                                            $boxnumber = 3;
                                        }
                                    } elseif ($j > 5) {           //3rd column
                                        if ($i < 3) {
                                            $boxnumber = 2;
                                        }
                                        elseif ($i > 5) {
                                            $boxnumber = 8;
                                        }
                                        else {
                                            $boxnumber = 5;
                                        }
                                    } else {                       //2nd column
                                        if ($i < 3) {
                                            $boxnumber = 1;
                                        } elseif ($i > 5) {
                                            $boxnumber = 7;
                                        } else {
                                            $boxnumber = 4;
                                        }
                                    }

                                    //echo "\n"."\n"."\n".'Big box number: '. $boxnumber."\n";

                                    $thisBox = $boxes[$boxnumber];
                                    $otherNumbers[] = $thisBox;

                                        //echo 'Box: '.implode("|",$thisBox)."\n";
                                        //echo 'Row: '.implode("|",$rows[$i])."\n";
                                        //echo 'Column: '.implode("|",$columns[$j])."\n";


                        $diff = array_diff($numbersUsed, $flatUnique);


                        if (count($diff) == 1 ) {

                            //echo ' Box: '.$i.' down and '.$j.' across';
                            //echo "\n".'COUNT: '.$count."\n";

                            $arr = array_values($diff);
                            $newValue = $arr[0];

                            //echo ' new value: '.$newValue;
                            //echo "\n";

                            //echo $coordinates[$i][$j].'  was replaced by  '.$newValue."\n";
                            $coordinates[$i][$j] = $newValue;

                            //echo " New line: "."\n". implode("|",$coordinates[$i])."\n";
                            //echo "\n"."\n";

                            $variables = SudokuSolver::setVariables($coordinates);

                            $rows = $variables[0];
                            $columns = $variables[1];
                            $boxes = $variables[2];

                        }


                        if ($count == 300) {
                            $rows = $coordinates;
                            $flatRows = SudokuSolver::array_flatten($rows);
                            $implode =  implode("|",$flatRows);
                            //echo " BIG AWESOME FLAT ROWS: "."\n". $implode."\n";
                            $zeros = substr_count($implode,"0");
                            //echo " Zeros left: ". $zeros."\n";

                            return [];
                        }

                        $rows = $coordinates;
                        $flatRows = SudokuSolver::array_flatten($rows);
                        $implode =  implode("|",$flatRows);
                        $zeros = substr_count($implode,"0");
                        //echo " Zeros left: ". $zeros."\n";

                        if ($zeros == 0) {
                           return ($coordinates);
                        }

                    }
                }
            }
        }
    }
}
