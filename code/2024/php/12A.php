<?php

define('y', 0);
define('x', 1);

$moves = array(
    array(-1, 0),
    array(1, 0),
    array(0, -1),
    array(0, 1),
);

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);
$data = array_map('trim', $data);
$data = array_filter($data);

$height = count($data);
$width = strlen($data[0]);

$blocks = $matrix = array();

$maxId = 1;

$sum = 0;

function find(int $y, int $x): int
{
    global $data, $matrix, $blocks, $moves, $width, $height, $maxId;

    if (empty($matrix[$y])) {
        $matrix[$y] = array();
    }

    if (empty($blocks[$maxId])) {
        $blocks[$maxId] = array();
    }

    $matrix[$y][$x] = $maxId;
     
    $blocks[$maxId][] = array($y, $x);

    foreach ($moves as $move) {

        $i = $y + $move[y];
        $j = $x + $move[x];
        if ($i >= 0 && $i < $height && $j >= 0 && $j < $width && $data[$i][$j] == $data[$y][$x] && empty($matrix[$i][$j])) {
            find($i, $j);
        }
    }

    return 0;
}

for ($i = 0; $i < $height; $i++) {
    for ($j = 0; $j < $width; $j++) {
        if (!empty($matrix[$i][$j])) {
            continue;
        }
        find($i, $j);
        $maxId++;
    }
}

foreach ($blocks as $id => $block) {
    $area = count($block);
    $perimeter = 0;
    echo $id . ': ' . $data[$block[0][y]][$block[0][x]] . ' ';
    foreach ($block as $point) {

        $y = $point[y];
        $x = $point[x];

        foreach ($moves as $move) {

            $i = $y + $move[y];
            $j = $x + $move[x];
            if ($i < 0 || $i >= $height || $j < 0 || $j >= $width || $matrix[$i][$j] != $matrix[$y][$x]) {
                $perimeter++;
            }
        }
    }

    echo $area . ' x ' . $perimeter . PHP_EOL;

    $sum += $area * $perimeter;
}

echo $sum . PHP_EOL;

?>
