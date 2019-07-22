<?php


namespace App;


//use foo\bar;

/**
 * Class SudokuChecker
 * @package App
 */
class SudokuChecker
{
    /**
     * @var array
     */
    private $grid;

    /**
     * @var array
     */
    private $range;

    /**
     * @var array
     */
    private $parts = [];

    /**
     * @var bool
     */
    private $validity = true;

    /**
     * SudokuChecker constructor.
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->range = range(1, count($grid));
        $this->getLines();
        $this->getCols();
        $this->getSquares();
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return $this->checkParts();
    }

    private function getLines(): void
    {
        $this->parts = $this->grid;
    }

    private function getCols(): void
    {
        for ($i = 0; $i < count($this->grid); $i++) {
            $col = [];
            for ($j = 0; $j < count($this->grid); $j++) {
                $col[] = $this->grid[$j][$i];
            }
            $this->parts[] = $col;
        }
    }

    private function getSquares(): void
    {
        $squareSize = sqrt(count($this->grid));
        for ($i = 0; $i < count($this->grid); $i += $squareSize) {
            for ($j = 0; $j < count($this->grid); $j += $squareSize) {
                $square = [];
                for ($k = $i; $k < $i + $squareSize; $k++) {
                    for ($l = $j; $l < $j + $squareSize; $l++) {
                        $square[] = $this->grid[$k][$l];
                    }
                }
                $this->parts[] = $square;
            }
        }
    }

    /**
     * @return bool
     */
    private function checkParts(): bool
    {
        foreach ($this->parts as $part) {
            sort($part);
            if ($part !== $this->range) {
                $this->validity = false;
                break;
            }
        }

        return $this->validity;
    }
}