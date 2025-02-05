<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventar</title>
    <style>
        html { cursor: url('img/cursor.ico'), default; }
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #0f1a17;
            background-image: url('img/inventory.gif');
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
        h1, h2, p { font-family: 'Press Start 2P', cursive; text-shadow: 2px 2px 0px black; }
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
    </style>
</head>
<body>
    <h1>Inventar</h1>
    
    <div class="shop-container">
        <div class="shop-item" id="dolch-container">
            <h2>Kupferdolch (Level <span id="dolch-level">1</span>)</h2>
            <img src="img/dagger.png" alt="Kupferdolch" width="64" height="64">
        </div>

        <div class="shop-item" id="schwert-container">
            <h2>Kupferschwert (Level <span id="schwert-level">2</span>)</h2>
            <img src="img/sword.png" alt="Kupferschwert" width="64" height="64">
        </div>

        <div class="shop-item" id="ruestung-container">
            <h2>Kupferrüstung (Level <span id="ruestung-level">3</span>)</h2>
            <img src="img/armor.png" alt="Kupferrüstung" width="64" height="64">
        </div>
        
        <div class="shop-item" id="bogen-container">
            <h2>Kupferbogen (Level <span id="bogen-level">4</span>)</h2>
            <img src="img/bow.png" alt="Kupferbogen" width="64" height="64">
        </div>
    </div>
</body>
</html>
