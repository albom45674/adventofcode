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
            $x1 = $ants[$i][x] + $w;
            $y1 = $ants[$i][y] + $h;
            $x2 = $ants[$j][x] - $w;
            $y2 = $ants[$j][y] - $h;
            if ($x1 >= 0 && $x1 < $width && $y1 >= 0 && $y1 < $height && '.' == $nodes[$y1][$x1]) {
                $nodes[$y1][$x1] = '#';
                $sum++;
            }
            if ($x2 >= 0 && $x2 < $width && $y2 >= 0 && $y2 < $height && '.' == $nodes[$y2][$x2]) {
                $nodes[$y2][$x2] = '#';
                $sum++;
            }
        }
    }
}

for ($i = 0; $i < $height; $i++) {
    echo implode('', $nodes[$i]) . PHP_EOL;
};

echo $sum . PHP_EOL;

?>
