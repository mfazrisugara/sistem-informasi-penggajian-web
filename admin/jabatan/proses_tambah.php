<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

// Ambil data dari form
$nama_jabatan = $_POST['nama_jabatan'];
$gaji_pokok   = $_POST['gaji_pokok'];
$tunjangan    = $_POST['tunjangan'];

// Simpan ke database
$query = mysqli_query($koneksi, "INSERT INTO jabatan (nama_jabatan, gaji_pokok, tunjangan)
VALUES ('$nama_jabatan','$gaji_pokok','$tunjangan')");

if ($query) {

    header("Location: index.php?pesan=sukses");

} else {

    header("Location: index.php?pesan=gagal");

}
?>