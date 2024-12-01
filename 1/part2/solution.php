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


    // $map2 = $value => count
    $map2 = [];
    foreach ($list2 as $val) {
        $map2[$val] = ($map2[$val] ?? 0) + 1;
    }

    $score = 0;
    foreach ($list1 as $val) {
        $score += $val * ($map2[$val] ?? 0);
    }

    echo "$score\n";
}

main();
