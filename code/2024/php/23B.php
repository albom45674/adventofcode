<?php

$fo = fopen('php://stdin', 'r');

$connections = array();

function addConnection(string $c1, string $c2)
{
    global $connections;

    if (empty($connections[$c1])) {
        $connections[$c1] = array();
    };

    if ($c2 > $c1 || true) {
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

// Just because we like everything sorted

ksort($connections);

foreach ($connections as $key => $connection) {
    sort($connections[$key]);
}


foreach ($connections as $c1 => $connection) {

    echo $c1 . ': ' . implode(',', $connection) . PHP_EOL;
}

/**
 * Append single point to the array
 */
function unite(string $point, array $points): array
{
    $points[] = $point;

    return $points;
}

/**
 * Intersect point connections and given array
 */
function intersect(string $point, array $points): array
{
    global $connections;

    return array_intersect($connections[$point], $points);
}

/**
 * Thanks to Bron and Kerbosch
 * See https://medium.com/nuances-of-programming/9cc72019e8f2
 */
function search(array $points, array $checked = array(), array $group = array())
{
    global $groups;

    if (empty($points) && empty($checked)) {
        sort($group);
        $groups[] = implode(',', $group);
        return;
    }

    while (!empty($points)) {

        // Take point from current list but keep it there
        $point = reset($points);

        search(intersect($point, $points), intersect($point, $checked), unite($point, $group));

        // Now remove the point from the list
        array_shift($points);
        $checked = unite($point, $checked);
    }
}

search(array_keys($connections));

$password = '';

foreach ($groups as $group) {

    if (strlen($group) > strlen($password)) {
        $password = $group;
    }
}

echo $password . PHP_EOL;

?>
