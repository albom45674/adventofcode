<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);

$sum = 0;

$lamps = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach ($data as $line) {

    if (!preg_match('/((?<on>turn on)|(?<off>|turn off)|(?<toggle>toggle)) (?<x1>\d+),(?<y1>\d+) through (?<x2>\d+),(?<y2>\d+)/', $line, $match)) {
        continue;
    }

    for ($i = (int)$match['x1']; $i <= (int)$match['x2']; $i++) {
        for ($j = (int)$match['y1']; $j <= (int)$match['y2']; $j++) {

            if (!empty($match['on'])) {
                $lamps[$i][$j]++;
            } elseif (!empty($match['off']) && $lamps[$i][$j] > 0) {
                $lamps[$i][$j]--;
            } elseif (!empty($match['toggle'])) {
                $lamps[$i][$j] += 2;
            }
        }
    }
}


for ($i = 0; $i < 1000; $i++) {
    for ($j = 0; $j < 1000; $j++) {
        $sum += $lamps[$i][$j];
    }
}

echo $sum . PHP_EOL;

?>
