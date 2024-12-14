<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$data = explode(' ', $data);
$data = array_map('intval', $data);

function add(&$buffer, $stone, $count)
{
    if (empty($buffer[$stone])) {
        $buffer[$stone] = 0;
    }

    $buffer[$stone] += $count;
}

function blink(array $stones): array
{
    $buffer = array();

    foreach ($stones as $stone => $count) {

        if (0 == $stone) {

            add($buffer, 1, $count);;

        } elseif (0 == strlen((string)$stone) % 2) {

            $stone = (string)$stone;
            add($buffer, (int)substr($stone, 0, floor(strlen($stone) / 2)), $count);
            add($buffer, (int)substr($stone, floor(strlen($stone) / 2)), $count);

        } else {

            add($buffer, $stone * 2024, $count);
        }
    }

    var_export($buffer);

    return $buffer;
}

$stones = array_count_values($data);

var_dump($stones);

for ($i = 0; $i < 75; $i++) {

    $stones = blink($stones);

}

$sum = array_sum($stones);

echo $sum . PHP_EOL;

?>
