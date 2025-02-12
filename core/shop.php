<?php
namespace PHPixel\Core;
include_once "classes.php";
session_start();

// charakter
$charakter = $_SESSION['charakter'];
$charakterMoney = $charakter->getStat('money');

// waffe
$weapon = $_SESSION['charakter']->getStat('weapon');
$weapon_name = $weapon->getStat('name');
$weapon_level = $weapon->getStat('level');
$weapon_type = $weapon->getStat('type');
$weapon_damage_phys = $weapon->getStat('damagephys');
$weapon_damage_mag = $weapon->getStat('damagemag');
$weapon_defense = $weapon->getStat('defense');

// rüstung
$armor = $_SESSION['charakter']->getStat('armor');
$armor_name = $armor->getStat('name');
$armor_level = $armor->getStat('level');
$armor_type = $armor->getStat('type');
$armor_damage_phys = $armor->getStat('damagephys');
$armor_damage_mag = $armor->getStat('damagemag');
$armor_defense = $armor->getStat('defense');

// Anfrage einlesen
if (isset($_GET['item'])) {
    $item = $_GET['item'];
} else {
    $item = null;
}

// basis preise
$basePrices = [
    'Kupferschwert' => 30,
    'Kupferrüstung' => 50,
    'Kupferstab'   => 20,
    'Heilungstrank' => 10
];

// item prüfen
if ($item === 'Heilungstrank') {
    if ($charakter->getStat('money') < $basePrices['Heilungstrank']) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // geld abziehen
    $charakterMoney -= $basePrices['Heilungstrank'];
    $charakter->setAttribute('money', $charakterMoney);
    
    // Charakter heilen
    $charakter->Heal(300);

    $itemType = 'Heilungstrank';
} elseif ($item === 'Kupferstab') {
    $itemType = 'Kupferstab';
} elseif ($item === 'Kupferschwert') {
    $itemType = 'Kupferschwert';
} elseif ($item === 'Kupferrüstung') {
    $itemType = 'Kupferrüstung';
} else {
    $itemType = null;
}

// aktuelles item gleich neues item
if ($itemType == $weapon->getStat('name')) {
    // upgrade Waffe

    // typ abfragen
    if ($itemType == 'Kupferschwert') {
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($itemType == 'Kupferstab') {
        $default_damage_phys = 0;
        $default_damage_mag  = 10;
        $default_defense     = 0;
    }

    $weapon_cost = $basePrices[$item] + (10 * $weapon_level);

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $weapon_cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $weapon_cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $weapon->setItemAttributes($weapon_name, $weapon_level + 1, $weapon_type, $weapon_damage_phys + $default_damage_phys, $weapon_damage_mag + $default_damage_mag, $weapon_defense + $default_defense);

} elseif ($itemType == $armor->getStat('name')) {
    // upgrade Rüstung

    $default_damage_phys = 0;
    $default_damage_mag  = 0;
    $default_defense     = 10;

    $armor_cost = $basePrices[$item] + (10 * $armor_level);

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $armor_cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $armor_cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $armor->setItemAttributes($armor_name, $armor_level + 1, $armor_type, $armor_damage_phys + $default_damage_phys, $armor_damage_mag + $default_damage_mag, $armor_defense + $default_defense);

} elseif ($itemType != 'Heilungstrank' && $itemType != null) {
    // item bisher nicht ausgerüstet => wechsel die Waffe
    $charakter->setAttribute('weapon', null);

    if ($itemType == 'Kupferschwert') {
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($itemType == 'Kupferstab') {
        $default_damage_phys = 0;
        $default_damage_mag  = 10;
        $default_defense     = 0;
    }

    $new_weapon_level = 1;
    $new_weapon_cost = $basePrices[$item];

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $new_weapon_cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $new_weapon_cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $_SESSION['charakter']->setAttribute('equippedweapon', new Item(ucfirst($item), $new_weapon_level, $item, $default_damage_phys, $default_damage_mag, $default_defense));
    // Variable aktualisieren, damit der neue Zustand übernommen wird
    $weapon = $_SESSION['charakter']->getStat('weapon');
}

// Waffenlevel und Preis, falls nicht ausgerüstet
$dolchLevel   = ($weapon->getStat('name') === 'Kupferstab')   ? $weapon->getStat('level') : 0;
$schwertLevel = ($weapon->getStat('name') === 'Kupferschwert') ? $weapon->getStat('level') : 0;

// shop infos
$response['info'] = [
    'Kupferstab' => [
        'level' => $dolchLevel,
        'price' => $basePrices['Kupferstab'] + (10 * $dolchLevel)
    ],
    'Kupferschwert' => [
        'level' => $schwertLevel,
        'price' => $basePrices['Kupferschwert'] + (10 * $schwertLevel)
    ],
    'Kupferrüstung' => [
        'level' => $armor->getStat('level'),
        'price' => $basePrices['Kupferrüstung'] + (10 * $armor->getStat('level'))
    ],
    'Heilungstrank' => [
        'price' => $basePrices['Heilungstrank']
    ]
];

// Response
ob_clean();
header('Content-Type: application/json');
echo json_encode(['shop' => $response['info']]);
exit;