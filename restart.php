<?php
session_start();


$_SESSION['board'] = [];
$_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
$_SESSION['player'] = 0;


$db = include_once 'database.php';
echo $db->get_connection_stats();
if ($db->connect_error) {
    die("Connection failed" . $db->connect_error);
}
else {
    $stmt = $db->prepare('INSERT INTO games VALUES ()');
    $_SESSION['game_id'] = $db->insert_id;
    if ($stmt === false){
        die("statement not prepared" . $db->error);
    }
    else{
        $stmt->execute();
    }
}


header('Location: index.php');

?>