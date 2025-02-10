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
        p, h1, h2 {
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
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff;
            text-align: center;
            margin: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            z-index: 3;
        }
        .shop > h1 {
            margin-top: 10%;
        }
        .shop > button {
            padding: 1rem 2rem;
            border: none;
            background-color: #333;
            color: #fff;
            font-size: 18px;
            cursor: inherit;
            text-decoration: none;
            text-align: center;
            width: 80%;
            margin: 10% auto 0 auto;
        }
        .shop-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 10% auto 0 auto;
            width: 80%;
        }
        .shop-item { 
            padding: 10px;
            display: inline-block; 
            background-color: #222;
            width: 180px;
        }
        .button { 
            padding: 10px; 
            background-color: #333; 
            border: none;
            color: #fff;
            margin-top: 20px;
            cursor: pointer; 
        }
        .button:hover { 
            background-color: #555; 
        }
        .enemy {
            position: absolute;
            width: 24px;
            height: 24px;
            background-image: url('img/enemy.png');
            background-size: cover;
            background-repeat: no-repeat;
            z-index: 2;
        }
        .enemy-popup {
            display: none;
            position: absolute;
            width: 400px;
            height: 200px;
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff;
            text-align: center;
            margin: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 4;
        }
        .enemy-popup > h1 {
            margin-top: 10%;
        }
        .enemy-popup > button {
            padding: 1rem 2rem;
            border: none;
            background-color: #333;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            width: 80%;
            margin: 10% auto 0 auto;
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
            <h1>Kupfershop</h1>            
            <div class="shop-container">
                <div class="shop-item" id="schwert-container">
                    <h2>Kupferschwert (Level <span id="schwert-level">1</span>)</h2>
                    <img src="img/sword.png" alt="Kupferschwert" width="64" height="64">
                    <p>Preis: <span id="schwert-preis">30</span> Mark</p>
                    <button class="button" onclick="kaufen('schwert')">Upgrade</button>
                </div>
                <div class="shop-item" id="ruestung-container">
                    <h2>Kupferrüstung (Level <span id="ruestung-level">1</span>)</h2>
                    <img src="img/armor.png" alt="Kupferrüstung" width="64" height="64">
                    <p>Preis: <span id="ruestung-preis">50</span> Mark</p>
                    <button class="button" onclick="kaufen('ruestung')">Upgrade</button>
                </div>
                <div class="shop-item" id="bogen-container">
                    <h2>Kupferbogen (Level <span id="bogen-level">1</span>)</h2>
                    <img src="img/bow.png" alt="Kupferbogen" width="64" height="64">
                    <p>Preis: <span id="bogen-preis">40</span> Mark</p>
                    <button class="button" onclick="kaufen('bogen')">Upgrade</button>
                </div>
                <div class="shop-item" id="dolch-container">
                    <h2>Kupferdolch (Level <span id="dolch-level">1</span>)</h2>
                    <img src="img/dagger.png" alt="Kupferdolch" width="64" height="64">
                    <p>Preis: <span id="dolch-preis">25</span> Mark</p>
                    <button class="button" onclick="kaufen('dolch')">Upgrade</button>
                </div>
            </div>
            <button onclick="closePopup()">Close</button>
        </div>
        <div class="enemy-popup" id="enemyPopup">
            <h1>Enemy Encounter!</h1>
            <button onclick="closeEnemyPopup()">Close</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const player = document.getElementById('player');
            const map = document.querySelector('.map');
            const shop = document.querySelector('.shop');
            const enemyPopup = document.getElementById('enemyPopup');
            const step = 2; // Verringerte Schrittweite
            let top = parseInt(window.getComputedStyle(player).top) || 0;
            let left = parseInt(window.getComputedStyle(player).left) || 0;
            const maxTop = map.clientHeight - player.offsetHeight;
            const maxLeft = map.clientWidth - player.offsetWidth;
            let isPopupOpen = false;
            let isEnemyPopupOpen = false;
            let lastEnemy = null;
            let lastSpawnArea = null;
            
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
                if (!isEnemyPopupOpen) {
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
                    checkEnemyCollision();
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
            
            const enemySpawnAreas = [
                { x1: 40, y1: 54, x2: 50, y2: 58, playerX: 44, playerY: 49 },
                { x1: 64, y1: 21, x2: 77, y2: 27, playerX: 71, playerY: 18 },
                { x1: 5, y1: 21, x2: 17, y2: 27, playerX: 11, playerY: 18 }
            ];
            
            function spawnEnemies() {
                const map = document.querySelector('.map');
                enemySpawnAreas.forEach((area, index) => {
                    const enemy = document.createElement('div');
                    enemy.classList.add('enemy');
                    // Speichere den Spawnindex als Data-Attribut
                    enemy.dataset.spawnIndex = index;
                    const x = Math.floor(Math.random() * (area.x2 - area.x1 + 1)) + area.x1;
                    const y = Math.floor(Math.random() * (area.y2 - area.y1 + 1)) + area.y1;
                    enemy.style.left = (x * 10 - 12) + 'px';
                    enemy.style.top = (y * 10 - 12) + 'px';
                    map.appendChild(enemy);
                });
            }
            
            function checkEnemyCollision() {
                if (isEnemyPopupOpen) return; // Überschreibungen vermeiden
                const enemies = document.querySelectorAll('.enemy');
                const playerRect = player.getBoundingClientRect();
                enemies.forEach((enemy) => {
                    const enemyRect = enemy.getBoundingClientRect();
                    const isCollision = Math.abs(playerRect.left - enemyRect.left) <= 10 && Math.abs(playerRect.top - enemyRect.top) <= 10;
                    if (isCollision) {
                        // Lese den gespeicherten Spawnindex aus
                        const spawnIndex = enemy.dataset.spawnIndex;
                        lastEnemy = enemy;
                        lastSpawnArea = enemySpawnAreas[spawnIndex];
                        showEnemyPopup();
                    }
                });
            }

            function showEnemyPopup() {
                enemyPopup.style.display = 'block';
                isEnemyPopupOpen = true;
                for (let key in keys) {
                    keys[key] = false;
                }
            }

            window.closeEnemyPopup = function() {
                enemyPopup.style.display = 'none';
                isEnemyPopupOpen = false;
                if (lastEnemy) {
                    lastEnemy.remove();
                    lastEnemy = null;
                }
                if (lastSpawnArea) {
                    // Set player position to the specific coordinate for the spawn area
                    top = lastSpawnArea.playerY * 10 - player.offsetHeight / 2;
                    left = lastSpawnArea.playerX * 10 - player.offsetWidth / 2;
                    player.style.top = top + 'px';
                    player.style.left = left + 'px';
                    // Update coordinates
                    const coordinates = document.getElementById('coordinates');
                    coordinates.innerText = `(X: ${lastSpawnArea.playerX} | Y: ${lastSpawnArea.playerY})`;
                    lastSpawnArea = null;
                }
            }

            spawnEnemies();
            
            function gameLoop() {
                movePlayer();
                setTimeout(() => requestAnimationFrame(gameLoop), 20); // Verlangsamte Aktualisierungsrate
            }
            
            gameLoop();
        });
    </script>
</body>
</html>