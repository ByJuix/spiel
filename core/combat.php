<?php
namespace FantasyRacism\Core;
include_once "core/classes.php";

session_start();
$charakter = $_SESSION['charakter'];

if (!isset($_SESSION["enemy"])) {
    $_SESSION["enemy"] = new Core\Charakter("Goblin", 100, 10, 5, 5, 5);
}

$action = $_GET['action'] ?? NULL;

switch ($action) {
    case 'attack':
        $attack->FightRound();
        break;
    case 'block':

        break;
    default:
        $attack = new Core\Fight($charakter, $_SESSION["enemy"]);
        json_encode($_SESSION["enemy"]);
        break;
}
?>