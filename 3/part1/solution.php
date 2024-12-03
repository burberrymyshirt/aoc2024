<?php

$mode = 'input';
// $mode = 'test';

$contents = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');

$regex = '/mul\(\d+,\d+\)/';

$matches = [];
preg_match_all($regex, $contents, $matches);

$regex2 = '/\d+,\d+/';
$return = 0;
foreach ($matches[0] as $val) {
    $m = [];
    preg_match_all($regex2, $val, $m);

    $nums = $m[0][0];
    
    $nums = explode(',', $nums);
    
    $return += $nums[0] * $nums[1];

}

echo $return."\n";
