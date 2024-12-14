<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$stones = explode(' ', $data);
$stones = array_map('intval', $stones);

for ($i = 0; $i < 25; $i++) {

    $buffer = array();

    foreach ($stones as $key => $stone) {

        if (0 == $stone) {

            $buffer[] = 1;

        } elseif (0 == strlen((string)$stone) % 2) {

            $stone = (string)$stone;
            $buffer[] = (int)substr($stone, 0, floor(strlen($stone) / 2));
            $buffer[] = (int)substr($stone, floor(strlen($stone) / 2));

        } else {

            $buffer[] = $stone * 2024;
        }
    }

    $stones = $buffer;
}

$sum = count($stones);

echo $sum . PHP_EOL;

?>
