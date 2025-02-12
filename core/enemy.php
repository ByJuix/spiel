<?php
namespace PHPixel\Core;

include_once "classes.php";

session_start();

$get = isset($_GET['boss']) && $_GET['boss'] == 'true' ? true : false;

// Falls der boss-Parameter übergeben wird, erzwinge ein Neuspaunen
if (isset($_GET['boss'])) {
    unset($_SESSION["enemy"]);
}

if (isset($_SESSION["enemy"]) && $_SESSION["enemy"]->getStat('currenthealth') < 1) {
    unset($_SESSION["enemy"]);
}

if (!isset($_SESSION["enemy"])) {
    if ($get) {
        $_SESSION["enemy"] = new Charakter(null, false, 3000, 50, 5, 5);
    } else {
        $_SESSION["enemy"] = new Charakter(null, false, 1000, 10, 5, 5);
    }
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