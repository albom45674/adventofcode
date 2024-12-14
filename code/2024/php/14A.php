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
            echo $d ? $d : '.';
        }
        echo PHP_EOL;
    }
}

function calculateMap(): array
{
    global $pos, $vel, $width, $height;

    $result = array(0, 0, 0, 0);

    $mw = floor($width / 2);
    $mh = floor($height / 2);

    foreach ($pos as $p) {
        if ($p[x] < $mw && $p[y] < $mh) {
            $result[0]++;
        } elseif ($p[x] > $mw && $p[y] < $mh) {
            $result[1]++;
        } elseif ($p[x] < $mw && $p[y] > $mh) {
            $result[2]++;
        } elseif ($p[x] > $mw && $p[y] > $mh) {
            $result[3]++;
        }
    }

    return $result;
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

//$width = 101;
//$height = 103;

for ($i = 0; $i < $count; $i++) {
    echo $pos[$i][y] . ',' . $pos[$i][x] . '   ' . $vel[$i][y] . ',' . $vel[$i][x] . PHP_EOL;
}

echo $height . ' x ' . $width . PHP_EOL;

printMap(true);

$steps = 100;

for ($i = 0; $i < $count; $i++) {

    $pos[$i][x] = ($pos[$i][x] + $vel[$i][x] * $steps) % $width;
    $pos[$i][y] = ($pos[$i][y] + $vel[$i][y] * $steps) % $height;

    if ($pos[$i][x] < 0) {
        $pos[$i][x] += $width;
    }

    if ($pos[$i][y] < 0) {
        $pos[$i][y] += $height;
    }
}



echo PHP_EOL;

printMap();

$map = calculateMap();

$sum = 1;

foreach ($map as $value) {
    $sum *= $value;
}

echo $sum . PHP_EOL;

?>
