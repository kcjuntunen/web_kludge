<?php
$cf = file_get_contents('/etc/arduino_log.json');
$config = json_decode($cf);

$db_pi1 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi1');
$db_pi2 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi2');

if(!$db_pi1 && !$db_pi2) {
    echo $db_pi1->lastErrorMsg();
    echo $db_pi2->lastErrorMsg();
} else {
    $sql =<<<EOF
SELECT *
FROM snapshot_log ORDER BY id DESC LIMIT 1;
EOF;
    $arr = array();
    array_push($arr, $db_pi1->query($sql));
    array_push($arr, $db_pi2->query($sql));
    echo "<table>";
    echo " <th></th>\n";
    echo " <th>Timestamp</th>\n";
    echo " <th>Humidity (%)</th>\n";
    echo " <th>Pressure (hPa)</th>\n";
    echo " <th>Temperature (°F)</th>\n";
    echo " <th>Motion Count</th>\n";
    echo " <th>Motion Time (s)</th>\n";
    echo " <th>Drawer</th>\n";
    $location = array("Office", "Demo Area");
    for ($i = 0; $i < count($arr); $i++) {
        while ($row = $arr[$i]->fetch_assoc()) {
            echo " <tr>\n";
            $draw = 'Closed';
            if ($i == 0 && ($row['reed_switch2'] > 0))
                $draw = 'Open';
            else if ($i > 0 && ($row['reed_switch1'] > 0))
                $draw = 'Open';
            echo " <th scope='row'><a href='look_back_pi" . ($i + 1) . ".php'>"
                . $location[$i]
                . "</a></th> \n";
            echo "  <td>" . $row['timestamp'] . "</td> \n";
            echo "  <td>" . $row['humidity'] . "</td> \n";
            echo "  <td>" . number_format($row['pressure'], 2) . "</td> \n";
            echo "  <td>" . $row['temperature'] . "</td> \n";
            if ($i == 0)
                echo "  <td>" . $row['people_count'] . "</td> \n";
            else
                echo "  <td>" . $row['count'] . "</td> \n";
            echo "  <td>" . $row['motion_time'] / 1000.0 . "</td> \n";
            echo "  <td>" . $draw . "</td> \n";
            echo " </tr>\n";
        }
    }
    echo "</table>\n";
	    
    $db_pi1->close();
    $db_pi2->close();
}
?>