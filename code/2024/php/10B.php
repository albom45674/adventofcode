<?php

define('x', 1);
define('y', 0);

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);
array_walk($data, 'trim');
$data = array_filter($data);

$sum = 0;

$width = strlen($data[0]);
$height = count($data);

echo $width . ' x ' . $height . PHP_EOL . implode(PHP_EOL, $data) . PHP_EOL;

$trails = $routes = array();

$count = 0;

function printTrail(array $path)
{
    global $data;

    foreach ($path as $point) {
        echo sprintf('%s[%s,%s] ', $data[$point[y]][$point[x]], $point[y], $point[x]);
    }

    echo PHP_EOL;
}

function getNext(int $y, int $x, array $path = array())
{
    global $data, $trails, $routes, $width, $height;

    $path[] = array($y, $x);

    if (9 == $data[$y][$x]) {
        $head = $path[0][y] * $height + $path[0][x];
        $tail = $y * $height + $x;
        if (!in_array($tail, $routes[$head]) || true) {
            $routes[$head][] = $tail;
            $trails[] = $path;
        }
        return;
    }

    $moves = array(
        array(-1, 0),
        array(1, 0),
        array(0, -1),
        array(0, 1),                 
    ); 

    foreach ($moves as $move) {

        $i = $y + $move[y];
        $j = $x + $move[x];
        if ($i >= 0 && $i < $height && $j >= 0 && $j < $width && $data[$i][$j] == $data[$y][$x] + 1) {
            getNext($i, $j, $path);
        }
    }
}

for ($i = 0; $i < $height; $i++) {
    for ($j = 0; $j < $width; $j++) {
        if ($data[$i][$j] == '0') {
            $routes[$i * $height + $j] = array();
            getNext($i, $j);
        }
    }
}


$sum = count($trails);

echo $sum . PHP_EOL;

?>
