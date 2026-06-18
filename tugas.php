<?php
session_start();
require_once 'config/connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$status = $_GET['status'] ?? '';

if ($status != '') {
    $query = mysqli_query($conn, "
        SELECT tasks.*, users.nama 
        FROM tasks 
        LEFT JOIN users ON tasks.id_user = users.id_user
        WHERE tasks.status = '$status'
        ORDER BY tasks.id_task DESC
    ");
} else {
    $query = mysqli_query($conn, "
        SELECT tasks.*, users.nama 
        FROM tasks 
        LEFT JOIN users ON tasks.id_user = users.id_user
        ORDER BY tasks.id_task DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas - TaskFlow</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-lime-200 min-h-screen font-sans">

<nav class="bg-yellow-300 border-b-4 border-black px-8 py-4 flex justify-between">
    <h1 class="text-2xl font-black">TaskFlow</h1>
    <div class="flex gap-5 font-bold">
        <a href="dashboard.php">Dashboard</a>
        <a href="tugas.php" class="underline">Tugas</a>
        <a href="tambah_tugas.php">Tambah Tugas</a>
        <a href="anggota.php">Anggota</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<main class="p-8">
    <div class="bg-white border-4 border-black shadow-[8px_8px_0_#000] p-6">
        <div class="flex justify-between mb-5">
            <h2 class="text-3xl font-black">Daftar Tugas</h2>
            <a href="tambah_tugas.php" class="bg-cyan-300 border-4 border-black px-4 py-2 font-black shadow-[4px_4px_0_#000]">
                + Tambah
            </a>
        </div>

        <form method="GET" class="mb-5">
            <select name="status" class="border-4 border-black p-3 font-bold">
                <option value="">Semua Status</option>
                <option value="belum mulai">Belum Mulai</option>
                <option value="on progress">On Progress</option>
                <option value="selesai">Selesai</option>
            </select>
            <button class="bg-pink-300 border-4 border-black px-4 py-3 font-black shadow-[4px_4px_0_#000]">
                Filter
            </button>
        </form>

        <table class="w-full border-4 border-black">
            <tr class="bg-red-300">
                <th class="border-4 border-black p-3">No</th>
                <th class="border-4 border-black p-3">Judul</th>
                <th class="border-4 border-black p-3">PIC</th>
                <th class="border-4 border-black p-3">Status</th>
                <th class="border-4 border-black p-3">Deadline</th>
                <th class="border-4 border-black p-3">Aksi</th>
            </tr>

            <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) { ?>
            <tr class="bg-white">
                <td class="border-4 border-black p-3"><?= $no++; ?></td>
                <td class="border-4 border-black p-3 font-bold"><?= $data['judul']; ?></td>
                <td class="border-4 border-black p-3"><?= $data['nama'] ?? 'Belum ditentukan'; ?></td>
                <td class="border-4 border-black p-3"><?= $data['status']; ?></td>
                <td class="border-4 border-black p-3"><?= $data['deadline']; ?></td>
                <td class="border-4 border-black p-3">
                    <a href="detail_tugas.php?id=<?= $data['id_task']; ?>" class="font-black underline">Detail</a> |
                    <a href="edit_tugas.php?id=<?= $data['id_task']; ?>" class="font-black underline">Edit</a> |
                    <a href="hapus_tugas.php?id=<?= $data['id_task']; ?>" onclick="return confirm('Hapus tugas ini?')" class="font-black underline text-red-600">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</main>

</body>
</html>