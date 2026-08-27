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

$id = $_GET['id'];

$query = mysqli_query($koneksi,"
SELECT
penggajian.*,
pegawai.nama_pegawai
FROM penggajian
JOIN pegawai
ON penggajian.id_pegawai = pegawai.id_pegawai
WHERE id_gaji='$id'
");

$data = mysqli_fetch_assoc($query);

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<div class="content">

<div class="page-title">

<h2>Edit Penggajian</h2>

<p>Edit data penggajian pegawai.</p>

</div>

<div class="card-custom">

<form action="proses_edit.php" method="POST">

<input
type="hidden"
name="id_gaji"
value="<?= $data['id_gaji']; ?>">

<div class="mb-3">

<label>Pegawai</label>

<input
type="text"
class="form-control"
value="<?= $data['nama_pegawai']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Bulan</label>

<input
type="text"
name="bulan"
class="form-control"
value="<?= $data['bulan']; ?>">

</div>

<div class="mb-3">

<label>Tahun</label>

<input
type="number"
name="tahun"
class="form-control"
value="<?= $data['tahun']; ?>">

</div>

<div class="mb-3">

<label>Bonus</label>

<input
type="number"
name="bonus"
class="form-control"
value="<?= $data['bonus']; ?>">

</div>

<div class="mb-3">

<label>Potongan</label>

<input
type="number"
name="potongan"
class="form-control"
value="<?= $data['potongan']; ?>">

</div>

<div class="mb-3">

<label>Tanggal Gaji</label>

<input
type="date"
name="tanggal_gaji"
class="form-control"
value="<?= $data['tanggal_gaji']; ?>">

</div>

<button
type="submit"
class="btn btn-success">

<i class="fas fa-save"></i>

Update

</button>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

<?php
include '../../template/footer.php';
?>