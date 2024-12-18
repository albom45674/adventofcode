<?php

define('x', 1);
define('y', 0);
define('score', 2);

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);
$data = array_map('trim', array_filter($data));

$blocks = array();

// Detect dimension of the map right from the input
$max = 0;

for ($i = 0; $i < count($data); $i++) {
    list($x, $y) = array_map('intval', explode(',', $data[$i]));

    if ($x > $max) {
        $max = $x;
    }
    if ($y > $max) {
        $max = $y;
    }

    $blocks[] = array(
        y => $y,
        x => $x,
    );
}

$max++;

// Detect it right from the input. Sample is 7x7, input is 70x70
$first = (7 == $max) ? 12 : 1024;
$last = count($blocks) - 1;

function printMap(array $map)
{
    global $max, $route;

    $hasRoute = (getScore($max, $max) != PHP_INT_MAX);

    if ($hasRoute) {

        $x = $max;
        $y = $max;

        for ($i = 0; $i < $max*$max; $i++) {

            if (empty($route[$y][$x])) {
                break;
            }

            $map[$y][$x] = 'O';

            $point = $route[$y][$x];

            $y = $point[y];
            $x = $point[x];

            if ($x == 1 && $y == 1) {
                $map[1][1] = 'O';
                break;
            }
        }

    } else {

        for ($y = 1; $y <= $max; $y++) {
            for ($x = 1; $x <= $max; $x++) {
                if (
                    '#' != $map[$y][$x]
                    && PHP_INT_MAX != getScore($y, $x)
                ) {
                    $map[$y][$x] = 'O';
                }
            }
        }
    }

    for ($i = 0; $i < count($map); $i++) {
        if ($hasRoute) {
            $map[$i] = str_replace('O', "\033[01;32mO\033[0m", $map[$i]);
        } else {
            $map[$i] = str_replace('O', "\033[01;34mO\033[0m", $map[$i]);
        }
        $map[$i] = str_replace('.', ' ', $map[$i]);
    }

    echo implode(PHP_EOL, $map) . PHP_EOL;
}

function setScore(int $y, int $x, int $prevY = 0, int $prevX = 0, int $score = PHP_INT_MAX)
{
    global $route;

    $route[$y][$x] = array(
        score     => $score,
        y         => $prevY,
        x         => $prevX,
    );
}

function getScore(int $y, int $x): int
{
    global $route;

    if (empty($route[$y])) {
        $route[$y] = array();
    }

    if (empty($route[$y][$x])) {
        setScore($y, $x);
    }

    return $route[$y][$x][score];
}

function walk(int $y, int $x)
{
    global $route, $map, $max, $stop;

    if ($y == $max && $x == $max) {
        // In second part it's enough to find ANY route, the shortest is not necessary
        $stop = true;
    }

    if ($stop) {
        return;
    }

    static $moves = array(
        array(0, 1),
        array(-1, 0),
        array(0, -1),
        array(1, 0),
    );

    $score = getScore($y, $x) + 1;

    for ($i = 0; $i <4; $i++) {

        $nextX = $x + $moves[$i][x];
        $nextY = $y + $moves[$i][y];

        if (
            '#' != $map[$nextY][$nextX]
            && $score < getScore($nextY, $nextX)
        ) {

            setScore($nextY, $nextX, $y, $x, $score);
            walk($nextY, $nextX);
        }
    }
}

function init(int $count)
{
    global $blocks, $map, $max, $route;

    $map = array();
    $map[] = str_repeat('#', $max + 2);

    for ($i = 0; $i < $max; $i++) {
        $map[] = '#' . str_repeat('.', $max) . '#';
    }
    $map[] = str_repeat('#', $max + 2);

    for ($i = 0; $i < $count; $i++) {
        $map[$blocks[$i][y]+1][$blocks[$i][x]+1] = '#';
    }

    $route = array();
}

$maxGood = $first;
$minBad = $last;

while ($maxGood != $minBad - 1) {

    $check = $maxGood + floor(($minBad - $maxGood) / 2);

    init($check);

    $x = $y = 1;

    setScore($y, $x, 0, 0, 0);

    $stop = false;
    walk($y, $x);
    printMap($map);

    if (PHP_INT_MAX != getScore($max, $max)) {
        $maxGood = $check;
    } else {
        $minBad = $check;
    }

    echo $check . ': [' . $blocks[$check][x] . ',' . $blocks[$check][y] . ']' . PHP_EOL . PHP_EOL;
}

?>
