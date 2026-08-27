<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id            = $_POST['id_jabatan'];
$nama_jabatan  = $_POST['nama_jabatan'];
$gaji_pokok    = $_POST['gaji_pokok'];
$tunjangan     = $_POST['tunjangan'];

$query = mysqli_query($koneksi, "UPDATE jabatan SET
    nama_jabatan='$nama_jabatan',
    gaji_pokok='$gaji_pokok',
    tunjangan='$tunjangan'
WHERE id_jabatan='$id'");

if ($query) {

    header("Location: index.php?pesan=update");

} else {

    header("Location: index.php?pesan=gagal");

}
?>