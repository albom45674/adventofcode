<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

$sum = 0;

$disk = array();

$isFile = true;
$fileNumber = 0;
$blockLength = 0;
for ($i = 0; $i < strlen($data); $i++) {
    $blockLength = (int)$data[$i];
    if ($isFile) {
        for ($j = 0; $j < $blockLength; $j++) {
            $disk[] = $fileNumber;
        }
    } else {
        for ($j = 0; $j < $blockLength; $j++) {
            $disk[] = '.';
        }
        $fileNumber++;
    }
    $isFile = !$isFile;
}

echo implode('', $disk) . PHP_EOL;

for ($i = 0, $j = count($disk) - 1; $i < $j; $i++, $j--) {
    while ($disk[$i] != '.') {
        $i++;
    }

    while ($disk[$j] == '.') {
        $j--;
    }

    $disk[$i] = $disk[$j];
    $disk[$j] = '.';
}

for ($i = 0; $i < count($disk) && $disk[$i] != '.'; $i++) {
    $sum += $i * $disk[$i];
}

echo $sum . PHP_EOL;

?>
