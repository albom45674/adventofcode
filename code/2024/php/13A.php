<?php

$fo = fopen('php://stdin', 'r');

$data = stream_get_contents($fo);

$sum = 0;

preg_match_all('/Button A: X\+(?<ax>\d+), Y\+(?<ay>\d+)\nButton B: X\+(?<bx>\d+), Y\+(?<by>\d+)\nPrize: X=(?<x>\d+), Y=(?<y>\d+)/', $data, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {

    $ax = $match['ax'];
    $ay = $match['ay'];

    $bx = $match['bx'];
    $by = $match['by'];

    $x = $match['x'];
    $y = $match['y'];

    for ($i = 1; $i <= 100; $i++) {
        for ($j = 1; $j <= 100; $j++) {

            $px = $ax * $i + $bx * $j;
            $py = $ay * $i + $by * $j;

            if ($x == $px && $y == $py) {
                $sum += $i*3 + $j;
            }

        }
    }
}

echo $sum . PHP_EOL;

?>
