<?php
session_start();
require_once 'config/connection.php';

$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$id_user = $_POST['id_user'];
$status = $_POST['status'];
$deadline = $_POST['deadline'];

$query = "INSERT INTO tasks (judul, deskripsi, id_user, status, deadline)
          VALUES ('$judul', '$deskripsi', '$id_user', '$status', '$deadline')";

mysqli_query($conn, $query);

header("Location: tugas.php");
exit;