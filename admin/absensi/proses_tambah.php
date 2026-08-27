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

// Ambil data dari form
$id_pegawai      = $_POST['id_pegawai'];
$tanggal_absensi = $_POST['tanggal_absensi'];
$status_absensi  = $_POST['status_absensi'];
$jumlah_hadir    = $_POST['jumlah_hadir'];
$lembur_jam      = $_POST['lembur_jam'];
$keterangan      = $_POST['keterangan'];

// Simpan ke database
$query = mysqli_query($koneksi, "
INSERT INTO absensi
(
    id_pegawai,
    tanggal_absensi,
    status_absensi,
    jumlah_hadir,
    lembur_jam,
    keterangan
)
VALUES
(
    '$id_pegawai',
    '$tanggal_absensi',
    '$status_absensi',
    '$jumlah_hadir',
    '$lembur_jam',
    '$keterangan'
)
");

if($query){

    header("Location: index.php?pesan=sukses");

}else{

    header("Location: index.php?pesan=gagal");

}
?>