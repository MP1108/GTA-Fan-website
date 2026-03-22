<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postacie GTA</title>
    <link rel="stylesheet" href="postacie.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Share+Tech+Mono&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="controls">
        <button id="toggle-dark-mode">Tryb ciemny</button>
    </div>

    <div class="container">

        <div class="page-header">
            <div>
                <h1>Postacie</h1>
                <span class="page-header__sub">— CHARACTER DATABASE —</span>
            </div>
            <a href="gta.php" class="back-btn">◀ Powrót</a>
        </div>

        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'gta');
        $q = "SELECT * FROM postacie";
        $result = mysqli_query($conn, $q);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-wrap'>";
            echo "<table class='characters-table'>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>Imię</th><th>Nazwisko</th><th>Rodzina</th><th>Opis</th>";
            echo "</tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='cell-id'>" . $row['id'] . "</td>";
                echo "<td class='cell-name'>" . htmlspecialchars($row['imie']) . "</td>";
                echo "<td class='cell-name'>" . htmlspecialchars($row['nazwisko']) . "</td>";
                echo "<td><span class='type-badge'>" . htmlspecialchars($row['rodzina']) . "</span></td>";
                echo "<td class='cell-opis'>" . htmlspecialchars($row['opis']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        }

        if (isset($_POST['insert'])) {
            $id = $_POST['id'];
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $rodzina = $_POST['rodzina'];
            $opis = $_POST['opis'];
            $q4 = "INSERT INTO postacie (`id`, `imie`, `nazwisko`, `rodzina`, `opis`) VALUES ('$id', '$imie', '$nazwisko', '$rodzina', '$opis')";
            mysqli_query($conn, $q4);
            header("Location: postacie.php");
        }

        if (isset($_POST["update"])) {
            $id = $_POST['id'];
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $rodzina = $_POST['rodzina'];
            $opis = $_POST['opis'];
            $q2 = "UPDATE postacie SET imie='$imie', nazwisko='$nazwisko', rodzina='$rodzina', opis='$opis' WHERE id='$id'";
            mysqli_query($conn, $q2);
            header("Location: postacie.php");
        }

        if (isset($_POST['delete'])) {
            $id_delete = $_POST['id_delete'];
            $q3 = "DELETE FROM postacie WHERE id='$id_delete'";
            mysqli_query($conn, $q3);
            header("Location: postacie.php");
        }

        mysqli_close($conn);
        ?>

        <div class="forms-grid">

            <div class="form-panel">
                <div class="form-panel__title">👤 Dodaj postać</div>
                <form method="POST" action="postacie.php">
                    <div class="field">
                        <label>ID</label>
                        <input type="number" name="id" placeholder="np. 4" required>
                    </div>
                    <div class="field">
                        <label>Imię</label>
                        <input type="text" name="imie" placeholder="np. Michael" required>
                    </div>
                    <div class="field">
                        <label>Nazwisko</label>
                        <input type="text" name="nazwisko" placeholder="np. De Santa" required>
                    </div>
                    <div class="field">
                        <label>Rodzina</label>
                        <input type="text" name="rodzina" placeholder="np. De Santa">
                    </div>
                    <div class="field">
                        <label>Opis</label>
                        <textarea name="opis" placeholder="Opis postaci..."></textarea>
                    </div>
                    <input type="submit" name="insert" value="DODAJ">
                </form>
            </div>

            <div class="form-panel">
                <div class="form-panel__title">✏️ Aktualizuj postać</div>
                <form method="POST" action="">
                    <div class="field">
                        <label>ID postaci</label>
                        <input type="number" name="id" placeholder="ID postaci" required>
                    </div>
                    <div class="field">
                        <label>Imię</label>
                        <input type="text" name="imie" placeholder="Nowe imię">
                    </div>
                    <div class="field">
                        <label>Nazwisko</label>
                        <input type="text" name="nazwisko" placeholder="Nowe nazwisko">
                    </div>
                    <div class="field">
                        <label>Rodzina</label>
                        <input type="text" name="rodzina" placeholder="Nowa rodzina">
                    </div>
                    <div class="field">
                        <label>Opis</label>
                        <textarea name="opis" placeholder="Nowy opis..."></textarea>
                    </div>
                    <input type="submit" name="update" value="AKTUALIZUJ">
                </form>
            </div>

            <div class="form-panel form-panel--delete">
                <div class="form-panel__title">🗑️ Usuń postać</div>
                <form method="POST" action="postacie.php">
                    <div class="field">
                        <label>ID postaci do usunięcia</label>
                        <input type="number" name="id_delete" placeholder="np. 2" required>
                    </div>
                    <input type="submit" name="delete" value="USUŃ" class="btn-delete">
                </form>
            </div>

        </div>
    </div>

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