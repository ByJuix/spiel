<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupfershop</title>
    <style>
        html { cursor: url('img/cursor.ico'), default; }
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #0f1a17;
            background-image: url('img/shop_background.png');
            background-size: cover;
            color: #d4d4d4;
            image-rendering: pixelated;
        }
        .shop-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }
        .shop-item { 
            padding: 10px; 
            border: 3px solid #4e7363; 
            display: inline-block; 
            background-color: #1e2b26;
            width: 180px;
            text-align: center;
            box-shadow: 4px 4px 0px #2e4238;
            border-radius: 8px;
        }
        .button { 
            padding: 10px; 
            background-color: #4e7363; 
            color: white; 
            border: 2px solid #2e4238; 
            cursor: pointer; 
            font-family: 'Press Start 2P', cursive;
            border-radius: 4px;
        }
        .button:hover { background-color: #3a5c4f; }
        h1, h2, p { font-family: 'Press Start 2P', cursive; text-shadow: 2px 2px 0px black; }
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
    </style>
</head>
<body>
    <h1>Kupfershop</h1>
    <p>Dein Guthaben: <span id="guthaben">100</span> Mark</p>
    
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
    
    <script>
        let guthaben = 100;
        let shopItems = {
            schwert: { preis: 30, level: 1 },
            ruestung: { preis: 50, level: 1 },
            bogen: { preis: 40, level: 1 },
            dolch: { preis: 25, level: 1 }
        };
        
        function kaufen(item) {
            if (shopItems[item].level >= 5) {
                alert("Maximales Level erreicht!");
                return;
            }
            
            let preis = shopItems[item].preis;
            if (guthaben >= preis) {
                guthaben -= preis;
                shopItems[item].level++;
                shopItems[item].preis += 20;
                
                document.getElementById("guthaben").innerText = guthaben;
                document.getElementById(`${item}-level`).innerText = shopItems[item].level;
                document.getElementById(`${item}-preis`).innerText = shopItems[item].preis;
                
                alert("Upgrade erfolgreich!");
            } else {
                alert("Nicht genug Mark!");
            }
        }
    </script>
</body>
</html>