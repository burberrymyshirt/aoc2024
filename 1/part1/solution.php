<?php

function readFileData($filePath): array
{
    $file = file_get_contents($filePath);
    $file = str_replace("\n", ' ', $file);
    $file = preg_replace('/\s+/', ' ', $file);
    $file = trim($file);
    return explode(' ', $file);
}

function main()
{
    $filePath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'input.txt';

    $explode = readFileData($filePath);

    $list1 = [];
    $list2 = [];

    $size = count($explode);
    for ($i = 0; $i < $size; $i += 2) {
        $list1[] = (int)$explode[$i];
        $list2[] = (int)$explode[$i + 1];
    }

    sort($list1, SORT_NUMERIC);
    sort($list2, SORT_NUMERIC);

    $distance = 0;
    foreach ($list1 as $i => $value) {
        $distance += abs($value - $list2[$i]);
    }

    echo "$distance\n";
}

main();
