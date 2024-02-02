<?php

session_start();

include_once 'util.php';

$from = $_POST['from'];
$to = $_POST['to'];

$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];
unset($_SESSION['error']);


if(move($from, $to, $player, $board, $hand)) {
    $_SESSION['player'] = 1 - $_SESSION['player'];
    $db = include 'database.php';
    $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "move", ?, ?, ?, ?)');
    $stmt->bind_param('issis', $_SESSION['game_id'], $from, $to, $_SESSION['last_move'], get_state());
    $stmt->execute();
    $_SESSION['last_move'] = $db->insert_id;
};
header('Location: index.php');

?>