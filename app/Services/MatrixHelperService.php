<?php
namespace App\Services;

/**
 * This class handles common operations
 * relating to matrices.
 */
class MatrixHelperService
{
    /** @var array */
    protected $alpha = [
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D',
        5 => 'E',
        6 => 'F',
        7 => 'G',
        8 => 'H',
        9 => 'I',
        10 => 'J',
        11 => 'K',
        12 => 'L',
        13 => 'M',
        14 => 'N',
        15 => 'O',
        16 => 'P',
        17 => 'Q',
        18 => 'R',
        19 => 'S',
        20 => 'T',
        21 => 'U',
        22 => 'V',
        23 => 'W',
        24 => 'X',
        25 => 'Y',
        26 => 'Z',
    ];

    /**
     * Multiply two matrices together
     * and retrieves product.
     *
     * @param array   $a
     * @param array   $b
     * @param bool $showAlpha
     *
     * @return array
     */
    public function getMultiMatrix(
        array $a,
        array $b,
        bool $showAlpha = false): array
    {
        $final = [];
        $total = count($b[0]);

        foreach($a as $key => $currentRow){
            for($i=0; $i < $total; $i++) {
                $currentColumn = $this->arrayShiftKey($b, $i);
                $cellSum = $this->calcSum($currentRow,$currentColumn);

                $final[$key][] = ($showAlpha)
                    ? $this->parseToAlpha($cellSum)
                    : $cellSum;
            }

        }
        return $final;
    }

    /**
     * Returns an array of keys for
     * an array of arrays.
     *
     * @param array $arr   The array of arrays.
     * @param int   $index The index to use for
     *                     each array.
     *
     * @return array
     */
    public function arrayShiftKey(array $arr, int $index): array
    {
        $t = [];
        foreach($arr as $array) {
            $t[] = $array[$index];
        }
        return $t;
    }

    /**
     * Sums the product of two
     * equally-length arrays.
     *
     * @param  array $first
     * @param  array $second
     *
     * @return int
     */
    private function calcSum(array $first, array $second): int
    {
        $total = 0;
        for($i=0; $i<count($first); $i++) {
            $total += $first[$i]*$second[$i];
        }
        return $total;
    }

    /**
     * Retrieves the alpha representation for
     * the parameter.
     *
     * @param int $key
     *
     * @return string
     */
    public function parseToAlpha(int $key): string
    {
        $totalChars = count($this->alpha);
        if ($key < $totalChars) {
            return $this->alpha[$key];
        } else {
            //Get the int to determine the first letter.
            $index = floor($key/$totalChars);
            $alpha = $this->alpha[$index];
            //Take the remainder and find the index of the second letter.
            $remainder = $key - ($totalChars*$index);
            if($remainder === 0) {
                $alpha .= 'Z';
            } else {
                $alpha .= $this->alpha[$remainder];
            }
            return $alpha;
        }
    }
}
