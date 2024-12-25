<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

preg_match_all('/(?<lock>^#{5}\n(?>[.#]{5}\n?){6})|(?<key>^\.{5}\n(?>[.#]{5}\n?){6})/m', $data, $match, PREG_PATTERN_ORDER);

function convert(string $item): array
{
    $result = array_fill(0, 5, -1);

    $item = explode(PHP_EOL, $item);
    for ($i = 0; $i < count($item); $i++) {
        for ($j = 0; $j < strlen($item[$i]); $j++) {
            if ('#' == $item[$i][$j]) {
                $result[$j]++;
            }
        }
    }

    return $result;
}

$locks = $keys = array();

foreach (array_filter($match['lock']) as $lock) {
    $locks[] = convert($lock);
}

foreach (array_filter($match['key']) as $key) {
    $keys[] = convert($key);
}

$sum = 0;

foreach ($locks as $lock) {
    foreach ($keys as $key) {
        $match = true;
        for ($i = 0; $i < count($lock); $i++) {
            if ($lock[$i] + $key[$i] > 5) {
                $match = false;
                break;
            }
        }

        if ($match) {
            echo 'Lock [' . implode(',', $lock) . '] and key (' . implode(',', $key) . ') fit!' . PHP_EOL;
            $sum++; 
        }
    }
}

echo $sum . PHP_EOL;

?>
