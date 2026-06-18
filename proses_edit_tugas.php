<?php
session_start();
require_once 'config/connection.php';

$id_task = $_POST['id_task'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$id_user = $_POST['id_user'];
$status = $_POST['status'];
$deadline = $_POST['deadline'];

$query = "UPDATE tasks SET 
            judul='$judul',
            deskripsi='$deskripsi',
            id_user='$id_user',
            status='$status',
            deadline='$deadline'
          WHERE id_task='$id_task'";

mysqli_query($conn, $query);

header("Location: tugas.php");
exit;