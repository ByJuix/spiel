<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupfershop</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #1e1e1e;
            color: #fff;
            image-rendering: pixelated;
	        cursor: url('cursor.ico'), default;
        }
        .shop-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .shop-item { 
            padding: 10px; 
            border: 3px solid #c47d49; 
            display: inline-block; 
            background-color: #3b2f2f;
            width: 150px;
            text-align: center;
            box-shadow: 4px 4px 0px #8b5a2b;
        }
        .button { 
            padding: 10px; 
            background-color: #c47d49; 
            color: white; 
            border: 2px solid #8b5a2b; 
            cursor: pointer; 
            font-family: 'Press Start 2P', cursive;
        }
        .button:hover {
            background-color: #a05a2c;
        }
        h1, h2, p {
            font-family: 'Press Start 2P', cursive;
        }
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
    </style>
</head>
<body>
    <h1>Kupfershop</h1>
    <p>Dein Guthaben: <span id="guthaben">100</span> Mark</p>
    
    <div class="shop-container">
        <div class="shop-item">
            <h2>Kupferschwert</h2>
            <img src="sword.png" alt="Kupferschwert" width="64" height="64">
            <p>Preis: 30 Mark</p>
            <button class="button" onclick="kaufen(30)">Kaufen</button>
        </div>
        
        <div class="shop-item">
            <h2>Kupferrüstung</h2>
            <img src="armor.png" alt="Kupferrüstung" width="64" height="64">
            <p>Preis: 50 Mark</p>
            <button class="button" onclick="kaufen(50)">Kaufen</button>
        </div>
    </div>
    
    <script>
        let guthaben = 100;
        function kaufen(preis) {
            if (guthaben >= preis) {
                guthaben -= preis;
                document.getElementById("guthaben").innerText = guthaben;
                alert("Kauf erfolgreich!");
            } else {
                alert("Nicht genug Mark!");
            }
        }
    </script>
</body>
</html>
