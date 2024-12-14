<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$sum = 0;

$data = preg_replace('/don\'t\(\).*(do\(\)|$)/Us', '', $data);

preg_match_all('/mul\((\d+),(\d+)\)/', $data, $matches, PREG_SET_ORDER);

foreach ($matches as $m) {
    $sum += $m[1] * $m[2];
}

echo $sum . PHP_EOL;

?>
