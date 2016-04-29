<?php
//////////////////////////////////////////////////////////////////////
//
// Socket
//
//////////////////////////////////////////////////////////////////////
error_reporting(E_ALL);

// echo "<h2>TCP/IP Connection</h2>\n";

/* Get the port for the WWW service. */
$service_port = 8080; // getservbyname('www', 'tcp');

/* Get the IP address for the target host. */
$address = '10.10.55.192'; // gethostbyname('www.example.com');

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    // echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";
$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    // echo "OK.\n";
}

// $in = "HEAD / HTTP/1.1\r\n";
// $in .= "Host: www.example.com\r\n";
// $in .= "Connection: Close\r\n\r\n";
$in = '';
$out = '';

// echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
// echo "OK.\n";

// echo "Reading response:\n\n";
while ($out = socket_read ($socket, 2048)) {
    $sql = "SELECT * FROM rfid_tags WHERE hexid = CONV('" .
         substr($out, 0, -1)  . "', 16, 2);";
}
    // echo $out;

// echo "Closing socket...";
socket_close($socket);
// echo "OK.\n\n";

//////////////////////////////////////////////////////////////////////
//
// DB
//
//////////////////////////////////////////////////////////////////////

$cf = file_get_contents('/etc/arduino_log.json');
$config = json_decode($cf);

$db_pi1 = new mysqli($config->{'host'}, $config->{'login'},
                     $config->{'passwd'}, 'pi1');
if(!$db_pi1) {
    echo $db_pi1->lastErrorMsg();
} else {
    echo "\nSQL: " . $sql . "\n";
    $res = $db_pi1->query($sql);
    // echo "Res: " . $res . "\n";
    echo "--------------------------------------------------------------------\n";
    while ($row = $res->fetch_assoc()) {
        echo $row["link"];
    }
}
?>