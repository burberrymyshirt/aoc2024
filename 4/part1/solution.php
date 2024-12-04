<?php


// $mode = 'test';
$mode = 'input';

$contents = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');
$matrixz = array_map(fn ($var) => str_split(preg_replace('/\s+/', '', $var)), $contents);

const WORD = 'XMAS';

const DIRECTIONS = [
    'right'      => [0,  1],
    'down'       => [1,  0],
    'left'       => [0, -1],
    'up'         => [-1, 0],
    'up_right'   => [-1, 1],
    'down_right' => [1,  1],
    'up_left'    => [-1,-1],
    'down_left'  => [1, -1],
];

function checkMatrix(
    array $matrix, 
    int &$result, 
): void {

    $dirs = array_keys(DIRECTIONS);

    foreach ($matrix as $y => $line) {
        foreach ($line as $x => $val) {

            if($val !== WORD[0]){
                continue;
            }

            foreach ($dirs as $dir) {
                if (checkInDirection($dir, $y, $x, $matrix)) {
                    $result++;
                }
            }
        }
    }
}

function checkInDirection($direction, $start_y, $start_x, $matrix): bool {
    $word_len = strlen(WORD);

    $dir_cords = DIRECTIONS[$direction];

    for ($i = 1; $i < $word_len; $i++) {

        $val = $matrix[$start_y + $dir_cords[0]][$start_x + $dir_cords[1]] ?? '';

        if ($val !== WORD[$i]) {
            return false;
        }

        $dir_cords = array_map('updateCord', $dir_cords);
    }
    
    return true;
}

function updateCord($val) {

    if ($val == 0) {
        return 0;
    } elseif ($val < 0) {
        return $val - 1;
    } else {
        return $val + 1;
    }
}

$return = 0;

checkMatrix($matrixz, $return);

echo $return."\n";
