<?php
$db = new mysqli('db', 'root', 'root', 'hive');

if ($db->connect_error) {
    echo "oh no";
    die("Connection failed: " . $db->connect_error);
}
else {
    echo "Connected successfully";
    echo "gabber";
}

echo $db->fetch_all()
?>
