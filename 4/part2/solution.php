<?php

/*
 * I am not quite satisfied with this, as it only works on three letter inputs,
 * as well as being a bit messy when fetching the X, but it still worked for the challenge nonetheless :D
 */

// $mode = 'test';
$mode = 'input';

$contents = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');
$matrixz = array_map(fn ($var) => str_split(preg_replace('/\s+/', '', $var)), $contents);

const WORD = 'MAS';

const DIRECTIONS = [
    'up_right'   => [-1, 1],
    'down_right' => [1,  1],
    'up_left'    => [-1,-1],
    'down_left'  => [1, -1],
];

function checkMatrix(
    array $matrix, 
    int &$result, 
): void {

    foreach ($matrix as $y => $line) {
        foreach ($line as $x => $val) {

            if($val !== WORD[1]){
                continue;
            }

            if (checkX_MAS($y, $x, $matrix)) {
                $result++;
            }
        }
    }
}

function checkX_MAS($start_y, $start_x, $matrix): bool {

    $surr = getSurroundingLetters($start_y, $start_x, $matrix);
    $opposites = [WORD[0], WORD[2]];

    if (
        !in_array($surr['down_left'], $opposites) ||
        !in_array($surr['down_right'], $opposites) ||
        !in_array($surr['up_left'], $opposites) ||
        !in_array($surr['up_right'], $opposites)
    ) {
        return false;
    }

    if (
        $surr['down_left'] === $surr['up_right'] ||
        $surr['down_right'] === $surr['up_left']
    ) {
        return false;
    }

    return true;
}

function getSurroundingLetters($y, $x, $matrix): array
{
    $return = [];

    $return['up_left'] = $matrix[$y + DIRECTIONS['up_left'][0]][$x + DIRECTIONS['up_left'][1]] ?? '';
    $return['up_right'] = $matrix[$y + DIRECTIONS['up_right'][0]][$x + DIRECTIONS['up_right'][1]] ?? '';
    $return['down_left'] = $matrix[$y + DIRECTIONS['down_left'][0]][$x + DIRECTIONS['down_left'][1]] ?? '';
    $return['down_right'] = $matrix[$y + DIRECTIONS['down_right'][0]][$x + DIRECTIONS['down_right'][1]] ?? '';

    return $return;
}

$return = 0;

checkMatrix($matrixz, $return);

echo $return."\n";
