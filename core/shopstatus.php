<?php
namespace PHPixel\Core;
include_once "classes.php";
session_start();

// Initialisiere den Spieler, falls noch nicht vorhanden:
if (!isset($_SESSION['player'])) {
    $_SESSION['player'] = [
        'money' => 100, // Beispielstartgeld
        'items' => [
            'Kupferschwert'  => null,
            'Kupferrüstung'  => null,
            'Kupferbogen'    => null,
            'Kupferdolch'    => null,
            'Heilungstrank'  => null
        ]
    ];
}

// Definiere Basispreise für alle Items
$basePrices = [
    'Kupferschwert' => 30,
    'Kupferrüstung' => 50,
    'Kupferbogen'   => 40,
    'Kupferdolch'   => 25,
    'Heilungstrank' => 10
];

$shopData = [];

// Für Waffen und Rüstung: Wir benutzen immer die Daten aus dem Charakter,
// unabhängig vom Session-Eintrag im Spieler-Array.
$weaponNames = ["Kupferschwert", "Kupferbogen", "Kupferdolch"];
$armorName   = "Kupferrüstung";

foreach (['Kupferschwert', 'Kupferrüstung', 'Kupferbogen', 'Kupferdolch', 'Heilungstrank'] as $itemName) {
    if ($itemName === "Heilungstrank") {
        // Für den Heilungstrank spielt das Level keine Rolle
        $level = "-";
        $price = $basePrices[$itemName];
    } elseif (in_array($itemName, $weaponNames)) {
        if (isset($_SESSION['charakter'])) {
            $charakter      = $_SESSION['charakter'];
            $equippedWeapon = $charakter->getStat('weapon'); // Erwartet ein Item-Objekt
            if ($equippedWeapon && $equippedWeapon->getStat('name') === $itemName) {
                $level = $equippedWeapon->getStat('level');
                $price = $basePrices[$itemName] + (10 * $level);
            } else {
                $level = 0;
                $price = $basePrices[$itemName];
            }
        } else {
            $level = 0;
            $price = $basePrices[$itemName];
        }
    } elseif ($itemName === $armorName) {
        if (isset($_SESSION['charakter'])) {
            $charakter     = $_SESSION['charakter'];
            $equippedArmor = $charakter->getStat('armor'); // Erwartet ein Item-Objekt
            if ($equippedArmor && $equippedArmor->getStat('name') === $itemName) {
                $level = $equippedArmor->getStat('level');
                $price = $basePrices[$itemName] + (10 * $level);
            } else {
                $level = 0;
                $price = $basePrices[$itemName];
            }
        } else {
            $level = 0;
            $price = $basePrices[$itemName];
        }
    } else {
        // Falls weitere Items hinzukommen, Standard:
        $level = 0;
        $price = 0;
    }
    
    $shopData[$itemName] = ['level' => $level, 'price' => $price];
}

header('Content-Type: application/json');
echo json_encode(['items' => $shopData]);