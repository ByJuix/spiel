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

$weapon = [
    'name' => $charakter->getStat('weapon')->getStat('name'),
    'level' => $charakter->getStat('weapon')->getStat('level'),
    'damagephys' => $charakter->getStat('weapon')->getStat('damage_phys'),
    'damagemag' => $charakter->getStat('weapon')->getStat('damage_mag'),
    'defense' => $charakter->getStat('weapon')->getStat('defense'),
    'type' => $charakter->getStat('weapon')->getStat('type')
];

$armor = [
    'name' => $charakter->getStat('armor')->getStat('name'),
    'level' => $charakter->getStat('armor')->getStat('level'),
    'defensephys' => $charakter->getStat('armor')->getStat('defense_phys'),
    'defensemag' => $charakter->getStat('armor')->getStat('defense_mag'),
    'damage' => $charakter->getStat('armor')->getStat('damage'),
    'type' => $charakter->getStat('armor')->getStat('type')
];

if (isset($_SESSION["enemy"])) {
    $enemy = $_SESSION["enemy"];

    $enemyStats = [
        'name' => $enemy->getStat('name'),
        'maxhealth' => $enemy->getStat('maxhealth'),
        'currentHealth' => $enemy->getStat('currenthealth'),
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
$response = ['stats' => $stats, 'weapon' => $weapon, 'armor' => $armor];
if (isset($enemyStats)) {
    $response['enemyStats'] = $enemyStats;
}

ob_clean();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>