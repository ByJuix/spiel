<?php
#shop


?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupfershop</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .shop-item { margin: 20px; padding: 10px; border: 1px solid #000; display: inline-block; }
        .button { padding: 10px; background-color: #c47d49; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Kupfershop</h1>
    <p>Dein Guthaben: <span id="guthaben">100</span> Mark</p>
    
    <div class="shop-item">
        <h2>Kupferschwert</h2>
        <p>Preis: 30 Mark</p>
        <button class="button" onclick="kaufen(30)">Kaufen</button>
    </div>
    
    <div class="shop-item">
        <h2>Kupferrüstung</h2>
        <p>Preis: 50 Mark</p>
        <button class="button" onclick="kaufen(50)">Kaufen</button>
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
