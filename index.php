<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - TaskFlow</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-yellow-300 min-h-screen flex items-center justify-center font-sans">

<div class="w-[360px] bg-white border-4 border-black shadow-[8px_8px_0px_#000] p-8">
    <h1 class="text-4xl font-black text-center mb-2">TaskFlow</h1>
    <h2 class="text-2xl font-bold mb-5">Login</h2>

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="bg-red-300 border-4 border-black p-3 mb-4 font-bold">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php } ?>

    <form action="proses_login.php" method="POST" class="space-y-4">
        <input type="text" name="username" placeholder="Username" required
               class="w-full border-4 border-black p-3 text-lg">

        <input type="password" name="password" placeholder="Password" required
               class="w-full border-4 border-black p-3 text-lg">

        <button type="submit"
                class="w-full bg-red-400 border-4 border-black p-3 font-black text-lg shadow-[4px_4px_0px_#000] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition">
            LOGIN
        </button>
    </form>

    <p class="mt-5 font-bold">
        Belum punya akun?
        <a href="register.php" class="underline">Daftar</a>
    </p>
</div>

</body>
</html>