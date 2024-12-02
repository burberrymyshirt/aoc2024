<?php

$file = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'input.txt');

$return = array_filter($file, static function($val){
    $val = explode(' ', $val);

    if (test($val)) {
        return true;
    }

    $size = count($val);
    for ($i = 0; $i<$size; $i++) {
        $dupe = $val;

        unset($dupe[$i]);
        $dupe = array_values($dupe);

        if (test($dupe)) {
            return true;
        }

    }

    return false;
});

function test(array $val): bool {
    $direction = $val[1]-$val[0] <=> 0;

    foreach($val as $k => $v) {
        if(!isset($val[$k+1])) {
            continue;
        }

        if (!$direction) {
            return false;
        }

        $abs = abs($v-$val[$k+1]);
        if ($abs > 3 || $abs == 0) {
            return false;
        }

        if (($val[$k+1]-$v <=> 0) !== $direction) {
            return false;
        }
    }

    return true;
}

echo count($return)."\n";