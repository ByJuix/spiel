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
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Prüfe, ob die nötigen Daten vorliegen
if (!$data || !isset($data['item'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültige Anfrage-Daten']);
    exit;
}
$item = $data['item'];

// basis preise
$basePrices = [
    'Kupferschwert' => 30,
    'Kupferrüstung' => 50,
    'Kupferdolch'   => 20,
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

    // Response
    $response['change'] = [
        'item'     => $item,
        'level'    => NULL,
        'newPrice' => $basePrices['Heilungstrank']
    ];

    $itemType = 'Heilungstrank';
} elseif ($item === 'Kupferdolch') {
    $itemType = 'Kupferdolch';
} elseif ($item === 'Kupferschwert') {
    $itemType = 'Kupferschwert';
} elseif ($item === 'Kupferrüstung') {
    $itemType = 'Kupferrüstung';
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültiges Item']);
    exit;
}

// aktuelles item gleich neues item
if ($itemType == $weapon->getStat('name')) {
    // upgrade Waffe

    // typ abfragen
    if ($itemType == 'Kupferschwert') {
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($itemType == 'Kupferdolch') {
        $default_damage_phys = 0;
        $default_damage_mag  = 10;
        $default_defense     = 0;
    }

    $level = $weapon->getStat('level') + 1;
    $cost = $basePrices[$item] + (10 * $level);

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $weapon->setItemAttributes($weapon_name, $weapon_level + 1, $weapon_type, $weapon_damage_phys + $default_damage_phys, $weapon_damage_mag + $default_damage_mag, $weapon_defense + $default_defense);

    // Response
    $response['change'] = [
        'item'     => $item,
        'level'    => $level,
        'newPrice' => $cost + 10
    ];
} elseif ($itemType == $armor->getStat('name')) {
    // upgrade Rüstung

    $default_damage_phys = 0;
    $default_damage_mag  = 0;
    $default_defense     = 10;

    $level = $armor->getStat('level') + 1;
    $cost = $basePrices[$item] + (10 * $level);

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $armor->setItemAttributes($armor_name, $armor_level + 1, $armor_type, $armor_damage_phys + $default_damage_phys, $armor_damage_mag + $default_damage_mag, $armor_defense + $default_defense);

    // Response
    $response['change'] = [
        'item'     => $item,
        'level'    => $level,
        'newPrice' => $cost + 10
    ];
} elseif ($itemType != 'Heilungstrank') {
    // item bisher nicht ausgerüstet
    $charakter->setAttribute('weapon', null);

    if ($itemType == 'Kupferschwert') {
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($itemType == 'Kupferdolch') {
        $default_damage_phys = 0;
        $default_damage_mag  = 10;
        $default_defense     = 0;
    }

    $level = 1;
    $cost = $basePrices[$item];

    // prüfung ob genug geld
    if ($charakter->getStat('money') < $cost) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!']);
        exit;
    }

    // ziehe geld ab
    $charakterMoney -= $cost;
    $charakter->setAttribute('money', $charakterMoney);

    // neue werte setzen
    $_SESSION['charakter']->setAttribute('weapon', new Item(ucfirst($item), $level, $item, $default_damage_phys, $default_damage_mag, $default_defense));

    // Response
    $response['change'] = [
        'item'     => $item,
        'level'    => $level,
        'newPrice' => $cost + 10
    ];
}

// Waffenlevel, falls nicht ausgerüstet
$dolchLevel   = ($weapon->getStat('name') === 'Kupferdolch')   ? $weapon->getStat('level') : 0;
$schwertLevel = ($weapon->getStat('name') === 'Kupferschwert') ? $weapon->getStat('level') : 0;

// shop infos
$response['info'] = [
    'Kupferdolch' => [
        'level' => $dolchLevel,
        'price' => $basePrices['Kupferdolch'] + (10 * $weapon->getStat('level'))
    ],
    'Kupferschwert' => [
        'level' => $schwertLevel,
        'price' => $basePrices['Kupferschwert'] + (10 * $weapon->getStat('level'))
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
header('Content-Type: application/json');
echo json_encode(['change' => $response['change'], 'info' => $response['info']]);
exit;