<?php

session_start();

include_once 'util.php';

$from = $_POST['from'];
$to = $_POST['to'];

$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];
unset($_SESSION['error']);


move($from, $to, $player, $board, $hand, true);
header('Location: index.php');

?>