<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$sum = 0;

for ($i = 0; $i < strlen($data); $i++) {
    if ('(' == $data[$i]) {
        $sum++;
    } elseif (')' == $data[$i]) {
        $sum--;
    }

    if (-1 == $sum) {
        break;
    }
}

echo $i+1 . PHP_EOL;

?>
