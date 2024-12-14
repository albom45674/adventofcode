<?php

$fo = fopen('php://stdin', 'r');

$data = stream_get_contents($fo);

$sum = 0;

preg_match_all('/Button A: X\+(?<Xa>\d+), Y\+(?<Ya>\d+)\nButton B: X\+(?<Xb>\d+), Y\+(?<Yb>\d+)\nPrize: X=(?<X>\d+), Y=(?<Y>\d+)/', $data, $matches, PREG_SET_ORDER);

$M = 10000000000000;

foreach ($matches as $match) {

    echo $match[0] . PHP_EOL;

    $Xa = $match['Xa'];
    $Ya = $match['Ya'];

    $Xb = $match['Xb'];
    $Yb = $match['Yb'];

    $Xd = $match['X'];
    $Yd = $match['Y'];

    $b = floor(($M * ($Xa - $Ya) + $Yd * $Xa - $Xd * $Ya) / ($Yb * $Xa - $Xb * $Ya));

    $a = floor(($M + $Xd - $b * $Xb) / $Xa);

    $Px = $a * $Xa + $b * $Xb;
    $Py = $a * $Ya + $b * $Yb;

    echo $Px . ' ' . $Py . PHP_EOL;

    if ($M + $Xd == $Px && $M + $Yd == $Py) {
        $sum += 3 * $a + $b;
    }
}

echo $sum . PHP_EOL;

?>
