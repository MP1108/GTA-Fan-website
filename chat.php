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
    <title>Chat z Franklinem</title>
    <link rel="stylesheet" href="chat.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Share+Tech+Mono&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="controls">
        <button id="toggle-dark-mode">Tryb ciemny</button>
        <a href="gta.php" class="back-btn">◀ Powrót</a>
    </div>

    <div id="container">

        <div class="chat-header">
            <div class="chat-header__avatar">
                <img src="franklin.png" alt="Franklin" onerror="this.style.display='none'">
                <div class="avatar-placeholder">F</div>
            </div>
            <div class="chat-header__info">
                <h1>Franklin Clinton</h1>
                <span class="status"><span class="status__dot"></span>Online</span>
            </div>
        </div>

        <div id="chat"></div>

        <div id="input-area">
            <input type="text" id="wiadomosc" placeholder="Wpisz wiadomość..." onkeydown="if(event.key==='Enter') wyslij()">
            <button class="btn-send" onclick="wyslij()">Wyślij</button>
            <button class="btn-franklin" onclick="generuj()">Odpowiedź Franklina</button>
        </div>

    </div>

    <script src="script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeBtn = document.getElementById('toggle-dark-mode');
        darkModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            darkModeBtn.textContent = document.body.classList.contains('dark-mode') ? 'Tryb jasny' : 'Tryb ciemny';
        });
    });
    </script>
</body>
</html>