<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id                 = $_POST['id_pegawai'];
$nip                = $_POST['nip'];
$nama_pegawai       = $_POST['nama_pegawai'];
$status_pernikahan  = $_POST['status_pernikahan'];
$id_jabatan         = $_POST['id_jabatan'];
$alamat             = $_POST['alamat'];
$no_hp              = $_POST['no_hp'];
$tanggal_masuk      = $_POST['tanggal_masuk'];

$query = mysqli_query($koneksi, "
UPDATE pegawai SET

nip='$nip',
nama_pegawai='$nama_pegawai',
status_pernikahan='$status_pernikahan',
id_jabatan='$id_jabatan',
alamat='$alamat',
no_hp='$no_hp',
tanggal_masuk='$tanggal_masuk'

WHERE id_pegawai='$id'
");

if($query){

    header("Location: index.php?pesan=update");

}else{

    header("Location: index.php?pesan=gagal");

}
?>