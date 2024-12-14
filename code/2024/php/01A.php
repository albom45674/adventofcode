<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(PHP_EOL, $data);

$sum = 0;

$a = $b = array();

foreach ($data as $line) {

    preg_match_all('/\d+/', trim($line), $digits);

    if (!empty($digits) && !empty($digits[0])) {
        $a[] = $digits[0][0];
        $b[] = $digits[0][1];
    }
}

sort($a);
sort($b);

for ($i = 0; $i < count($a); $i++) {
    $sum += abs($a[$i] - $b[$i]);
}

echo $sum . PHP_EOL;

?>
