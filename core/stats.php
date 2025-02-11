<?php
namespace PHPixel\Core;

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

if (isset($_SESSION["enemy"]) && $_SESSION["enemy"]->getStat('currentHealth') < 1) {
    unset($_SESSION["enemy"]);
}
exit;
?>