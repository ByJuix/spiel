<?php
namespace FantasyRacism\Core;

include_once "classes.php";

session_start();

$charakter = $_SESSION['charakter'];

$stats = [
    'name' => $charakter->getStat('name'),
    'maxhealth' => $charakter->getStat('maxhealth'),
    'currenthealth' => $charakter->getStat('currenthealth'),
    'strength' => $charakter->getStat('strength'),
    'dexterity' => $charakter->getStat('dexterity'),
    'intelligence' => $charakter->getStat('intelligence'),
    'speed' => $charakter->getStat('speed'),
    'armor' => $charakter->getStat('armor'),
    'weapon' => $charakter->getStat('weapon'),
    'color' => $charakter->getStat('color'),
    'money' => $charakter->getStat('money')
];

// Sende ausschließlich JSON zurück
ob_clean();
header('Content-Type: application/json');
echo json_encode(['stats' => $stats]);
exit;
?>