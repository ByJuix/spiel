<?php
namespace PHPixel;
include_once "core/classes.php";

session_start();

if (!isset($_SESSION['charakter'])) {
    header("Location: index.php");
    exit;
} else {
    $charakter = $_SESSION['charakter'];
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPixel</title>
    <link rel="stylesheet" href="css/play.css">
</head>
<body>
    <div class="background"></div>
    <div class="foreground">
        <div class="header">
            <div class="sub-header">
                <img src="img/logo.png" alt="PHPIXEL">
                <div class="stat-money">
                    <img src="img/money.png" alt="€">
                    <p>Mark: <span class="player-money"><?php echo $charakter->getStat("money"); ?></span></p>
                </div>
                <div class="flex-row">
                    <p>Koordinaten:</p>
                    <span id="coordinates">(X: 51 | Y: 36)</span>
                </div>
            </div>
        </div>
        <div class="map">
            <div class="player" style="background-image: url('img/character/<?php echo $charakter->getStat("name"); ?>/front.png'); transform: translate(0px);" id="player"></div>
        </div>
        <div class="stats">
            <div class="sub-stats">
                <h2><?php echo $charakter->getStat("name"); ?></h2><br><br>
                <div class="character">
                    <img src="img/character/<?php echo $charakter->getStat("name"); ?>/front.png" alt="<?php echo $charakter->getStat("name"); ?>">
                    <div class="player-stats"><br>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="keybinds">
            <div class="sub-keybinds">
                <h2>Steuerung</h2><br>
                <table>
                    <tr><td>W</td><td>nach Oben laufen</td></tr>
                    <tr><td>A</td><td>nach Links laufen</td></tr>
                    <tr><td>S</td><td>nach Unten laufen</td></tr>
                    <tr><td>D</td><td>nach Rechts laufen</td></tr>
                </table><br><br>
                <h2>Attacken</h2><br>
                <table>
                    <tr><td>1</td><td>physischer Angriff</td></tr>
                    <tr><td>2</td><td>magischer Angriff</td></tr>
                    <tr><td>3</td><td>starker physischer Angriff</td></tr>
                    <tr><td>4</td><td>starker magischer Angriff</td></tr>
                </table><br><br>
                <h2>Verteidigung</h2><br>
                <table>
                    <tr><td>9</td><td>physische Verteidigung</td></tr>
                    <tr><td>0</td><td>magische Verteidigung</td></tr>
                </table>
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
                <div class="shop-item" id="potion-container">
                    <h2>Heilungstrank (300 HP)</h2>
                    <img src="img/potion.png" alt="Heilungstrank" width="64" height="64">
                    <p>Preis: <span id="dolch-preis">10</span> Mark</p>
                    <button class="button" onclick="kaufen('dolch')">Kaufen</button>
                </div>
            </div>
            <button onclick="closePopup()">Close</button>
        </div>
        <div class="enemy-popup" id="enemyPopup">
            <h1>Gegner gesichtet!</h1>
            <div class="enemy-container">
                <div>
                    <h3><?php echo $charakter->getStat("name"); ?></h3>
                    <div class="health-bar-container">
                        <div class="health-bar-fill"></div>
                        <div class="health-text">0 / 0</div>
                    </div>
                    <img src="img/character/<?php echo $charakter->getStat("name"); ?>/front.png" alt="<?php echo $charakter->getStat("name"); ?>">
                    <div class="playerAction"></div>
                </div>
                <div>
                    <h3 id="enemy-name">Gegner</h3>
                    <div class="health-bar-container">
                        <div class="health-bar-fill"></div>
                        <div class="health-text">0 / 0</div>
                    </div>
                    <img src="img/enemy.png" alt="Gegner">
                    <div class="enemyAction"></div>
                </div>
            </div>
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
            let combatActive = false;
            let chosenAttack = null;
            let chosenDefense = null;
            
            const keys = {
                w: false,  // oben
                a: false,  // links
                s: false,  // unten
                d: false   // rechts
            };

            function updateStats() {
                fetch('core/stats.php', { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    console.log("Player stats:", data.stats);
                    console.log("Enemy stats:", data.enemyStats);
                    console.log("Weapon stats:", data.weapon);
                    console.log("Armor stats:", data.armor);
                    
                    // Update der Spieler-Stats
                    const statsDiv = document.querySelector('.player-stats');
                    statsDiv.innerHTML = `
                        <p>Name: ${data.stats.name}</p>
                        <p>Max Health: ${data.stats.maxhealth}</p>
                        <p>Current Health: ${data.stats.currenthealth}</p>
                        <p>Strength: ${data.stats.strength}</p>
                        <p>Dexterity: ${data.stats.dexterity}</p>
                        <p>Intelligence: ${data.stats.intelligence}</p>
                        <p>Color: ${data.stats.color}</p>
                    `;
                    
                    // Update des Money-Stats im Header
                    const moneyDiv = document.querySelector('.player-money');
                    if (moneyDiv) {
                        moneyDiv.textContent = data.stats.money;
                    }
            
                    // Aktualisiere die Health Bar des Spielers im enemyPopup
                    const healthContainers = enemyPopup.querySelectorAll('.health-bar-container');
                    if (healthContainers.length >= 2) {
                        // Erster Container: Spieler
                        const playerHealthBar = healthContainers[0];
                        const playerHealthFill = playerHealthBar.querySelector('.health-bar-fill');
                        const playerHealthText = playerHealthBar.querySelector('.health-text');
                        const currentHealth = data.stats.currenthealth <= 0 ? 0 : data.stats.currenthealth;
                        const maxHealth = data.stats.maxhealth;
                        const healthPercentage = (currentHealth / maxHealth) * 100;
                        playerHealthFill.style.width = `${healthPercentage}%`;
                        playerHealthText.textContent = `${currentHealth} / ${maxHealth}`;
                        
                        // Zweiter Container: Gegner (falls vorhanden)
                        if (data.enemyStats) {
                            const enemyHealthBar = healthContainers[1];
                            const enemyHealthFill = enemyHealthBar.querySelector('.health-bar-fill');
                            const enemyHealthText = enemyHealthBar.querySelector('.health-text');
                            const enemyCurrentHealth = data.enemyStats.currentHealth <= 0 ? 0 : data.enemyStats.currentHealth;
                            const enemyMaxHealth = data.enemyStats.maxhealth;
                            const enemyHealthPercentage = (enemyCurrentHealth / enemyMaxHealth) * 100;
                            enemyHealthFill.style.width = `${enemyHealthPercentage}%`;
                            enemyHealthText.textContent = `${enemyCurrentHealth} / ${enemyMaxHealth}`;
                            
                            // Setze auch den Namen des Gegners
                            const enemyNameP = enemyPopup.querySelector('#enemy-name');
                            enemyNameP.textContent = data.enemyStats.name;
                        }
                    }
                })
                .catch(error => {
                    console.error("Error fetching stats:", error);
                });
            }

            // Stats beim Laden der Seite einmalig abrufen
            updateStats();
            
            document.addEventListener('keydown', function(event) {
                if (!isPopupOpen && keys.hasOwnProperty(event.key)) {
                    keys[event.key] = true;
                }
                if (isEnemyPopupOpen) {
                    const key = event.key;
                    // Für die Angriffe: Tasten "1" bis "4"
                    if ("1234".includes(key) && !chosenAttack) {
                        chosenAttack = key;
                        console.log("Attack selected:", chosenAttack);
                    }
                    // Für die Verteidigung: Tasten "9" und "0"
                    if ("90".includes(key) && !chosenDefense) {
                        chosenDefense = key;
                        console.log("Defense selected:", chosenDefense);
                    }
                    // Wenn beide Werte vorliegen und kein Kampf-Request läuft, ausführen:
                    if (chosenAttack && chosenDefense && !combatActive) {
                        combatActive = true;
                        submitCombatRound(chosenAttack, chosenDefense);
                    }
                }
                // Bei jeder Zahl (0-9) holen wir die aktuellen Stats per AJAX ab
                if (/^\d$/.test(event.key)) {
                    updateStats();
                }
            });
            
            document.addEventListener('keyup', function(event) {
                if (keys.hasOwnProperty(event.key)) {
                    keys[event.key] = false;
                }
            });
            
            function submitCombatRound(attack, defense) {
                // Sende die ausgewählten Werte per AJAX an /core/combat.php
                fetch('core/combat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ attack: attack, defense: defense })
                })
                .then(response => response.json())
                .then(data => {
                    // Nun enthält data.outcome ein Objekt mit der Eigenschaft WinLooseContinue
                    const outcome = data.outcome.WinLooseContinue;
                    console.log("Combat response:", data);
                    
                    // Aktualisiere die Anzeige der vom Gegner ausgeführten Aktionen
                    const enemyActionDiv = enemyPopup.querySelector('.enemyAction');
                    if (enemyActionDiv) {
                        let actionText = "";
                        if (data.outcome.enemyDamageDealt !== null) {
                            actionText += "Gegner verursacht " + data.outcome.enemyDamageDealt + " Schaden. ";
                        }
                        if (data.outcome.enemyBlocked) {
                            actionText += "Gegner blockt den Angriff.";
                        } else {
                            actionText += "Gegner hat nicht geblockt.";
                        }
                        enemyActionDiv.textContent = actionText;
                    }
                    const playerActionDiv = enemyPopup.querySelector('.playerAction');
                    if (playerActionDiv) {
                        let playerActionText = "";
                        if (data.outcome.playerDamageDealt !== null) {
                            playerActionText += "Du verursachst " + data.outcome.playerDamageDealt + " Schaden. ";
                        }
                        if (data.outcome.playerBlocked) {
                            playerActionText += "Du blockst den Angriff.";
                        } else {
                            playerActionText += "Du hast nicht geblockt.";
                        }
                        playerActionDiv.textContent = playerActionText;
                    }
                    
                    if (outcome === "continue") {
                        // Kampf geht weiter – setze Eingaben zurück und informiere den Spieler
                        chosenAttack = null;
                        chosenDefense = null;
                        combatActive = false;
                        enemyPopup.querySelector('h1').innerText = "Neue Runde: Wähle Angriff (1-4) und Verteidigung (9 oder 0)";
                    } else if (outcome === "win") {
                        enemyPopup.querySelector('h1').innerText = "Kampf gewonnen!";
                        // Optionale weitere Aktionen (z. B. Popup schließen)
                    } else if (outcome === "lose") {
                        enemyPopup.querySelector('h1').innerText = "Kampf verloren!";
                        // Weitere Logik, z. B. Spieler ins Shop verweisen
                    }
                })
                .catch(err => {
                    console.error(err);
                    combatActive = false;
                    chosenAttack = null;
                    chosenDefense = null;
                });
            }

            function movePlayer() {
                if (!isEnemyPopupOpen) {
                    // Bewegung mit den Tasten w, a, s, d
                    if (keys.w && top - step >= 0) top -= step;
                    if (keys.s && top + step <= maxTop + 1) top += step;
                    if (keys.a && left - step >= 0) left -= step;
                    if (keys.d && left + step <= maxLeft + 1) left += step;
                
                    player.style.top = top + 'px';
                    player.style.left = left + 'px';
                
                    // Aktualisiere die Koordinatenanzeige
                    const coordinates = document.getElementById('coordinates');
                    const x = Math.round((left + player.offsetWidth / 2) / 10);
                    const y = Math.round((top + player.offsetHeight / 2) / 10);
                    coordinates.innerText = `(X: ${x} | Y: ${y})`;
                
                    // Weitere Logik zur Anzeige von Popups und Kollisionserkennung...
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
                { x1: 41, y1: 53, x2: 49, y2: 56, playerX: 43, playerY: 46 },
                { x1: 66, y1: 21, x2: 70, y2: 27, playerX: 71, playerY: 18 },
                { x1: 71, y1: 21, x2: 75, y2: 27, playerX: 71, playerY: 18 },
                { x1: 5, y1: 20, x2: 10, y2: 25, playerX: 11, playerY: 18 },
                { x1: 11, y1: 20, x2: 16, y2: 25, playerX: 11, playerY: 18 },
                { x1: 17, y1: 32, x2: 21, y2: 38, playerX: 33, playerY: 35 },
                { x1: 22, y1: 32, x2: 26, y2: 38, playerX: 33, playerY: 35 },
                { x1: 4, y1: 63, x2: 9, y2: 67, playerX: 9, playerY: 59 },
                { x1: 10, y1: 63, x2: 14, y2: 65, playerX: 9, playerY: 59 },
                { x1: 63, y1: 39, x2: 67, y2: 46, playerX: 65, playerY: 52 },
                { x1: 68, y1: 39, x2: 73, y2: 46, playerX: 65, playerY: 52 }
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
                // Zuerst den Gegner per AJAX spawnen
                fetch('core/enemy.php', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(enemyData => {
                    // Danach die Statistiken aktualisieren (inkl. des Gegners)
                    updateStats();
                    // Anschließend den Popup anzeigen
                    enemyPopup.style.display = 'block';
                    isEnemyPopupOpen = true;
                    enemyPopup.querySelector('h1').innerText = "Wähle deinen Angriff und deine Verteidigung";
                    for (let key in keys) {
                        keys[key] = false;
                    }
                    // Kampfeinstellungen zurücksetzen
                    chosenAttack = null;
                    chosenDefense = null;
                    combatActive = false;
                })
                .catch(error => {
                    console.error("Error spawning enemy:", error);
                });
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