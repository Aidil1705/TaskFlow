<?php
session_start();
require_once 'config/connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks"))['total'];
$belum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE status='belum mulai'"))['total'];
$progress = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE status='on progress'"))['total'];
$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE status='selesai'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - TaskFlow</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-orange-200 min-h-screen font-sans">

<nav class="bg-red-400 border-b-4 border-black px-8 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-black">TaskFlow</h1>

    <div class="flex gap-5 font-bold">
        <a href="dashboard.php" class="underline">Dashboard</a>
        <a href="tugas.php">Tugas</a>
        <a href="tambah_tugas.php">Tambah Tugas</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<main class="p-8">
    <div class="bg-white border-4 border-black shadow-[8px_8px_0px_#000] p-6 mb-8">
        <h2 class="text-3xl font-black">Halo, <?= $_SESSION['nama']; ?>!</h2>
        <p class="font-bold mt-2">Selamat datang di sistem manajemen tugas.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white border-4 border-black shadow-[6px_6px_0px_#000] p-6">
            <p class="font-black text-lg">Total Tugas</p>
            <h3 class="text-5xl font-black mt-3"><?= $total; ?></h3>
        </div>

        <div class="bg-yellow-300 border-4 border-black shadow-[6px_6px_0px_#000] p-6">
            <p class="font-black text-lg">Belum Mulai</p>
            <h3 class="text-5xl font-black mt-3"><?= $belum; ?></h3>
        </div>

        <div class="bg-blue-300 border-4 border-black shadow-[6px_6px_0px_#000] p-6">
            <p class="font-black text-lg">On Progress</p>
            <h3 class="text-5xl font-black mt-3"><?= $progress; ?></h3>
        </div>

        <div class="bg-lime-300 border-4 border-black shadow-[6px_6px_0px_#000] p-6">
            <p class="font-black text-lg">Selesai</p>
            <h3 class="text-5xl font-black mt-3"><?= $selesai; ?></h3>
        </div>
    </div>
</main>

</body>
</html>