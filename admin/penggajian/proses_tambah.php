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
$id_pegawai    = $_POST['id_pegawai'];
$bulan         = $_POST['bulan'];
$tahun         = $_POST['tahun'];
$bonus         = $_POST['bonus'];
$potongan      = $_POST['potongan'];
$tanggal_gaji  = $_POST['tanggal_gaji'];

// Ambil data pegawai beserta jabatan
$queryPegawai = mysqli_query($koneksi,"
SELECT
pegawai.*,
jabatan.gaji_pokok,
jabatan.tunjangan
FROM pegawai
JOIN jabatan
ON pegawai.id_jabatan = jabatan.id_jabatan
WHERE pegawai.id_pegawai='$id_pegawai'
");

$dataPegawai = mysqli_fetch_assoc($queryPegawai);

$gaji_pokok = $dataPegawai['gaji_pokok'];
$tunjangan  = $dataPegawai['tunjangan'];

// Ambil absensi terakhir pegawai
$queryAbsensi = mysqli_query($koneksi,"
SELECT *
FROM absensi
WHERE id_pegawai='$id_pegawai'
ORDER BY id_absensi DESC
LIMIT 1
");

$dataAbsensi = mysqli_fetch_assoc($queryAbsensi);

// Jika pegawai belum punya absensi
if(!$dataAbsensi){

    header("Location:index.php?pesan=gagal");
    exit;

}

$id_absensi = $dataAbsensi['id_absensi'];
$lembur_jam = $dataAbsensi['lembur_jam'];

// Tarif lembur
$tarif_lembur = 25000;

// Hitung uang lembur
$uang_lembur = $lembur_jam * $tarif_lembur;

// Hitung total gaji
$total_gaji = 
(float)$gaji_pokok +
(float)$tunjangan +
(float)$uang_lembur +
(float)$bonus -
(float)$potongan;

// Simpan ke database
$simpan = mysqli_query($koneksi,"
INSERT INTO penggajian
(
id_pegawai,
id_absensi,
bulan,
tahun,
bonus,
potongan,
total_gaji,
tanggal_gaji
)
VALUES
(
'$id_pegawai',
'$id_absensi',
'$bulan',
'$tahun',
'$bonus',
'$potongan',
'$total_gaji',
'$tanggal_gaji'
)
");

// Cek berhasil atau tidak
if($simpan){

    header("Location:index.php?pesan=sukses");

}else{

    header("Location:index.php?pesan=gagal");

}