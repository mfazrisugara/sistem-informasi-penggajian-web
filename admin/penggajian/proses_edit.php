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

$id_gaji       = $_POST['id_gaji'];
$bulan         = $_POST['bulan'];
$tahun         = $_POST['tahun'];
$bonus         = $_POST['bonus'];
$potongan      = $_POST['potongan'];
$tanggal_gaji  = $_POST['tanggal_gaji'];

// Ambil data penggajian
$queryGaji = mysqli_query($koneksi,"
SELECT * FROM penggajian
WHERE id_gaji='$id_gaji'
");

$dataGaji = mysqli_fetch_assoc($queryGaji);

$id_pegawai = $dataGaji['id_pegawai'];
$id_absensi = $dataGaji['id_absensi'];

// Ambil data pegawai + jabatan
$queryPegawai = mysqli_query($koneksi,"
SELECT
pegawai.*,
jabatan.gaji_pokok,
jabatan.tunjangan
FROM pegawai
JOIN jabatan
ON pegawai.id_jabatan=jabatan.id_jabatan
WHERE pegawai.id_pegawai='$id_pegawai'
");

$dataPegawai = mysqli_fetch_assoc($queryPegawai);

$gaji_pokok = $dataPegawai['gaji_pokok'];
$tunjangan  = $dataPegawai['tunjangan'];

// Ambil absensi
$queryAbsensi = mysqli_query($koneksi,"
SELECT *
FROM absensi
WHERE id_absensi='$id_absensi'
");

$dataAbsensi = mysqli_fetch_assoc($queryAbsensi);

$lembur_jam = $dataAbsensi['lembur_jam'];

// Hitung ulang total gaji
$tarif_lembur = 25000;

$uang_lembur = $lembur_jam * $tarif_lembur;

$total_gaji =
$gaji_pokok +
$tunjangan +
$uang_lembur +
$bonus -
$potongan;

// Update data penggajian
$update = mysqli_query($koneksi,"
UPDATE penggajian SET
bulan='$bulan',
tahun='$tahun',
bonus='$bonus',
potongan='$potongan',
total_gaji='$total_gaji',
tanggal_gaji='$tanggal_gaji'
WHERE id_gaji='$id_gaji'
");

if($update){

    header("Location:index.php?pesan=update");

}else{

    header("Location:index.php?pesan=gagal");

}