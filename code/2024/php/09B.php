<?php

$fo = fopen('php://stdin', 'r');
$data = stream_get_contents($fo);

function printDisk()
{
    global $files, $gaps;

    $sum = 0;

    foreach ($files as $id => $file) {
        $first = $file['start'];
        $last = $file['start'] + $file['length'];
        $sum += $id * $file['length'] * ($first + $last - 1) / 2;
    }

    return $sum;
}

$sum = 0;

$files = $gaps = array();

$isFile = true;
$fileNumber = 0;
$blockLength = 0;
$pos = 0;
for ($i = 0; $i < strlen($data); $i++) {
    $blockLength = (int)$data[$i];
    if ($isFile) {
        $files[$fileNumber] = array(
            'start'  => $pos,
            'length' => $blockLength,
        );
    } else {
        $gaps[] = array(
            'start'  => $pos,
            'length' => $blockLength,
        );
        $fileNumber++;
    }
    $isFile = !$isFile;
    $pos += $blockLength;
}

for ($i = count($files) - 1; $i > 0; $i--) {

    for ($j = 0; $j < count($gaps); $j++) {

        if ($gaps[$j]['start'] > $files[$i]['start']) {
            break;
        }

        if ($gaps[$j]['length'] >= $files[$i]['length']) {
            $files[$i]['start'] = $gaps[$j]['start'];
            $gaps[$j]['length'] -= $files[$i]['length'];
            $gaps[$j]['start'] += $files[$i]['length'];
            break;
        }
    }

}

foreach ($files as $id => $file) {
    $first = $file['start'];
    $last = $file['start'] + $file['length'];
    $sum += $id * $file['length'] * ($first + $last - 1) / 2;
}

echo $sum . PHP_EOL;

?>
