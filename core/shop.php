<?php
namespace PHPixel\Core;
include_once "classes.php";
session_start();

$charakter = $_SESSION['charakter'];

// Basispreise definieren
$basePrices = [
    'Kupferschwert' => 30,
    'Kupferrüstung' => 50,
    'Kupferbogen'   => 40,
    'Kupferdolch'   => 25,
    'Heilungstrank' => 10
];

// Initialisiere shop_helper
$_SESSION['shop_helper'] = [
    'money' => $charakter->getStat('money'),
    'items' => [
        'Kupferschwert'  => null,
        'Kupferrüstung'  => null,
        'Kupferbogen'    => null,
        'Kupferdolch'    => null,
        'Heilungstrank'  => null // Wird hier zwar initialisiert, aber nicht als Item verarbeitet
    ]
];

// Lese die eingehenden JSON-Daten
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Prüfe, ob die nötigen Daten vorliegen
if (!$data || !isset($data['item'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültige Anfrage-Daten']);
    exit;
}

$item = $data['item'];

// Sonderfall für Heilungstrank: Erhöhe currentHealth und ziehe Basispreis ab
if ($item === 'Heilungstrank') {
    if ($_SESSION['shop_helper']['money'] < $basePrices['Heilungstrank']) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nicht genügend Mark!' . $_SESSION['shop_helper']['money']]);
        exit;
    }
    $_SESSION['shop_helper']['money'] -= $basePrices['Heilungstrank'];
    $charakter->Heal(300);
    header('Content-Type: application/json');
    $charakter->setAttribute('money', $_SESSION['shop_helper']['money']);
    echo json_encode([
        'healed'        => 300,
        'money'         => $_SESSION['shop_helper']['money'],
        'currenthealth' => $charakter->getStat('currenthealth')
    ]);
    exit;
}

// Prüfe, ob das Item existiert (außer Heilungstrank)
if (!array_key_exists($item, $_SESSION['shop_helper']['items'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültiges Item']);
    exit;
}

// Nun berechnen wir den Kaufpreis serverseitig:
// Wenn das Item noch nicht ausgerüstet ist, gilt der Basispreis; 
// ist es bereits vorhanden, so berechnen wir den Upgradepreis = Basispreis + (10 * (neues Level))
if ($_SESSION['shop_helper']['items'][$item] === null) {
    $level = 1;
    $cost = $basePrices[$item];
    // Standardwerte je nach Item-Typ
    if (in_array($item, ['Kupferschwert', 'Kupferbogen', 'Kupferdolch'])) {
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($item == 'Kupferrüstung') {
        $default_damage_phys = 0;
        $default_damage_mag  = 0;
        $default_defense     = 10;
    } else {
        $default_damage_phys = 0;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    }
} else {
    $currentItem = $charakter->getStat('$item');
    $level = $currentItem->getStat('level') + 1;
    // Upgradepreis berechnet sich als Basispreis + 10 * neues Level
    $cost = $basePrices[$item] + (10 * $level);
}

// Prüfe, ob der Spieler genügend Geld hat
if ($_SESSION['shop_helper']['money'] < $cost) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nicht genügend Mark!'. $_SESSION['shop_helper']['money']]);
    exit;
}

// Ziehe den Preis vom Spieler-Geld ab
$_SESSION['shop_helper']['money'] -= $cost;
$charakter->setAttribute('money', $_SESSION['shop_helper']['money']);

// Für Waffen: Falls ein neues Waffen-Item gekauft wird,
// werden alle anderen Waffen entfernt, sodass nur eins ausgerüstet ist.
if (in_array($item, ['Kupferschwert', 'Kupferbogen', 'Kupferdolch'])) {
    foreach (['Kupferschwert', 'Kupferbogen', 'Kupferdolch'] as $weapon) {
        if ($weapon !== $item) {
            $_SESSION['shop_helper']['items'][$weapon] = null;
        }
    }
}

// Aktualisiere bzw. rüste das Item mithilfe der Item-Klasse
if ($_SESSION['shop_helper']['items'][$item] === null) {
    // Item noch nicht ausgerüstet
    $_SESSION['shop_helper']['items'][$item] = new Item(ucfirst($item), $level, $item, $default_damage_phys, $default_damage_mag, $default_defense);
} else {
    // Item vorhanden – führe ein Upgrade durch
    $currentItem = $charakter->getStat('$item');
    $name  = $currentItem->getStat('name');
    $type  = $currentItem->getStat('type');
    // Erhöhe beispielhaft die Attribute
    $damage_phys = $currentItem->getStat('damagephys') + 5;
    $damage_mag  = $currentItem->getStat('damagemag'); // bleibt unverändert
    $defense     = $currentItem->getStat('defense') + 2;
    $currentItem->setItemAttributes($name, $level, $type, $damage_phys, $damage_mag, $defense);
    $_SESSION['shop_helper']['items'][$item] = $currentItem;
}

// Berechne den neuen Preis für das nächste Upgrade 
// (optional: an den Client zurückliefern, sodass der Shop aktuell bleibt)
$newPrice = $basePrices[$item] + (in_array($item, ['Kupferschwert', 'Kupferbogen', 'Kupferdolch']) ? (10 * ($level + 1)) : (10 * $level));

// Erstelle die Response für das geupgradete Item
$response = [
    'level'    => $level,
    'newPrice' => $newPrice,
    'money'    => $_SESSION['shop_helper']['money']
];
$charakter->setAttribute('money', $_SESSION['shop_helper']['money']);

header('Content-Type: application/json');
echo json_encode($response);
exit;