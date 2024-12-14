<?php

function get_xmas(string $str, int $len = 0): int
{
    $pattern = '/(?=(X.{LEN}M.{LEN}A.{LEN}S))|(?=(S.{LEN}A.{LEN}M.{LEN}X))/ms';

    $pattern = str_replace('LEN', $len, $pattern);

    return preg_match_all($pattern, $str);
}

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$len = strpos($data, PHP_EOL) + 1;

$sum = 0;

// Horizontal
$sum += get_xmas($data);

echo $sum . PHP_EOL;

// Vertical
$sum += get_xmas($data, $len - 1); 

echo $sum . PHP_EOL;

// Diagonal straight
$sum += get_xmas($data, $len);

echo $sum . PHP_EOL;

// Diagonal reverse
$sum += get_xmas($data, $len - 2);

echo $sum . PHP_EOL;

?>
