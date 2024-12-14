<?php

define('y', 0);
define('x', 1);

$fo = fopen('php://stdin', 'r');

$count = 0;

$pos = $vel = array();

$width = $height = 0;

function printMap(bool $full = false)
{
    global $pos, $vel, $width, $height;

    $mw = floor($width / 2);
    $mh = floor($height / 2);
 
    for ($i = 0; $i < $height; $i++) {
        for ($j = 0; $j < $width; $j++) {

            if (!$full && ($i == $mh || $j == $mw)) {
                echo ' ';
                continue;
            }

            $d = 0;
            foreach ($pos as $p) {
                if ($p[x] == $j && $p[y] == $i) {
                    $d++;
                }
            }
            echo $d ? '*' : ' ';
        }
        echo PHP_EOL;
    }
}

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    preg_match('/p=(\d+),(\d+) v=(-?\d+),(-?\d+)/', $line, $match);

    $pos[$count] = array((int)$match[2], (int)$match[1]);
    $vel[$count] = array((int)$match[4], (int)$match[3]);

    if ($pos[$count][x] > $width) {
        $width = $pos[$count][x];
    }

    if ($pos[$count][y] > $height) {
        $height = $pos[$count][y];
    }

    $count++;
}

$width++;
$height++;

for ($i = 0; $i < $count; $i++) {
    echo $pos[$i][y] . ',' . $pos[$i][x] . '   ' . $vel[$i][y] . ',' . $vel[$i][x] . PHP_EOL;
}

echo $height . ' x ' . $width . PHP_EOL;

$mw = floor($width / 2);
$mh = floor($height / 2);

for ($steps = 1; $steps < 10000; $steps++) {

    $f1 = $f2 = $f3 = false;

    $lines = $rows = array_fill(0, $height, 0);

    for ($i = 0; $i < $count; $i++) {

        $pos[$i][x] = ($pos[$i][x] + $vel[$i][x]) % $width;
        $pos[$i][y] = ($pos[$i][y] + $vel[$i][y]) % $height;

        if ($pos[$i][x] < 0) {
            $pos[$i][x] += $width;
        }

        if ($pos[$i][y] < 0) {
            $pos[$i][y] += $height;
        }

        $rows[$pos[$i][x]]++;
        $lines[$pos[$i][y]]++;
    }

    if (max($lines) > 30 && max($rows) > 30) {
        echo $steps . PHP_EOL;
        printMap(true);
        break;
    }
}

echo $steps . PHP_EOL;

?>
