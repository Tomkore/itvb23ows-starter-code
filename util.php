<?php

$GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

function isNeighbour($a, $b): bool
{
    $a = explode(',', $a);
    $b = explode(',', $b);
    if ($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) return true;
    if ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) return true;
    if ($a[0] + $a[1] == $b[0] + $b[1]) return true;
    return false;
}

function hasNeighBour($a, $board) {
    foreach (array_keys($board) as $b) {
        if (isNeighbour($a, $b) and isset($board[$b])) return true;
    }
    return false;
}

function neighboursAreSameColor($player, $a, $board) {
    foreach ($board as $b => $st) {
        if (!$st) continue;
        $c = $st[count($st) - 1][0];
        if ($c != $player && isNeighbour($a, $b)) return false;
    }
    return true;
}

function len($tile) {
    return $tile ? count($tile) : 0;
}

function slide($board, $from, $to): bool
{
    if (!hasNeighBour($to, $board)) {
        return false;
    }
    if (!isNeighbour($from, $to)) { return false;}
    $b = explode(',', $to);
    $common = [];
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $p = $b[0] + $pq[0];
        $q = $b[1] + $pq[1];
        if (isNeighbour($from, $p.",".$q)) $common[] = $p.",".$q;
    }
    if (!isset($board[$common[0]]) and !isset($board[$common[1]]) and !isset($board[$from]) and !isset($board[$to])) {
        return false;
    }
    return min(len($board[$common[0]]), len($board[$common[1]])) <= max(len($board[$from]), len($board[$to]));
}

function isValidPlayPosition($player, $pos, $board): bool
{
    if(neighboursAreSameColor($player, $pos, $board) or $board[$pos][0] == 2 or count($board)<2){
        return true;
    }
    return false;
}

function isOwnTile($player, $pos, $board): bool
{
    if(end($board[$pos])[0] == $player){
        return true;
    }
    return false;
}

function canPlay($hand, $piece, $player, $board, $to): bool
{
    if (!$hand[$piece])
        $_SESSION['error'] = "Player does not have tile";
    elseif (isset($board[$to]))
        $_SESSION['error'] = 'Board position is not empty';
    elseif (count($board) && !hasNeighBour($to, $board))
        $_SESSION['error'] = "board position has no neighbour";
    elseif (array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board))
        $_SESSION['error'] = "Board position has opposing neighbour";
    elseif (array_sum($hand) <= 8 && $hand['Q'] && $piece != 'Q') {
        $_SESSION['error'] = 'Must play queen bee';
    }
    if(isset($_SESSION['error'])) return false;
    return true;
}

function jump($to, $board, $from): bool
{
    if (!hasNeighBour($to, $board)) {
        return false;
    }
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $result = tilesInBetween($from, $to, $pq, $board);
        if($result) return $result;
    }
    return $result;
}

function tilesInBetween($from, $to, $pq, $board): bool
{
    $b = explode(',', $from);
    $p = $b[0] + $pq[0];
    $q = $b[1] + $pq[1];
    $newFrom = $p .",". $q;
    if($newFrom == $to){
        return true;
    }
    elseif(!isset($board[$newFrom])){
        return false;
    }
    return tilesInBetween($newFrom, $to, $pq, $board);
}