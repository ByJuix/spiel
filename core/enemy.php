<?php
namespace FantasyRacism\Core;

include_once "classes.php";

session_start();

if (!isset($_SESSION["enemy"])) {
    $_SESSION["enemy"] = new Charakter(false, 100, 10, 5, 5, 5);
}

$enemy = $_SESSION["enemy"];
// Erstelle ein Array mit den benötigten Enemy-Statistiken
$enemyData = [
    'name'          => $enemy->getStat('name'),
    'maxhealth'     => $enemy->getStat('maxhealth'),
    'currenthealth' => $enemy->getStat('currenthealth'),
    'strength'      => $enemy->getStat('strength'),
    'dexterity'     => $enemy->getStat('dexterity'),
    'intelligence'  => $enemy->getStat('intelligence'),
    'speed'         => $enemy->getStat('speed'),
    'armor'         => $enemy->getStat('armor'),
    'weapon'        => $enemy->getStat('weapon'),
    'color'         => $enemy->getStat('color'),
    'money'         => $enemy->getStat('money')
];

// Sende die JSON-Ausgabe
ob_clean();
header('Content-Type: application/json');
echo json_encode($enemyData);
exit;