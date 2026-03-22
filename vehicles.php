<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pojazdy Specjalne</title>
    <link rel="stylesheet" href="vehicles.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Share+Tech+Mono&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="controls">
        <button id="toggle-dark-mode">Tryb ciemny</button>
    </div>

    <div class="container">

        <div class="page-header">
            <div>
                <h1>Pojazdy Specjalne</h1>
                <span class="page-header__sub">— VEHICLE DATABASE —</span>
            </div>
            <a href="gta.php" class="back-btn">◀ Powrót</a>
        </div>

        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'gta');

        $q = "SELECT * FROM pojazdy_specjalne";
        $result = mysqli_query($conn, $q);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-wrap'>";
            echo "<table class='vehicles-table'>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>Nazwa</th><th>Typ</th><th>Opis</th>";
            echo "</tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='cell-id'>" . $row['id'] . "</td>";
                echo "<td class='cell-name'>" . htmlspecialchars($row['nazwa']) . "</td>";
                echo "<td><span class='type-badge'>" . htmlspecialchars($row['typ']) . "</span></td>";
                echo "<td class='cell-opis'>" . htmlspecialchars($row['opis']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        }
        ?>

        <div class="forms-grid">

            <div class="form-panel">
                <div class="form-panel__title">🚗 Dodaj pojazd</div>
                <form method="POST" action="vehicles.php">
                    <div class="field">
                        <label>ID</label>
                        <input type="number" name="id" placeholder="np. 5" required>
                    </div>
                    <div class="field">
                        <label>Nazwa</label>
                        <input type="text" name="nazwa" placeholder="np. Rhino Tank" required>
                    </div>
                    <div class="field">
                        <label>Typ</label>
                        <input type="text" name="typ" placeholder="np. Military">
                    </div>
                    <div class="field">
                        <label>Opis</label>
                        <textarea name="opis" placeholder="Opis pojazdu..."></textarea>
                    </div>
                    <input type="submit" name="insert" value="DODAJ">
                </form>
            </div>

            <div class="form-panel">
                <div class="form-panel__title">✏️ Aktualizuj pojazd</div>
                <form method="POST" action="">
                    <div class="field">
                        <label>ID pojazdu</label>
                        <input type="number" name="id" placeholder="ID pojazdu" required>
                    </div>
                    <div class="field">
                        <label>Nazwa</label>
                        <input type="text" name="nazwa" placeholder="Nowa nazwa">
                    </div>
                    <div class="field">
                        <label>Typ</label>
                        <input type="text" name="typ" placeholder="Nowy typ">
                    </div>
                    <div class="field">
                        <label>Opis</label>
                        <textarea name="opis" placeholder="Nowy opis..."></textarea>
                    </div>
                    <input type="submit" name="update" value="AKTUALIZUJ">
                </form>
            </div>

            <div class="form-panel form-panel--delete">
                <div class="form-panel__title">🗑️ Usuń pojazd</div>
                <form method="POST" action="vehicles.php">
                    <div class="field">
                        <label>ID pojazdu do usunięcia</label>
                        <input type="number" name="id_delete" placeholder="np. 3" required>
                    </div>
                    <input type="submit" name="delete" value="USUŃ" class="btn-delete">
                </form>
            </div>

        </div>

    </div>

    <?php
    if (isset($_POST['insert'])) {
        $id = $_POST['id'];
        $nazwa = $_POST['nazwa'];
        $typ = $_POST['typ'];
        $opis = $_POST['opis'];
        $q4 = "INSERT INTO pojazdy_specjalne (`id`, `nazwa`, `typ`, `opis`) VALUES ('$id', '$nazwa', '$typ', '$opis')";
        mysqli_query($conn, $q4);
        header("Location: vehicles.php");
    }
    if (isset($_POST["update"])) {
        $id = $_POST['id'];
        $nazwa = $_POST['nazwa'];
        $typ = $_POST['typ'];
        $opis = $_POST['opis'];
        $q2 = "UPDATE pojazdy_specjalne SET nazwa='$nazwa', typ='$typ', opis='$opis' WHERE id='$id'";
        mysqli_query($conn, $q2);
        header("Location: vehicles.php");
    }
    if (isset($_POST['delete'])) {
        $id_delete = $_POST['id_delete'];
        $q3 = "DELETE FROM pojazdy_specjalne WHERE id='$id_delete'";
        mysqli_query($conn, $q3);
        header("Location: vehicles.php");
    }
    mysqli_close($conn);
    ?>

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