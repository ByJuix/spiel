<?php
namespace FantasyRacism\Core;

include_once "classes.php";

session_start();

$charakter = $_SESSION['charakter'];

if (!isset($_SESSION["enemy"])) {
    $_SESSION["enemy"] = new Charakter(false, 100, 10, 5, 5, 5); // enemy muss schon bevor der Kampf beginnt erstellt werden
}
if (!isset($_SESSION['fight'])) {
    $_SESSION['fight'] = new Fight($charakter, $_SESSION["enemy"]);
    $fight = $_SESSION['fight'];
} else {
    $fight = $_SESSION['fight'];
}

// Lese die JSON-Daten ein
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$attackKey = isset($data['attack']) ? $data['attack'] : "1";
$defenseKey = isset($data['defense']) ? $data['defense'] : "9";

// Mapping der Tastaturwerte
switch ($attackKey) {
    case "1": $playerAttack = "phys"; break;
    case "2": $playerAttack = "mag"; break;
    case "3": $playerAttack = "physStrong"; break;
    case "4": $playerAttack = "magStrong"; break;
    default:  $playerAttack = "phys"; break;
}

switch ($defenseKey) {
    case "9": $playerDefense = "phys"; break;
    case "0": $playerDefense = "mag"; break;
    default:  $playerDefense = "phys"; break;
}

$outcome = $fight->FightRound($playerAttack, $playerDefense);

// Sende ausschließlich JSON zurück
ob_clean();
header('Content-Type: application/json');
echo json_encode(['outcome' => $outcome]);
exit;
?>