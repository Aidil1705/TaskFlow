<?php
session_start();
require_once 'config/connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    header("Location: dashboard.php");
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: index.php");
}