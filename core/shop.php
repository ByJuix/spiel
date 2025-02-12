<?php
namespace PHPixel\Core;
include_once "classes.php";
session_start();

// Initialisiere den Spieler, falls noch nicht vorhanden (Beispielwert)
if (!isset($_SESSION['player'])) {
    $_SESSION['player'] = [
        'money' => 100, // Beispielstartgeld
        'items' => [
            'Kupferschwert'  => null,
            'Kupferrüstung'  => null,
            'Kupferbogen'    => null,
            'Kupferdolch'    => null,
            'Heilungstrank'  => null // Wird hier zwar initialisiert, aber nicht als Item verarbeitet
        ]
    ];
}

// Stelle sicher, dass der Charakter verfügbar ist
if (!isset($_SESSION['charakter'])) {
    // Beispielcharakter (Passe die Werte an deine Logik an)
    $_SESSION['charakter'] = new Charakter("Spieler", true, 1000, 10, 10, 10);
}

// Lese die eingehenden JSON-Daten
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Prüfe, ob die nötigen Daten vorliegen
if (!$data || !isset($data['item']) || !isset($data['price'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültige Anfrage-Daten']);
    exit;
}

$item = $data['item'];
$price = intval($data['price']);

// Prüfe, ob das Item existiert (bei Heilungstrank ebenfalls einen Eintrag)
if (!array_key_exists($item, $_SESSION['player']['items'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ungültiges Item']);
    exit;
}

// Prüfe, ob der Spieler genügend Geld hat
if ($_SESSION['player']['money'] < $price) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nicht genügend Mark!']);
    exit;
}

// Ziehe den Preis vom Spieler-Geld ab
$_SESSION['player']['money'] -= $price;

// Sonderfall: Heilungstrank soll nicht als Item verarbeitet werden,
// sondern über die Charakter-Klasse die currentHealth um 300 erhöhen.
if ($item === 'Heilungstrank') {
    $charakter = $_SESSION['charakter'];
    $currentHealth = $charakter->getStat('currenthealth');
    $maxHealth = $charakter->getStat('maxhealth');
    $newHealth = $currentHealth + 300;
    if ($newHealth > $maxHealth) {
        $newHealth = $maxHealth;
    }
    $charakter->setAttribute('currenthealth', $newHealth);
    header('Content-Type: application/json');
    echo json_encode([
        'healed'        => 300,
        'money'         => $_SESSION['player']['money'],
        'currenthealth' => $charakter->getStat('currenthealth')
    ]);
    exit;
}

// Für alle anderen Items wird mithilfe der Item-Klasse gearbeitet

// Aktualisiere bzw. rüste das Item mithilfe der Item-Klasse
if ($_SESSION['player']['items'][$item] === null) {
    // Item noch nicht ausgerüstet: Level 0 wird zu Level 1
    $level = 1;
    // Je nach Item-Typ können die Standardwerte variieren
    if (in_array($item, ['Kupferschwert', 'Kupferbogen', 'Kupferdolch'])) {
        // Beispielwerte für Waffen
        $default_damage_phys = 10;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    } elseif ($item == 'Kupferrüstung') {
        // Beispielwerte für Rüstung
        $default_damage_phys = 0;
        $default_damage_mag  = 0;
        $default_defense     = 10;
    } else {
        $default_damage_phys = 0;
        $default_damage_mag  = 0;
        $default_defense     = 0;
    }
    // Erzeuge ein neues Objekt der Klasse Item; der Name wird hier aus dem Item-Key generiert
    $_SESSION['player']['items'][$item] = new Item(ucfirst($item), $level, $item, $default_damage_phys, $default_damage_mag, $default_defense);
} else {
    // Item bereits vorhanden – führe ein Upgrade durch
    $currentItem = $_SESSION['player']['items'][$item];
    $level = $currentItem->getStat('level') + 1;
    $name  = $currentItem->getStat('name');
    $type  = $currentItem->getStat('type');
    // Erhöhe beispielhaft die Attribute (diese Logik kann beliebig angepasst werden)
    $damage_phys = $currentItem->getStat('damagephys') + 5;
    $damage_mag  = $currentItem->getStat('damagemag'); // bleibt unverändert
    $defense     = $currentItem->getStat('defense') + 2;
    // Aktualisiere die Attribute mittels der setItemAttributes-Methode
    $currentItem->setItemAttributes($name, $level, $type, $damage_phys, $damage_mag, $defense);
    $_SESSION['player']['items'][$item] = $currentItem;
}

// Berechne den neuen Preis (zum Beispiel: aktueller Preis + 10 * aktuelles Level)
$newPrice = $price + (10 * $level);

// Falls es sich um ein Waffen-Item handelt, stelle sicher, dass nur ein Waffen-Item ausgerüstet ist
if (in_array($item, ['Kupferschwert', 'Kupferbogen', 'Kupferdolch'])) {
    foreach (['Kupferschwert', 'Kupferbogen', 'Kupferdolch'] as $weapon) {
        if ($weapon !== $item) {
            $_SESSION['player']['items'][$weapon] = null;
        }
    }
}

// Erstelle die Response für das geupgradete Item
$response = [
    'level'    => $level,
    'newPrice' => $newPrice,
    'money'    => $_SESSION['player']['money']
];

header('Content-Type: application/json');
echo json_encode($response);
exit;