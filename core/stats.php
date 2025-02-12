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
    'XP' => $charakter->getStat('XP'),
    'money' => $charakter->getStat('money')
];

$weapon = [
    $weaponStat = $charakter->getStat('weapon'),
    'name' => $weaponStat->getStat('name'),
    'level' => $weaponStat->getStat('level'),
    'type' => $weaponStat->getStat('type'),
    'damagephys' => $weaponStat->getStat('damagephys'),
    'damagemag' => $weaponStat->getStat('damagemag'),
    'defense' => $weaponStat->getStat('defense')
];

$armor = [
    $armorStat = $charakter->getStat('armor'),
    'name' => $armorStat->getStat('name'),
    'level' => $armorStat->getStat('level'),
    'type' => $armorStat->getStat('type'),
    'defensephys' => $armorStat->getStat('damagephys'),
    'defensemag' => $armorStat->getStat('damagemag'),
    'defense' => $armorStat->getStat('defense')
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
        'XP' => $enemy->getStat('XP'),
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