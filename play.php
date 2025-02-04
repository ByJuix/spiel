<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOLL</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .map {
            position: relative;
            width: 1280px;
            height: 720px;
            background: url('img/bg.png') no-repeat center center;
            background-size: cover;
        }
        .content {
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            color: white;
            padding: 10px;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .player {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: red;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="content">
        <img src="/img/" alt="Fantasy Racism">
        <p>Koordinaten</p>
        <div id="coordinates">(X: 64 | Y: 36)</div>
    </div>
    <div class="map">
        <div class="player" id="player"></div>
    </div>
    <script>
        document.addEventListener('keydown', function(event) {
            const player = document.getElementById('player');
            const map = document.querySelector('.map');
            const step = 10;
            let top = parseInt(window.getComputedStyle(player).top);
            let left = parseInt(window.getComputedStyle(player).left);
            const maxTop = map.clientHeight - player.offsetHeight;
            const maxLeft = map.clientWidth - player.offsetWidth;

            switch(event.key) {
                case 'ArrowUp':
                    if (top - step >= 4) player.style.top = (top - step) + 'px';
                    break;
                case 'ArrowDown':
                    if (top + step <= maxTop) player.style.top = (top + step) + 'px';
                    break;
                case 'ArrowLeft':
                    if (left - step >= 1) player.style.left = (left - step) + 'px';
                    break;
                case 'ArrowRight':
                    if (left + step <= maxLeft) player.style.left = (left + step) + 'px';
                    break;
            }

            // Update coordinates
            const coordinates = document.getElementById('coordinates');
            const x = Math.round((parseInt(player.style.left) + 5) / 10 - 1);
            const y = Math.round((parseInt(player.style.top) + 5) / 10 - 1);
            coordinates.innerText = `(X: ${x} | Y: ${y})`;
        });

        // Center the player initially
        window.onload = function() {
            const player = document.getElementById('player');
            player.style.top = '50%';
            player.style.left = '50%';
        };
    </script>
</body>
</html>