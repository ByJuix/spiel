<?php
namespace FantasyRacism;
include_once "core/classes.php";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charakter Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .character {
            margin: 20px 0;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Charakter Generator</h1>
        <div>
            <?php
                $charakter = new Core\Charakter(null, 1000, 37, 20, 15, 10);
                echo "Name: " . $charakter->getStat("name") . "<br>";
                echo "Health: " . $charakter->getStat("maxhealth") . "<br>";
                echo "Strength: " . $charakter->getStat("strength") . "<br>";
                echo "Dexterity: " . $charakter->getStat("dexterity") . "<br>";
                echo "Intelligence: " . $charakter->getStat("intelligence") . "<br>";
                echo "Speed: " . $charakter->getStat("speed") . "<br>";
                echo "Armor: " . $charakter->getStat("armor")->getStat("name") . "<br>";
                echo "Weapon: " . $charakter->getStat("weapon")->getStat("name") . "<br>";
                echo "Color: " . $charakter->getStat("color") . "<br>";
            ?>
        </div>
        <button>Generieren</button>
        <button>Speichern</button>
    </div>
</body>
</html>

<?php
// Zerstoerung des Objekts
unset($charakter);