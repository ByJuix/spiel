<?php
namespace PHPixel;
include_once "core/classes.php";

session_start();
session_destroy();
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPixel</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="box">
    <h1>Game Over</h1><br>
    <p>Dein Charakter ist gestorben.</p><br>
    <p>Willst du nochmal spielen?</p><br><br><br>
    <a class="button" href="index.php">Neues Spiel</a>
</div>
</body>
</html>