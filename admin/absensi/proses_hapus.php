<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
DELETE FROM absensi
WHERE id_absensi='$id'
");

if($query){

    header("Location:index.php?pesan=hapus");

}else{

    header("Location:index.php?pesan=gagal");

}
?>