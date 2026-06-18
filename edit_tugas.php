<?php
session_start();
require_once 'config/connection.php';

$id = $_GET['id'];

$tugas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tasks WHERE id_task='$id'"));
$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-yellow-200 min-h-screen font-sans p-8">

<div class="bg-white border-4 border-black shadow-[8px_8px_0_#000] p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-black mb-5">Edit Tugas</h1>

    <form action="proses_edit_tugas.php" method="POST" class="space-y-4">
        <input type="hidden" name="id_task" value="<?= $tugas['id_task']; ?>">

        <input type="text" name="judul" value="<?= $tugas['judul']; ?>" required class="w-full border-4 border-black p-3">

        <textarea name="deskripsi" class="w-full border-4 border-black p-3"><?= $tugas['deskripsi']; ?></textarea>

        <select name="id_user" class="w-full border-4 border-black p-3">
            <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                <option value="<?= $user['id_user']; ?>" <?= $user['id_user'] == $tugas['id_user'] ? 'selected' : ''; ?>>
                    <?= $user['nama']; ?>
                </option>
            <?php } ?>
        </select>

        <select name="status" class="w-full border-4 border-black p-3">
            <option value="belum mulai" <?= $tugas['status'] == 'belum mulai' ? 'selected' : ''; ?>>Belum Mulai</option>
            <option value="on progress" <?= $tugas['status'] == 'on progress' ? 'selected' : ''; ?>>On Progress</option>
            <option value="selesai" <?= $tugas['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
        </select>

        <input type="date" name="deadline" value="<?= $tugas['deadline']; ?>" class="w-full border-4 border-black p-3">

        <button class="w-full bg-blue-300 border-4 border-black p-3 font-black shadow-[4px_4px_0_#000]">
            Update Tugas
        </button>
    </form>
</div>

</body>
</html>