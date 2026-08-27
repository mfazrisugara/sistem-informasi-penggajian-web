<?php

session_start();

if (!isset($_SESSION['username'])) {

    header("Location: ../../login.php");
    exit;

}


include '../../config/koneksi.php';

//quesone//

$nip = $_POST['nip'];

$nama_pegawai = $_POST['nama_pegawai'];

$status_pernikahan = $_POST['status_pernikahan'];

$id_jabatan = $_POST['id_jabatan'];

$alamat = $_POST['alamat'];

$no_hp = $_POST['no_hp'];

$tanggal_masuk = $_POST['tanggal_masuk'];



$query = mysqli_query($koneksi, "
INSERT INTO pegawai
(
    nip,
    nama_pegawai,
    alamat,
    no_hp,
    tanggal_masuk,
    status_pernikahan,
    id_jabatan
)

VALUES
(
    '$nip',
    '$nama_pegawai',
    '$alamat',
    '$no_hp',
    '$tanggal_masuk',
    '$status_pernikahan',
    '$id_jabatan'
)
");



if($query){


    header("Location: index.php?pesan=sukses");


}else{


    header("Location: index.php?pesan=gagal");


}


?>