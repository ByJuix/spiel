<?php
session_start();
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
            filter: blur(8px);
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
            width: 20px;
            height: 20px;
            background-image: url(img/armor.png);
            background-size: cover;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="foreground">
        <div class="header">
            <div class="sub-header">
                <img src="img/fr-font-white.png" alt="Fantasy Racism">
                <div class="flex-row">
                    <p>Koordinaten:</p>
                    <span id="coordinates">(X: 51 | Y: 36)</span>
                </div>
            </div>
        </div>
        <div class="map">
            <div class="player" style="transform: translate(0px);" id="player"></div>
        </div>
    </div>
    <script>
        document.addEventListener('keydown', function(event) {
            const player = document.getElementById('player');
            const map = document.querySelector('.map');
            const step = 10;
            let top = parseInt(window.getComputedStyle(player).top) || 0;
            let left = parseInt(window.getComputedStyle(player).left) || 0;
            const maxTop = map.clientHeight - player.offsetHeight;
            const maxLeft = map.clientWidth - player.offsetWidth;

            switch(event.key) {
                case 'ArrowUp':
                    if (top - step >= 0) player.style.top = (top - step) + 'px';
                    break;
                case 'ArrowDown':
                    if (top + step <= maxTop + 1) player.style.top = (top + step) + 'px';
                    break;
                case 'ArrowLeft':
                    if (left - step >= 0) player.style.left = (left - step) + 'px';
                    break;
                case 'ArrowRight':
                    if (left + step <= maxLeft + 1) player.style.left = (left + step) + 'px';
                    break;
            }

            // Update coordinates
            const coordinates = document.getElementById('coordinates');
            const x = Math.round((left + player.offsetWidth / 2) / 10);
            const y = Math.round((top + player.offsetHeight / 2) / 10);
            coordinates.innerText = `(X: ${x} | Y: ${y})`;
        });
    </script>
</body>
</html>