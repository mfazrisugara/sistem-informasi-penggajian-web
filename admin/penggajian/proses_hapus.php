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

$hapus = mysqli_query($koneksi,"
DELETE FROM penggajian
WHERE id_gaji='$id'
");

if($hapus){

    header("Location:index.php?pesan=hapus");

}else{

    header("Location:index.php?pesan=gagal");

}