<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

include '../config/koneksi.php';
// Menghitung jumlah pegawai
$queryPegawai = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pegawai");

$dataPegawai = mysqli_fetch_assoc($queryPegawai);

$totalPegawai = $dataPegawai['total'];

// Menghitung jumlah jabatan
$queryJabatan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM jabatan");

$dataJabatan = mysqli_fetch_assoc($queryJabatan);

$totalJabatan = $dataJabatan['total'];

// Menghitung jumlah absensi
$queryAbsensi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM absensi");

$dataAbsensi = mysqli_fetch_assoc($queryAbsensi);

$totalAbsensi = $dataAbsensi['total'];

// Menghitung jumlah penggajian
$queryPenggajian = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM penggajian");

$dataPenggajian = mysqli_fetch_assoc($queryPenggajian);

$totalPenggajian = $dataPenggajian['total'];

include '../template/header.php';
include '../template/sidebar.php';
include '../template/navbar.php';
?>

<div class="content">

    <h2>Dashboard Admin</h2>

    <hr>

    <h4>Selamat Datang,
        <?= $_SESSION['username']; ?> 👋
    </h4>

    <p>Sistem Informasi Penggajian Berbasis Web</p>
<div class="card-container">


    <div class="card-dashboard">

        <div class="icon">
            <i class="fas fa-users"></i>
        </div>

        <div>
            <h3>
                <?= $totalPegawai; ?>
            </h3>

            <p>
                Total Pegawai
            </p>
        </div>

    </div>



    <div class="card-dashboard">

        <div class="icon">
            <i class="fas fa-briefcase"></i>
        </div>

        <div>

            <h3>
                <?= $totalJabatan; ?>
            </h3>

            <p>
                Total Jabatan
            </p>

        </div>

            </div>


    <!-- CARD ABSENSI -->
    <div class="card-dashboard">

        <div class="icon">
            <i class="fas fa-calendar-check"></i>
        </div>

        <div>

            <h3>
                <?= $totalAbsensi; ?>
            </h3>

            <p>
                Total Absensi
            </p>

        </div>

    </div>

    <div class="card-dashboard">

    <div class="icon">
        <i class="fas fa-money-bill-wave"></i>
    </div>

    <div>

        <h3>
            <?= $totalPenggajian; ?>
        </h3>

        <p>
            Total Penggajian
        </p>

    </div>

</div>

</div> <!-- card-container -->

</div> <!-- content -->

<?php
include '../template/footer.php';
?>