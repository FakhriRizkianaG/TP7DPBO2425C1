<?php
$developers = $developer->getAll();
$message = "";

// ===== CRUD HANDLER =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['GameId']);
    $name = trim($_POST['Name']);
    $dev = $_POST['Developer'];
    $genre = trim($_POST['Genre']);
    $price = trim($_POST['Price']);

    // Cek ID duplikat
    $exists = false;
    foreach ($game->getAll() as $g) {
        if ($g['GameId'] == $id) $exists = true;
    }

    if (isset($_POST['add'])) {
        if ($exists) {
            $message = "❌ Gagal menambah: Game ID $id sudah ada!";
        } else {
            $game->add($name, $dev, $genre, $price);
            $message = "✅ Game berhasil ditambah.";
        }
    } elseif (isset($_POST['update'])) {
        if (!$exists) {
            $message = "❌ Gagal update: Game ID $id tidak ditemukan.";
        } else {
            $game->update($id, $name, $dev, $genre, $price);
            $message = "✅ Game berhasil diupdate.";
        }
    } elseif (isset($_POST['delete'])) {
        if (empty($id)) {
            $message = "⚠️ Masukkan Game ID untuk menghapus.";
        } else {
            $game->delete($id);
            $message = "🗑️ Game berhasil dihapus.";
        }
    }
}

$games = $game->getAll();
?>

<h2>Games List</h2>
<p class="message"><?= $message ?></p>
<div class="table-crud-container">
    <table id="gameTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Developer</th>
            <th>Genre</th>
            <th>Price</th>
        </tr>
        <?php foreach ($games as $g): ?>
        <tr onclick='fillGameForm(<?= json_encode($g) ?>)'>
            <td><?= $g['GameId'] ?></td>
            <td><?= $g['Name'] ?></td>
            <td><?= $g['DeveloperName'] ?></td>
            <td><?= $g['Genre'] ?></td>
            <td><?= $g['Price'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="crud-section">
        <h3>CRUD Game</h3>
        <form method="post">
            <label>Game ID:</label>
            <input type="number" name="GameId" id="GameId" required><br>

            <label>Name:</label>
            <input type="text" name="Name" id="Name"><br>

            <label>Developer:</label>
            <select name="Developer" id="Developer">
                <option value="">-- Pilih Developer --</option>
                <?php foreach ($developers as $d): ?>
                    <option value="<?= $d['DevId'] ?>"><?= $d['Name'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Genre:</label>
            <input type="text" name="Genre" id="Genre"><br>

            <label>Price:</label>
            <input type="number" name="Price" id="Price"><br>

            <button name="add">Add</button>
            <button name="update">Update</button>
            <button name="delete">Delete</button>
            <button type="button" onclick="clearGameForm()">Clear Data</button>
        </form>
    </div>
</div>

<script>
function fillGameForm(data) {
    document.getElementById('GameId').value = data.GameId;
    document.getElementById('Name').value = data.Name;
    document.getElementById('Developer').value = data.Developer;
    document.getElementById('Genre').value = data.Genre;
    document.getElementById('Price').value = data.Price;
}

function clearGameForm() {
    document.querySelector("form").reset();
}
</script>
