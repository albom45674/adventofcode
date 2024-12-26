<?php

$fo = fopen('php://stdin', 'r');

$count = 0;

$connections = array();

function addConnection(string $c1, string $c2)
{
    global $connections;

    if (empty($connections[$c1])) {
        $connections[$c1] = array();
    };

    if ($c2 > $c1) {
        $connections[$c1][] = $c2;
    }
}

while (false !== ($line = fgets($fo))) {

    if (empty($line)) {
        continue;
    }

    list($c1, $c2) = explode('-', trim($line));

    addConnection($c1, $c2);
    addConnection($c2, $c1);
}

ksort($connections);

foreach ($connections as $key => $connection) {
    sort($connections[$key]);
}

$circles = array();

foreach ($connections as $c1 => $connection) {

    for ($k2 = 0; $k2 < count($connection) - 1; $k2++) {
        $c2 = $connection[$k2];
        for ($k3 = $k2 + 1; $k3 < count($connection); $k3++) {
            $c3 = $connection[$k3];
            if ('t' == $c1[0] || '') {
            }
            if (
                in_array($c3, $connections[$c2])
                && ('t' == $c1[0] || 't' == $c2[0] || 't' == $c3[0])
            ) {
                $circles[] = implode(',', array($c1, $c2, $c3));
            }
        }
    }
}

echo implode(PHP_EOL, $circles) . PHP_EOL;

$count = count($circles);

echo $count . PHP_EOL;

?>
