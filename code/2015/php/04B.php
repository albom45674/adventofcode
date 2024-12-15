<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = trim($data);

for ($i = 0;; $i++) {

    $md5 = md5($data . (string)$i);

    if ('000000' === substr($md5, 0, 6)) {

        echo $data . $i . ' ' . $md5 . PHP_EOL;
        break;
    }
}

echo $i . PHP_EOL;

?>
