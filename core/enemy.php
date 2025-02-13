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
    $strength=rand(0,40);
    $intelligence=40- $strength;

    if ($get) {
        $_SESSION["enemy"] = new Charakter(null, false, 1400, $strength * 1.1, rand(15,25), $intelligence * 1.1);
    } else {
        $_SESSION["enemy"] = new Charakter(null, false, 1000, $strength, rand(15,25), $intelligence);
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
    'XP'         => $enemy->getStat('XP'),
    'money'         => $enemy->getStat('money')
];

// Sende die JSON-Ausgabe
ob_clean();
header('Content-Type: application/json');
echo json_encode($enemyData);
exit;