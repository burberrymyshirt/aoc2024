<?php

$mode = 'input';
// $mode = 'test';
$contents = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');

$matches_all = [];
preg_match_all('/mul\(\d+,\d+\)|do\(\)|don\'t\(\)/', $contents, $matches_all);

$return = 0;
$state = true;
foreach ($matches_all[0] as $val) {
    if ($val === 'do()') {
        $state = true;
    }

    if ($val === 'don\'t()') {
        $state = false;
    }

    if ($state) {
        $matches_specific = [];
        preg_match_all('/\d+,\d+/', $val, $matches_specific);

        if(!$matches_specific[0]) {
            continue;
        }

        $nums = explode(',', $matches_specific[0][0]);
        $return += $nums[0] * $nums[1];
    }
}

echo $return."\n";