<?php
session_start();
require_once 'config/connection.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT tasks.*, users.nama 
    FROM tasks 
    LEFT JOIN users ON tasks.id_user = users.id_user
    WHERE tasks.id_task = '$id'
");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tugas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-purple-200 min-h-screen font-sans p-8">

<div class="bg-white border-4 border-black shadow-[8px_8px_0_#000] p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-black mb-5">Detail Tugas</h1>

    <p><b>Judul:</b> <?= $data['judul']; ?></p>
    <p><b>Deskripsi:</b> <?= $data['deskripsi']; ?></p>
    <p><b>PIC:</b> <?= $data['nama'] ?? 'Belum ditentukan'; ?></p>
    <p><b>Status:</b> <?= $data['status']; ?></p>
    <p><b>Deadline:</b> <?= $data['deadline']; ?></p>

    <a href="tugas.php" class="inline-block mt-5 bg-yellow-300 border-4 border-black px-4 py-2 font-black shadow-[4px_4px_0_#000]">
        Kembali
    </a>
</div>

</body>
</html>