<?php
namespace FantasyRacism;
include_once "core/classes.php";

session_start();
$charakter = $_SESSION['charakter'];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Racism</title>
    <style>
        html { 
            height: 100%;
            cursor: url('img/cursor.ico'), default;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #000;
        }
        .background {
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            background-image: url('img/shop_background.png');
            filter: blur(3px);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .foreground {
            z-index: 1;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        p {
            margin: 0;
        }
        .map {
            position: relative;
            width: 1000px;
            height: 700px;
            background: url('img/map.png') no-repeat center center;
            background-size: cover;
            margin: auto;
            top: 50%;
            transform: translate(0,-50%);
            z-index: 1;
        }
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .header img {
            width: 200px;
        }
        .sub-header {
            margin: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .flex-row{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .player {
            position: absolute;
            width: 24px;
            height: 24px;
            background-image: url('img/character/<?php echo $charakter->getStat("name"); ?>/front.png');
            background-size: cover;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        .stats {
            position: absolute;
            width: 200px;
            height: 700px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            left: 0;
            transform: translate(0, -50%);
            top: 50%;
        }
        .sub-stats {
            margin: 10px 20px;
        }
        .character img {
            width: 100%;
            margin: auto;
        }
        .shop{
            display: none;
            position: absolute;
            width: 1000px;
            height: 700px;
            background-color: rgba(0, 0, 0, 0.8);
            margin: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            z-index: 3;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="foreground">
        <div class="header">
            <div class="sub-header">
                <img src="img/fr-font-white.png" alt="Fantasy Racism">
                <div>
                    <?php
                        echo "WICHTIGER STAT HIER";
                    ?>
                </div>
                <div class="flex-row">
                    <p>Koordinaten:</p>
                    <span id="coordinates">(X: 51 | Y: 36)</span>
                </div>
            </div>
        </div>
        <div class="map">
            <div class="player" style="transform: translate(0px);" id="player"></div>
        </div>
        <div class="stats">
            <div class="sub-stats">
                <h2><?php echo $charakter->getStat("name"); ?></h2>
                <div class="character">
                    <img src="img/character/<?php echo $charakter->getStat("name"); ?>/front.png" alt="<?php echo $charakter->getStat("name"); ?>">
                    <div>
                        <p>Leben: <?php echo $charakter->getStat("maxhealth"); ?></p>
                        <p>Stärke: <?php echo $charakter->getStat("strength"); ?></p>
                        <p>Geschwindigkeit: <?php echo $charakter->getStat("speed"); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="shop">
            <button onclick="closePopup()">Close</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const player = document.getElementById('player');
            const map = document.querySelector('.map');
            const shop = document.querySelector('.shop');
            const step = 2; // Verringerte Schrittweite
            let top = parseInt(window.getComputedStyle(player).top) || 0;
            let left = parseInt(window.getComputedStyle(player).left) || 0;
            const maxTop = map.clientHeight - player.offsetHeight;
            const maxLeft = map.clientWidth - player.offsetWidth;
            let isPopupOpen = false;
            
            const keys = {
                ArrowUp: false,
                ArrowDown: false,
                ArrowLeft: false,
                ArrowRight: false
            };
            
            document.addEventListener('keydown', function(event) {
                if (!isPopupOpen && keys.hasOwnProperty(event.key)) {
                    keys[event.key] = true;
                }
            });
            
            document.addEventListener('keyup', function(event) {
                if (keys.hasOwnProperty(event.key)) {
                    keys[event.key] = false;
                }
            });
            
            function movePlayer() {
                if (keys.ArrowUp && top - step >= 0) top -= step;
                if (keys.ArrowDown && top + step <= maxTop + 1) top += step;
                if (keys.ArrowLeft && left - step >= 0) left -= step;
                if (keys.ArrowRight && left + step <= maxLeft + 1) left += step;
            
                player.style.top = top + 'px';
                player.style.left = left + 'px';
            
                // Update coordinates
                const coordinates = document.getElementById('coordinates');
                const x = Math.round((left + player.offsetWidth / 2) / 10);
                const y = Math.round((top + player.offsetHeight / 2) / 10);
                coordinates.innerText = `(X: ${x} | Y: ${y})`;
            
                // Check for popup condition
                if (x >= 15 && x <= 18 && y >= 9 && y <= 10) {
                    showPopup();
                }
            }
            
            function showPopup() {
                // Display the shop
                shop.style.display = 'block';
                // Disable movement
                isPopupOpen = true;
                // Reset keys
                for (let key in keys) {
                    keys[key] = false;
                }
                // Set player position to X:14 Y:12
                top = 12 * 10 - player.offsetHeight / 2;
                left = 14 * 10 - player.offsetWidth / 2;
                player.style.top = top + 'px';
                player.style.left = left + 'px';
                // Update coordinates
                const coordinates = document.getElementById('coordinates');
                coordinates.innerText = `(X: 14 | Y: 12)`;
            }
            
            // closePopup als globale Funktion verfügbar machen und im selben Scope definieren
            window.closePopup = function() {
                // Hide the shop
                shop.style.display = 'none';
                // Enable movement
                isPopupOpen = false;
            }
            
            function gameLoop() {
                movePlayer();
                setTimeout(() => requestAnimationFrame(gameLoop), 20); // Verlangsamte Aktualisierungsrate
            }
            
            gameLoop();
        });
    </script>
</body>
</html>