<?php

$fo = fopen('php://stdin', 'r');

$sum = 0;

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    list($l, $w, $h) = explode('x', $line);

    $squares = array(
        2 * ($l + $w),
        2 * ($w + $h),
        2 * ($h + $l),
    );

    $sum += min($squares) + $l * $w * $h;
}

echo $sum . PHP_EOL;

?>
