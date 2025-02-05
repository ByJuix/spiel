<?php
namespace FantasyRacism;
include_once "core/classes.php";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Racism</title>
    <style>
        @font-face {
            font-family: "Mountain King";
            src: url(font/MountainKing.ttf);
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
        }
        h1, h2, p {
            margin: 0;
        }
        .box {   
            width: 80%;
            margin: auto;
            transform: translate(-50%, -50%);
            position: absolute;
            top: 50%;
            left: 50%;
        }
        .container {
            background-color: #222;
            padding: 2rem;
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
        .intro {
            text-align: center;
            font-size: 24px;
        }
        .intro img {
            width: 70%;
            margin: auto;
        }
        .intro p {
            font-size: 4rem;
            font-family: "Mountain King", serif;
            font-weight: 400;
            font-style: normal;
            text-transform: uppercase;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="box intro hidden" id="intro">
        <p>Herzlich Willkommen bei</p>
        <p><img src="img/fr-font-white.png" alt="Fantasy Racism"></p>
        <p>Fantasy Racism ist ein offline RPG-Spiel, bei dem du dich frei auf der Map bewegen kannst,</p>
        <p>deinen Charakter leveln und seine Ausruestung verbessern.</p>
        <p>Dein Ziel ist es, so lange wie möglich zu ueberleben und eine hohe Aura zu erreichen.</p>
        <p>Zuerst generieren wir einen Charakter</p>
    </div>
    <script>
        window.onload = function() {
            const intro = document.getElementById('intro');
            const container = document.getElementById('container');
            const lines = intro.getElementsByTagName('p');
            let index = 0;

            function showNextLine() {
                if (index > 0) {
                    lines[index - 1].classList.add('hidden');
                }
                if (index < lines.length) {
                    lines[index].classList.remove('hidden');
                    index++;
                    setTimeout(showNextLine, 5000); // Adjust the delay as needed
                } else {
                    setTimeout(() => {
                        intro.style.display = 'none';
                        container.classList.remove('hidden');
                    }, 0); // Adjust the delay before hiding the intro
                }
            }

            intro.classList.remove('hidden');
            for (let i = 0; i < lines.length; i++) {
                lines[i].classList.add('hidden');
            }
            showNextLine();
        };
    </script>
    <div class="box container hidden" id="container">
        <h1>Dein Charakter</h1>
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
        <button>Start</button>
    </div>
</body>
</html>

<?php
// Zerstoerung des Objekts
unset($charakter);