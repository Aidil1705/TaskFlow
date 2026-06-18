<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - TaskFlow</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-cyan-300 min-h-screen flex items-center justify-center font-sans">

<div class="w-[400px] bg-white border-4 border-black shadow-[8px_8px_0px_#000] p-8">
    <h1 class="text-4xl font-black text-center mb-2">TaskFlow</h1>
    <h2 class="text-2xl font-bold mb-5">Registrasi</h2>

    <form action="proses_register.php" method="POST" class="space-y-4">
        <input type="text" name="nama" placeholder="Nama Lengkap" required
               class="w-full border-4 border-black p-3 text-lg">

        <input type="text" name="username" placeholder="Username" required
               class="w-full border-4 border-black p-3 text-lg">

        <input type="password" name="password" placeholder="Password" required
               class="w-full border-4 border-black p-3 text-lg">

        <select name="role" required
                class="w-full border-4 border-black p-3 text-lg bg-white">
            <option value="anggota">Anggota</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit"
                class="w-full bg-lime-300 border-4 border-black p-3 font-black text-lg shadow-[4px_4px_0px_#000] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition">
            DAFTAR
        </button>
    </form>

    <p class="mt-5 font-bold">
        Sudah punya akun?
        <a href="index.php" class="underline">Login</a>
    </p>
</div>

</body>
</html>