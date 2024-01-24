<?php
$db = new mysqli('db', 'root', 'root', 'hive');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

echo "Connected successfully";
?>
