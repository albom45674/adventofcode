<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);
array_walk($data, 'trim');
$data = array_filter($data);

$sum = 0;

$width = strlen($data[0]);
$height = count($data);

$aerials = $nodes = array();

echo $width . ' x ' . $height . PHP_EOL . implode(PHP_EOL, $data) . PHP_EOL;

for ($i = 0; $i < $height; $i++) {
    $nodes[$i] = array();
    for ($j = 0; $j < $width; $j++) {
        $nodes[$i][$j] = '.';
        if ('.' == $data[$i][$j]) {
            continue;
        }
        if (empty($aerials[$data[$i][$j]])) {
            $aerials[$data[$i][$j]] = array();
        }
        $aerials[$data[$i][$j]][] = array($i, $j);
    }
}

// We like keeping things in order
ksort($aerials);

define('y', 0);
define('x', 1);

foreach ($aerials as $freq => $ants) {
    echo $freq . ': ';
    foreach ($ants as $ant) {
        echo '[' . $ant[x] . ',' . $ant[y] . ']  ';
    }
    echo PHP_EOL;
}

foreach ($aerials as $freq => $ants) {
    for ($i = 0; $i < count($ants) - 1; $i++) {
        for ($j = $i + 1; $j < count($ants); $j++) {
            $w = $ants[$i][x] - $ants[$j][x];
            $h = $ants[$i][y] - $ants[$j][y];

            for ($x = $ants[$i][x], $y = $ants[$i][y]; $x >= 0 && $x < $width && $y >= 0 && $y < $height; $x += $w, $y += $h) {
                if ('.' == $nodes[$y][$x]) {
                    $nodes[$y][$x] = '#';
                    $sum++;
                }
            }

            for ($x = $ants[$j][x], $y = $ants[$j][y]; $x >= 0 && $x < $width && $y >= 0 && $y < $height; $x -= $w, $y -= $h) {
                if ('.' == $nodes[$y][$x]) {
                    $nodes[$y][$x] = '#';
                    $sum++;
                }
            }
        }
    }
}

for ($i = 0; $i < $height; $i++) {
    echo implode('', $nodes[$i]) . PHP_EOL;
};

echo $sum . PHP_EOL;

?>
