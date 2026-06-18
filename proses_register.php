<?php
session_start();
require_once 'config/connection.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$query = "INSERT INTO users (nama, username, password, role) 
          VALUES ('$nama', '$username', '$password', '$role')";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Registrasi gagal: " . mysqli_error($conn);
}