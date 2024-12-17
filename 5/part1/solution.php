<?php

/* This sucks, just use an associative array and compare the indexes the rules are at instead */

$mode = 'input';
// $mode = 'test';
$contents = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$mode.'.txt');
$contents = array_map(fn ($c) => preg_replace('/\s+/','',$c), $contents);

$rules = [];
$updates = [];
$return = 0;

$lb = false;
foreach ($contents as $content) {
    if (!strlen($content)) {
        $lb = true;
        continue;
    }

    if(!$lb) {
        $rules[] = explode('|', $content);
        continue;
    }

    $updates[] = explode(',', $content);
}

foreach ($updates as $update) {
    if (validateUpdate($update, $rules)) {
        $return += $update[intdiv(count($update), 2)];
    }
}

function validateUpdate($update, $rules):bool {
    foreach ($update as $i => $val) {
        $before_val = array_slice($update, 0, $i);
        $after_val = array_slice($update, $i+1);

        $before_rules = array_filter(array_map(function($r) use ($val) {
            return $r[1] == $val ? $r[0] : [];
        },$rules));

        $after_rules = array_filter(array_map(function($r) use ($val) {
            return $r[0] == $val ? $r[1] : [];
        },$rules));

        $val_res = validateValue($val, $before_rules, $after_rules, $before_val, $after_val);

        if(!$val_res) {
            return false;
        }

    }
    return true;
}

function validateValue($val, $before_rules, $after_rules, $before_val, $after_val): bool {
    $before_state = array_all($before_val,
        function($v) use ($before_rules, $after_rules) {
            if (in_array($v, $before_rules) && !in_array($v, $after_rules)) {
                return true;
            }
            return false;
        }
    );
    $after_state = array_all($after_val,
        function($v) use ($before_rules, $after_rules) {
            if (!in_array($v, $before_rules) && in_array($v, $after_rules)) {
                return true;
            }
            return false;
        }
    );
    return $before_state && $after_state;
}

echo $return."\n";
