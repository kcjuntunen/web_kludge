<?php
$cf = file_get_contents('/etc/arduino_log.json');
$config = json_decode($cf);

$db_pi1 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi1');
$db_pi2 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi2');

if(!$db_pi1 || !$db_pi2) {
    echo $db_pi1->lastErrorMsg();
    echo $db_pi2->lastErrorMsg();
} else {
    $sql =<<<EOF
SELECT *
FROM snapshot_log ORDER BY id DESC LIMIT 1;
EOF;
    $arr = array();
    $array = array();
    array_push($arr, $db_pi1->query($sql));
    array_push($arr, $db_pi2->query($sql));
    for ($i = 0; $i < count($arr); $i++) {
        while ($row = $arr[$i]->fetch_assoc()) {
            array_push($array, $row);
        }
    }
    echo json_encode($array), "\n";
}
?>