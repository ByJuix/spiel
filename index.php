<?php
namespace PHPixel;
include_once "core/classes.php";

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
<div class="box intro hidden" id="intro">
    <p>Herzlich Willkommen bei</p>
    <div class="intro-header hidden phpixel-header-text" style="font-size:500px;">
        <p>PHPIXEL</p>
    </div>
    <p>PHPixel ist ein offline RPG-Spiel:</p>
    <p>Erkunde eine frei begehbare Karte...</p>
    <p>Bestreite das Abenteuer!</p>
    <p>Überlebe so lange wie möglich und vernichte deine Feinde!</p>
    <p>Charaktererstellung...</p>
</div>

<script>
window.onload = function() {
    const intro = document.getElementById('intro');
    const container = document.getElementById('container');
    const lines = intro.getElementsByTagName('p');
    const introHeader = document.querySelector('.intro-header'); // Div für PHPIXEL
    let index = 0;

    function showNextLine() {
        if (index > 0) {
            lines[index - 1].classList.add('hidden');
        }

        if (index < lines.length) {
            lines[index].classList.remove('hidden');

            // Prüfen, ob der aktuelle Text "PHPIXEL" ist
            if (lines[index].innerText.trim() === "PHPIXEL") {
                introHeader.classList.remove('hidden');
                introHeader.classList.add('show-sign');
            } else {
                introHeader.classList.remove('show-sign');
                introHeader.classList.add('hidden');
            }

            index++;
            setTimeout(showNextLine, 4000); // Kürzere Verzögerung für schnelleren Ablauf
        } else {
            setTimeout(() => {
                intro.style.display = 'none'; // Intro ausblenden
                container.classList.remove('hidden'); // Spiel starten
            }, 100);
        }
    }

    // Verstecke alle Zeilen am Anfang
    for (let i = 0; i < lines.length; i++) {
        lines[i].classList.add('hidden');
    }

    intro.classList.remove('hidden');
    showNextLine();
};
</script>

    <div class="box container hidden" id="container">
        <h1>Dein Charakter</h1>
        <br>
        <div class="character">
            <div>
                <?php
                    $strength=rand(0,40);
                    $intelligence=40- $strength;
                    $charakter = new Core\Charakter(null, true, 1000, $strength, 20, $intelligence);
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