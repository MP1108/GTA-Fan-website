<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTA Fan Page</title>
    <link rel="stylesheet" href="gta.css">
</head>
<body>

    <div class="preloader" id="preloader">
        <img src="logoG6.png" alt="Logo GTA 6">
        <div class="preloader-bar"></div>
    </div>


    <div class="controls">
        <button id="toggle-dark-mode">Tryb ciemny</button>
    </div>


    <iframe class="video-background"
        src="https://www.youtube.com/embed/QdBZY2fkU-0?autoplay=1&mute=1&controls=0&loop=1&playlist=QdBZY2fkU-0"
        frameborder="0"
        allow="autoplay">
    </iframe>


    <header>
        <img src="logoG5.png" alt="Logo GTA 5">
        <img src="logoG6.png" alt="Logo GTA 6">
    </header>

    <h1>Strona fanowska GTA5 i GTA6</h1>

    <div class="links">
        <a href="weapons.php">
            <span class="icon">🔫</span>
            Broń w GTA 5
        </a>
        <a href="vehicles.php">
            <span class="icon">🚗</span>
            Pojazdy w GTA 5
        </a>
        <a href="heists.php">
            <span class="icon">💰</span>
            Napady w GTA 5
        </a>
        <a href="postacie.php">
            <span class="icon">👤</span>
            Postacie w GTA 5
        </a>
        <a href="chat.php">
            <span class="icon">💬</span>
            Chat z Franklinem
        </a>
    </div>

    <div class="footer">
        <p>GTA Fan Page &mdash; <a href="https://www.rockstargames.com/" target="_blank">Oficjalna strona Rockstar Games</a></p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        setTimeout(() => {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('hidden');
            setTimeout(() => { preloader.style.display = 'none'; }, 800);
        }, 3000);

        const darkModeBtn = document.getElementById('toggle-dark-mode');
        darkModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            darkModeBtn.textContent = document.body.classList.contains('dark-mode') ? 'Tryb jasny' : 'Tryb ciemny';
        });

    });
    </script>
</body>
</html>