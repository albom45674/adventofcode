<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$sum = 1;

$sx = $sy = $rx = $ry = 0;

$houses = array(
    0 => array(
        0 => 1,
    ),
);

for ($i = 0; $i < strlen($data); $i++) {

    if (0 == $i % 2) {
        $x =& $sx;
        $y =& $sy;
    } else {
        $x =& $rx;
        $y =& $ry;
    }

    if ('<' == $data[$i]) {
        $x--;
    } elseif ('>' == $data[$i]) {
        $x++;
    } elseif ('^' == $data[$i]) {
        $y++;
    } elseif ('v' == $data[$i]) {
        $y--;
    }

    if (empty($houses[$x])) {
        $houses[$x] = array();
    }

    if (empty($houses[$x][$y])) {
        $houses[$x][$y] = 1;
        $sum++;
    }
}

echo $sum . PHP_EOL;

?>
