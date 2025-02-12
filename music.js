document.addEventListener("DOMContentLoaded", function () {
    const audio = new Audio();
    audio.loop = true;

    function playMusic(scene) {
        switch (scene) {
            case "shop":
                audio.src = "music/shop_music.mp3";
                break;
            case "fight":
                audio.src = "music/fight_music.mp3";
                break;
            case "overworld":
                audio.src = "music/overworld_music.mp3";
                break;
            case "castle":
                audio.src = "music/castle_music.mp3";
                break;
            default:
                console.log("Unbekannte Szene");
                return;
        }
        audio.play().catch(error => console.log("Autoplay wurde blockiert: ", error));
    }

    window.playMusic = playMusic; // Funktion global verfügbar machen
});
