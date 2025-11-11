<?php
require_once 'class/User.php';
$user = new User();

$message = "";

// ====== CRUD HANDLER ======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['UserId']);
    $name = trim($_POST['Name']);
    $bio = trim($_POST['Bio']);

    $exists = false;
    foreach ($user->getAll() as $u) {
        if ($u['UserId'] == $id) $exists = true;
    }

    // Tambah data
    if (isset($_POST['add'])) {
        if ($exists) {
            $message = "❌ Gagal menambah: User ID $id sudah ada!";
        } else {
            try {
                $user->add($id, $name, $bio);
                $message = "✅ User berhasil ditambah.";
            } catch (PDOException $e) {
                $message = "⚠️ Gagal menambah user: " . $e->getMessage();
            }
        }

    // Update data
    } elseif (isset($_POST['update'])) {
        if (!$exists) {
            $message = "❌ Gagal update: User ID $id tidak ditemukan.";
        } else {
            try {
                $user->update($id, $name, $bio);
                $message = "✅ User berhasil diupdate.";
            } catch (PDOException $e) {
                $message = "⚠️ Gagal update user: " . $e->getMessage();
            }
        }

    // Hapus data
    } elseif (isset($_POST['delete'])) {
        if (empty($id)) {
            $message = "⚠️ Masukkan User ID untuk menghapus.";
        } else {
            try {
                $user->delete($id);
                $message = "🗑️ User berhasil dihapus.";
            } catch (PDOException $e) {
                $message = "⚠️ Gagal menghapus user: " . $e->getMessage();
            }
        }
    }
}

// Ambil data user
$users = $user->getAll();
?>

<h2>Users List</h2>
<p class="message"><?= htmlspecialchars($message) ?></p>

<div class="table-crud-container">
    <!-- ======================= TABEL USER ======================= -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Bio</th>
            <th>Date Joined</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr onclick='fillUserForm(<?= json_encode($u) ?>)'>
            <td><?= htmlspecialchars($u['UserId']) ?></td>
            <td><?= htmlspecialchars($u['Name']) ?></td>
            <td><?= htmlspecialchars($u['Bio']) ?></td>
            <td><?= htmlspecialchars($u['DateJoined']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- ======================= BAGIAN CRUD ======================= -->
    <div class="crud-section">
        <h3>CRUD User</h3>
        <form method="post">
            <label>User ID:</label>
            <input type="number" name="UserId" id="UserId" required><br>

            <label>Name:</label>
            <input type="text" name="Name" id="Name" required><br>

            <label>Bio:</label>
            <textarea name="Bio" id="Bio"></textarea><br>

            <p><em>*Date Joined otomatis saat Add</em></p>

            <button name="add" type="submit">Add</button>
            <button name="update" type="submit">Update</button>
            <button name="delete" type="submit">Delete</button>
            <button type="button" onclick="clearUserForm()">Clear Data</button>
        </form>
    </div>
</div>

<script>
function fillUserForm(data) {
    document.getElementById('UserId').value = data.UserId;
    document.getElementById('Name').value = data.Name;
    document.getElementById('Bio').value = data.Bio;
}

function clearUserForm() {
    document.querySelector("form").reset();
}
</script>
