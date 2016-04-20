<html>
 <head>
  <title>Amstore Smart Fixtures</title>
  <link rel="stylesheet" href="code/css/960.css">
  <link rel="stylesheet" href="style.css">
  <style>
  </style>
 </head>
  
 <body>
  <h1><a href='index.html'>Office</a></h1>
  <div class="container_12">
  <div class="grid_1"> </div>
  <div class="grid_11">

<?php
$cf = file_get_contents('/etc/arduino_log.json');
$config = json_decode($cf);

$db_pi1 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi1');

if(!$db_pi1) {
    echo $db_pi1->lastErrorMsg();
} else {
$sql =<<<EOF
CALL get_distinct_counts();
EOF;
    
    $ret = $db_pi1->query($sql);
    echo "<table>";
    //    echo " <th></th>\n";
    echo " <th>Timestamp</th>\n";
    echo " <th>Humidity (%)</th>\n";
    echo " <th>Pressure (hPa)</th>\n";
    echo " <th>Temperature (°F)</th>\n";
    echo " <th>Motion Count</th>\n";
    echo " <th>Motion Time (s)</th>\n";
    echo " <th>Drawer</th>\n";

    while ($row = $ret->fetch_assoc()) {
        echo " <tr>\n";
        $draw = 'Closed';
        if ($row['reed_switch2'] > 0) $draw = 'Open';
        echo "  <td>" . $row['timestamp'] . "</td> \n";
        echo "  <td>" . $row['humidity'] . "</td> \n";
        echo "  <td>" . number_format($row['pressure'], 2) . "</td> \n";
        echo "  <td>" . $row['temperature'] . "</td> \n";
        echo "  <td>" . number_format($row['people_count'], 0) . "</td> \n";
        echo "  <td>" . $row['motion_time'] / 1000.0 . "</td> \n";
        echo "  <td>" . $draw . "</td> \n";
        echo " </tr>\n";
    }
	    
    $db_pi1->close();
}
?>
</div></div></div>
</body>
</html>