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

$id_absensi       = $_POST['id_absensi'];
$id_pegawai       = $_POST['id_pegawai'];
$tanggal_absensi  = $_POST['tanggal_absensi'];
$jumlah_hadir     = $_POST['jumlah_hadir'];
$lembur_jam       = $_POST['lembur_jam'];
$keterangan       = $_POST['keterangan'];

$query = mysqli_query($koneksi, "
UPDATE absensi SET
id_pegawai='$id_pegawai',
tanggal_absensi='$tanggal_absensi',
jumlah_hadir='$jumlah_hadir',
lembur_jam='$lembur_jam',
keterangan='$keterangan'
WHERE id_absensi='$id_absensi'
");

if($query){

    header("Location:index.php?pesan=update");

}else{

    header("Location:index.php?pesan=gagal");

}
?>