<?php

function my_gmp_sign($n) {
    return ($n > 0 ) ? 1 : ( ( $n < 0 ) ? -1 : 0 );
}

$file = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'input.txt');

$return = array_filter($file, static function($val){
    $val = explode(' ', $val);

    $return = true;

    $direction = my_gmp_sign($val[1]-$val[0]);

    foreach($val as $k => $v) {
        if(!isset($val[$k+1])) {
            continue;
        }

        if (!$direction) {
            $return = false;
            break;
        }

        if(!isset($val[$k+1])) {
            continue;
        }

        $abs = abs($v-$val[$k+1]);
        if ($abs > 3 || $abs == 0) {
            $return = false;
            break;
        }

        if (my_gmp_sign($val[$k+1]-$v) !== $direction) {
            $return = false;
            break;
        }
    }
    return $return;
});

echo count($return)."\n";
