<?php
namespace FantasyRacism\Core;
include_once "core/classes.php";

session_start();
$charakter = $_SESSION['charakter'];

if (!isset($_SESSION["enemy"])) {
    $_SESSION["enemy"] = new Core\Charakter("Goblin", 100, 10, 5, 5, 5);
}

$attack = $_GET['attack'] ?? NULL;
$block = $_GET['block'] ?? NULL;

$attack->FightRound($attack, $block);


?>