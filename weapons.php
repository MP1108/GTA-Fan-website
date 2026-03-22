<?php
$conn = new mysqli('localhost', 'root', '', 'gta');
if ($conn->connect_error) die("Błąd połączenia");

if (isset($_POST['insert'])) {
    $stmt = $conn->prepare("INSERT INTO bron (nazwa, typ, opis, obrazenia) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $_POST['nazwa'], $_POST['typ'], $_POST['opis'], $_POST['obrazenia']);
    $stmt->execute();
    echo "<script>alert('Dodano broń!');window.location='weapons.php'</script>";
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE bron SET nazwa=?, typ=?, opis=?, obrazenia=? WHERE id=?");
    $stmt->bind_param("sssii", $_POST['nazwa'], $_POST['typ'], $_POST['opis'], $_POST['obrazenia'], $_POST['id']);
    $stmt->execute();
    echo "<script>alert('Zaktualizowano!');window.location='weapons.php'</script>";
}

if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM bron WHERE id=?");
    $stmt->bind_param("i", $_POST['id_delete']);
    $stmt->execute();
    echo "<script>alert('Usunięto!');window.location='weapons.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GTA — Arsenal</title>
<link rel="stylesheet" href="weapons.css">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Share+Tech+Mono&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="page-header">
    <div class="page-header__inner">
        <h1>Arsenal</h1>
        <span class="page-header__sub">— CLASSIFIED WEAPONS DATABASE —</span>
    </div>
    <a href="gta.php" class="back-btn">◀ Powrót</a>
</div>

<div class="search-bar">
    <span class="search-bar__icon">⌕</span>
    <input type="text" id="search" placeholder="SZUKAJ BRONI...">
</div>

<div class="table-container">
    <table id="weapons-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Typ</th>
                <th>DMG</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $q = $conn->query("SELECT * FROM bron");
        while($row = $q->fetch_assoc()):
            $dmg = min(100, max(0, (int)$row['obrazenia']));
            $dmgColor = $dmg > 70 ? '#ff2244' : ($dmg > 40 ? '#ff9900' : '#ffcc00');
        ?>
        <tr>
            <td class="cell-id"><?= $row['id'] ?></td>
            <td class="cell-name"><?= htmlspecialchars($row['nazwa']) ?></td>
            <td class="cell-type"><span class="type-badge"><?= htmlspecialchars($row['typ']) ?></span></td>
            <td class="cell-dmg">
                <div class="dmg-bar">
                    <div class="dmg-bar__fill" style="width:<?= $dmg ?>%;background:<?= $dmgColor ?>;" data-dmg="<?= $dmg ?>"></div>
                </div>
                <span class="dmg-value"><?= $dmg ?></span>
            </td>
            <td class="cell-action">
                <button class="btn-edit" onclick="edit(<?= $row['id'] ?>,'<?= htmlspecialchars($row['nazwa'],ENT_QUOTES) ?>','<?= htmlspecialchars($row['typ'],ENT_QUOTES) ?>',<?= $row['obrazenia'] ?>,`<?= htmlspecialchars($row['opis']) ?>`)">Edytuj</button>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="forms-grid">

    <div class="form-panel">
        <div class="form-panel__title">🔫 Dodaj broń</div>
        <form method="POST">
            <div class="field">
                <label>Nazwa</label>
                <input name="nazwa" placeholder="np. AK-47" required>
            </div>
            <div class="field">
                <label>Typ</label>
                <input name="typ" placeholder="np. Rifle">
            </div>
            <div class="field">
                <label>Obrażenia (0–100)</label>
                <input name="obrazenia" type="number" min="0" max="100" placeholder="75">
            </div>
            <div class="field">
                <label>Opis</label>
                <textarea name="opis" placeholder="Opis broni..."></textarea>
            </div>
            <input type="submit" name="insert" value="DODAJ">
        </form>
    </div>

    <div class="form-panel">
        <div class="form-panel__title">✏️ Edytuj broń</div>
        <form method="POST">
            <div class="field">
                <label>ID</label>
                <input name="id" id="id" readonly>
            </div>
            <div class="field">
                <label>Nazwa</label>
                <input name="nazwa" id="nazwa">
            </div>
            <div class="field">
                <label>Typ</label>
                <input name="typ" id="typ">
            </div>
            <div class="field">
                <label>Obrażenia</label>
                <input name="obrazenia" id="obrazenia" type="number" min="0" max="100">
            </div>
            <div class="field">
                <label>Opis</label>
                <textarea name="opis" id="opis"></textarea>
            </div>
            <input type="submit" name="update" value="ZAPISZ">
        </form>
    </div>

    <div class="form-panel form-panel--delete">
        <div class="form-panel__title">🗑️ Usuń broń</div>
        <form method="POST">
            <div class="field">
                <label>ID broni do usunięcia</label>
                <input name="id_delete" placeholder="np. 3">
            </div>
            <input type="submit" name="delete" value="USUŃ" class="btn-delete">
        </form>
    </div>

</div>

<script>
document.getElementById("search").addEventListener("input", function() {
    const val = this.value.toLowerCase();
    document.querySelectorAll("#weapons-table tbody tr").forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(val) ? "" : "none";
    });
});

function edit(id, nazwa, typ, obrazenia, opis) {
    document.getElementById("id").value = id;
    document.getElementById("nazwa").value = nazwa;
    document.getElementById("typ").value = typ;
    document.getElementById("obrazenia").value = obrazenia;
    document.getElementById("opis").value = opis;
    document.querySelector(".form-panel:nth-child(2)").scrollIntoView({ behavior: 'smooth' });
}

window.addEventListener('load', () => {
    document.querySelectorAll('.dmg-bar__fill').forEach((bar, i) => {
        const target = bar.dataset.dmg;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.transition = 'width 0.6s ease';
            bar.style.width = target + '%';
        }, 100 + i * 60);
    });
});
</script>

</body>
</html>