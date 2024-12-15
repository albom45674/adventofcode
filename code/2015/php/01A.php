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
}

echo $sum . PHP_EOL;

?>
