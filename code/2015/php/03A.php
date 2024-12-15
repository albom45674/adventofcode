<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$sum = 0;

$x = $y = 0;

$houses = array();

for ($i = 0; $i < strlen($data); $i++) {
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
