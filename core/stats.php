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

if (isset($_SESSION["enemy"])) {
    $enemy = $_SESSION["enemy"];

    $enemyStats = [
        'name' => $enemy->getStat('name'),
        'maxhealth' => $enemy->getStat('maxhealth'),
        'currentHealth' => $enemy->getStat('currentHealth'),
        'strength' => $enemy->getStat('strength'),
        'dexterity' => $enemy->getStat('dexterity'),
        'intelligence' => $enemy->getStat('intelligence'),
        'speed' => $enemy->getStat('speed'),
        'armor' => $enemy->getStat('armor'),
        'weapon' => $enemy->getStat('weapon'),
        'color' => $enemy->getStat('color'),
        'money' => $enemy->getStat('money')
    ];
}

// JSON Ausgabe
$response = ['stats' => $stats];
if (isset($enemyStats)) {
    $response['enemyStats'] = $enemyStats;
}

ob_clean();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>