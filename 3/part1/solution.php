<?php

$mode = 'input';
// $mode = 'test';
$contents = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');

$matches_all = [];
preg_match_all('/mul\(\d+,\d+\)/', $contents, $matches_all);

$return = 0;
foreach ($matches_all[0] as $val) {
    $matches_specific = [];
    preg_match_all('/\d+,\d+/', $val, $matches_specific);

    $nums = explode(',', $matches_specific[0][0]);
    
    $return += $nums[0] * $nums[1];
}

echo $return."\n";
