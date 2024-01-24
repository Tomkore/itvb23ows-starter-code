<?php
$db = new mysqli('db', 'root', 'root', 'hive');

if ($db->connect_error) {
    echo "oh no";
    die("Connection failed: " . $db->connect_error);
}
else {
    echo "Connected successfully";
    echo $db->get_connection_stats();
}
?>
