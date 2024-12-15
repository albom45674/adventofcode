<?php

$fo = fopen('php://stdin', 'r');

$sum = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    list($l, $w, $h) = explode('x', $line);

    $squares = array(
        $l * $w,
        $w * $h,
        $h * $l,
    );

    $sum += min($squares) + array_sum($squares) * 2;
}

echo $sum . PHP_EOL;

?>
