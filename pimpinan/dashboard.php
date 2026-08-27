<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != "pimpinan") {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

include "../template/header.php";
include "../template/sidebar_pimpinan.php";
include "../template/navbar.php";

$pegawai = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM pegawai")
);

$jabatan = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM jabatan")
);

$gaji = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
    SELECT IFNULL(SUM(total_gaji),0) AS total
    FROM penggajian
    ")
);

$absensi = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
    SELECT COUNT(*) AS total
    FROM absensi
    ")
);

$queryTerbaru = mysqli_query($koneksi,"
SELECT
penggajian.*,
pegawai.nama_pegawai
FROM penggajian
JOIN pegawai
ON penggajian.id_pegawai = pegawai.id_pegawai
ORDER BY id_gaji DESC
LIMIT 5
");

?>
<div class="content">

    <h2>Dashboard Pimpinan</h2>

    <hr>

    <h4>
        Selamat Datang,
        <?= $_SESSION['username']; ?> 👋
    </h4>

    <p>Sistem Informasi Penggajian Berbasis Web</p>
<div class="card-container">

<div class="card-dashboard">

    <div class="icon">
        <i class="fas fa-users"></i>
    </div>

    <div>

        <h3><?= $pegawai['total']; ?></h3>

        <p>Total Pegawai</p>

    </div>

</div>

<div class="card-dashboard">

    <div class="icon">
        <i class="fas fa-briefcase"></i>
    </div>

    <div>

        <h3><?= $jabatan['total']; ?></h3>

        <p>Total Jabatan</p>

    </div>

</div>

<div class="card-dashboard">

    <div class="icon">
        <i class="fas fa-calendar-check"></i>
    </div>

    <div>

        <h3><?= $absensi['total']; ?></h3>

        <p>Total Absensi</p>

    </div>

</div>

<div class="card-dashboard">

    <div class="icon">
        <i class="fas fa-money-bill-wave"></i>
    </div>

    <div>

        <h3>

            Rp <?= number_format($gaji['total'],0,",","."); ?>

        </h3>

        <p>Total Penggajian</p>

    </div>

</div>

</div> <!-- card-container -->

<div class="card-custom mt-4">

<h3>
    <i class="fas fa-money-bill-wave"></i>
    Penggajian Terbaru
</h3>


<table class="table table-hover">

</div>

    <thead>

        <tr>

            <th>No</th>

            <th>Pegawai</th>

            <th>Bulan</th>

            <th>Tahun</th>

            <th>Total Gaji</th>

        </tr>

    </thead>

    <tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($queryTerbaru)){

?>

<tr>

    <td>
        <?= $no++; ?>
    </td>


    <td>
        <?= $row['nama_pegawai']; ?>
    </td>


    <td>
        <?= $row['bulan']; ?>
    </td>


    <td>
        <?= $row['tahun']; ?>
    </td>


    <td>
        Rp <?= number_format($row['total_gaji'],0,",","."); ?>
    </td>


</tr>


<?php } ?>

</tbody>

</table>

</div> <!-- content -->

<?php
include "../template/footer.php";
?>