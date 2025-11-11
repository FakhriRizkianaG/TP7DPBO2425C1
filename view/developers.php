<?php
$users = $user->getAll();
$message = "";

// ===== CRUD HANDLER =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['DevId']);
    $name = trim($_POST['Name']);
    $owner = $_POST['Owner'];
    $status = $_POST['Status'];

    $exists = false;
    foreach ($developer->getAll() as $d) {
        if ($d['DevId'] == $id) $exists = true;
    }

    if (isset($_POST['add'])) {
        if ($exists) {
            $message = "❌ Gagal menambah: Dev ID $id sudah ada!";
        } else {
            $developer->add($name, $owner, $status);
            $message = "✅ Developer berhasil ditambah.";
        }
    } elseif (isset($_POST['update'])) {
        if (!$exists) {
            $message = "❌ Gagal update: Dev ID $id tidak ditemukan.";
        } else {
            $developer->update($id, $name, $owner, $status);
            $message = "✅ Developer berhasil diupdate.";
        }
    } elseif (isset($_POST['delete'])) {
        if (empty($id)) {
            $message = "⚠️ Masukkan Dev ID untuk menghapus.";
        } else {
            $developer->delete($id);
            $message = "🗑️ Developer berhasil dihapus.";
        }
    }
}

$developers = $developer->getAll();
?>

<h2>Developers List</h2>
<p class="message"><?= $message ?></p>
<div class="table-crud-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Owner</th>
            <th>Status</th>
        </tr>
        <?php foreach ($developers as $d): ?>
        <tr onclick='fillDevForm(<?= json_encode($d) ?>)'>
            <td><?= $d['DevId'] ?></td>
            <td><?= $d['Name'] ?></td>
            <td><?= $d['OwnerName'] ?></td>
            <td><?= $d['Status'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="crud-section">
        <h3>CRUD Developer</h3>
        <form method="post">
            <label>Dev ID:</label>
            <input type="number" name="DevId" id="DevId" required><br>

            <label>Name:</label>
            <input type="text" name="Name" id="Name"><br>

            <label>Owner:</label>
            <select name="Owner" id="Owner">
                <option value="">-- Pilih Owner --</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['UserId'] ?>"><?= $u['Name'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Status:</label>
            <select name="Status" id="Status">
                <option value="">-- Pilih Status --</option>
                <option value="Indie">Indie</option>
                <option value="Commercial">Commercial</option>
            </select><br>

            <button name="add">Add</button>
            <button name="update">Update</button>
            <button name="delete">Delete</button>
            <button type="button" onclick="clearDevForm()">Clear Data</button>
        </form>
    </div>
</div>

<script>
function fillDevForm(data) {
    document.getElementById('DevId').value = data.DevId;
    document.getElementById('Name').value = data.Name;
    document.getElementById('Owner').value = data.Owner;
    document.getElementById('Status').value = data.Status;
}
function clearDevForm() {
    document.querySelector("form").reset();
}
</script>
