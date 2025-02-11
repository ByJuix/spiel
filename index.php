<?php
namespace FantasyRacism;
include_once "core/classes.php";

session_start();
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
        html { 
            height: 100%;
            cursor: url('img/cursor.ico'), default;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
        }
        h1, h2, p {
            margin: 0;
        }
        h1 {
            text-align: center;
            font-size: 3rem;
        }
        .box {
            margin: auto;
            transform: translate(-50%, -50%);
            position: absolute;
            top: 50%;
            left: 50%;
        }
        .container {
            width: 50%;
            background-color: #222;
            padding: 2rem;
            font-size: 18px;
            justify-content: center;
            display: flex;
            flex-direction: column;
        }
        .character {
            margin: 20px 0;
        }
        .button {
            padding: 1rem 2rem;
            border: none;
            background-color: #333;
            color: #fff;
            font-size: 18px;
            cursor: inherit;
            text-decoration: none;
            text-align: center;
        }
        .button:hover {
            background-color: #555;
        }
        .intro {
            width: 80%;
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
        .character {
            display: flex;
            gap: 2rem;
            justify-content: center;
        }
        .character img {
            width: 100%;
        }
        .character div {
            width: 30%;
        }
    </style>
</head>
<body>
<div class="box intro hidden" id="intro">
        <p>Herzlich Willkommen bei</p>
        <p><img src="img/logo.png" alt="PHPIXEL"></p>
        <p>PHPIXEL ist ein offline RPG-Spiel, bei dem du dich frei auf der Map bewegen kannst,</p>
        <p>deinen Charakter leveln und seine Ausruestung verbessern.</p>
        <p>Dein Ziel ist es, so lange wie moeglich zu ueberleben und eine hohe Aura zu erreichen.</p>
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
                    setTimeout(showNextLine, 50); // Adjust the delay as needed
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
        <br>
        <div class="character">
            <div>
                <?php
                    $charakter = new Core\Charakter(null, true, 1000, 37, 20, 15, 10);
                    $_SESSION["charakter"] = $charakter;
                    echo "Name: " . $charakter->getStat("name") . "<br>";
                ?>
                <img src="img/character/<?php echo $charakter->getStat("name"); ?>/front.png" alt="<?php echo $charakter->getStat("name"); ?>">
            </div>
            <div>
                <p>Stats:</p>
                <?php
                    echo "Armor: " . $charakter->getStat("armor")->getStat("name") . "<br>";
                    echo "Weapon: " . $charakter->getStat("weapon")->getStat("name") . "<br>";
                    echo "XP: " . $charakter->getStat("color") . "<br>";
                    echo "Money: " . $charakter->getStat("money") . "<br>";
                ?>
            </div>
        </div>
        <br>
        <a class="button" href="play.php">Start</a>
    </div>
</body>
</html>