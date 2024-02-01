<?php

$GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

function isNeighbour($a, $b): bool
{
    $a = explode(',', $a);
    $b = explode(',', $b);
    foreach ($GLOBALS['OFFSETS'] as $offset) {
        if (intval($a[0]) + $offset[0] == intval($b[0]) && intval($a[1]) + $offset[1] == intval($b[1])) {
            return true;
        }
    }
    return false;
}

function hasNeighBour($a, $board, $omitted = null) {
    foreach (array_keys($board) as $b) {
        if($omitted == $b){
            continue;
        }
        elseif (isNeighbour($a, $b)) return true;
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
    if (!hasNeighBour($to, $board, $from)) {
        return false;
    }
    if (!isNeighbour($from, $to)) { return false;}
    $b = explode(',', $to);
    $common = [];
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $p = intval($b[0]) + $pq[0];
        $q = intval($b[1]) + $pq[1];
        if (isNeighbour($from, $p.",".$q)) $common[] = $p.",".$q;
    }
    if (!isset($board[$common[0]]) and !isset($board[$common[1]]) and !isset($board[$from]) and !isset($board[$to])) {
        return false;
    }
    return min(len($board[$common[0]]), len($board[$common[1]])) <= max(len($board[$from]), len($board[$to]));
}

function isValidPlayPosition($player, $pos, $board): bool
{
    if(hasNeighBour($pos, $board) and neighboursAreSameColor($player, $pos, $board) or $board[$pos][0] == 2 or count($board)<2){
        if(!isset($board[$pos]) or count($board[$pos]) < 1) return true;
    }
    return false;
}

function isOwnTile($player, $pos, $board): bool
{
    if(end($board[$pos])[0] == $player and isset($board[$pos])){
        return true;
    }
    return false;
}

function canPlay($hand, $piece, $player, $board, $to): bool
{
    if (!$hand[$piece])
        $_SESSION['error'] = "Player does not have tile";
    elseif (isset($board[$to]) and count($board[$to]) > 0)
        $_SESSION['error'] = 'Board position is not empty ';
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
    if (isNeighbour($to, $from)){
        return false;
    }
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $result = tilesInBetween($from, $to, $pq, $board);
        if($result === true) return $result;
    }
    return $result;
}

function tilesInBetween($from, $to, $pq, $board): bool
{
    $b = explode(',', $from);
    $p = intval($b[0]) + $pq[0];
    $q = intval($b[1]) + $pq[1];
    $newFrom = $p .",". $q;
    if($newFrom == $to){
        return true;
    }
    elseif(!isset($board[$newFrom])){
        return false;
    }
    return tilesInBetween($newFrom, $to, $pq, $board);
}

function maxDBT($tile1, $tile2){
    $a = explode(',', $tile1);
    $b = explode(',', $tile2);
    return max(abs(intval($a[0])-intval($b[0])), abs(intval($a[1])-intval($b[1])));
}

function callAntMove($to, $board, $from): bool
{
    $maxDistance = maxDBT($to, $from);
    return antMove($to, $board, $from, [], $maxDistance);
}

function antMove($to, $board, $from, $visited, $maxDistance): bool
{
    $visited[] = $to;
    if(slide($board, $from, $to)) return true;
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $b = explode(',', $to);
        $p = intval($b[0]) + $pq[0];
        $q = intval($b[1]) + $pq[1];
        $newTo = $p .",". $q;
        $newDistance = maxDBT($from, $newTo);
        if(slide($board, $newTo, $to) and !array_search($newTo, $visited) and $newDistance<$maxDistance+1){
            if(antMove($newTo, $board, $from, $visited, $maxDistance)) return true;
        }
    }
    return false;
}

function callSpiderMove($to, $board, $from): bool
{
    if(isNeighbour($to, $from)) return false;
    return spiderMove($to, $board, $from, [], 0);
}

function spiderMove($to, $board, $from, $visited, $stepCount): bool
{
    $localBoard = $board;
    $tile = $localBoard[$from];
    $stepCount +=1;
    $visited[] = $from;
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $b = explode(',', $from);
        $p = intval($b[0]) + $pq[0];
        $q = intval($b[1]) + $pq[1];
        $newFrom = $p .",". $q;
        if(slide($localBoard, $from, $newFrom) and !array_search($newFrom, $visited)){
            $localBoard[$newFrom]=$localBoard[$from];
            unset($localBoard[$from]);
            if(slide($localBoard, $newFrom, $to) and $stepCount == 3){
                return true;
            }
            elseif($stepCount > 3)return false;
            elseif(spiderMove($to, $localBoard, $newFrom, $visited, $stepCount)) return true;
        }
    }
    $localBoard[$from]=$tile;
    return false;
}