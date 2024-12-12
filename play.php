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
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('img/bg.png') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
        }
        .content {
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            color: white;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
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
    <div class="background"></div>
    <div class="content">
        <h1>Koordinaten</h1>
        <div id="coordinates">(50, 50)</div>
    </div>
    <div class="player" id="player"></div>
    <script>
        document.addEventListener('keydown', function(event) {
            const player = document.getElementById('player');
            const step = 10;
            let top = parseInt(window.getComputedStyle(player).top);
            let left = parseInt(window.getComputedStyle(player).left);
            const maxTop = window.innerHeight - player.offsetHeight;
            const maxLeft = window.innerWidth - player.offsetWidth;

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
            const x = Math.round((parseInt(player.style.left) + 5) / 10);
            const y = Math.round((parseInt(player.style.top) + 5) / 10);
            coordinates.innerText = `Coordinates: (${x}, ${y})`;
        });
    </script>
</body>
</html>