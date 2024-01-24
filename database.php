<?php

function get_state() {
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function set_state($state) {
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}

$mysqli = new mysqli('db:33060', 'root', 'root', 'hive');
$mysqli->set_charset("utf8mb4");
return $mysqli;

?>