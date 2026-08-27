<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi,"
SELECT *
FROM pegawai
WHERE id_pegawai='$id'
");

$row = mysqli_fetch_assoc($data);

$jabatan = mysqli_query($koneksi,"
SELECT *
FROM jabatan
ORDER BY nama_jabatan ASC
");

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<div class="content">

<div class="card-custom">

<h2>Edit Pegawai</h2>

<br>

<form action="proses_edit.php" method="POST">

<input
type="hidden"
name="id_pegawai"
value="<?= $row['id_pegawai']; ?>">

<div class="mb-3">

<label>NIP</label>

<input
type="text"
name="nip"
class="form-control"
value="<?= $row['nip']; ?>"
required>

</div>

<div class="mb-3">

<label>Nama Pegawai</label>

<input
type="text"
name="nama_pegawai"
class="form-control"
value="<?= $row['nama_pegawai']; ?>"
required>

</div>

<div class="mb-3">

<label>Status Pernikahan</label>

<select
name="status_pernikahan"
class="form-control"
required>

<option value="Single"
<?= ($row['status_pernikahan']=="Single") ? "selected" : ""; ?>>
Single
</option>

<option value="Menikah"
<?= ($row['status_pernikahan']=="Menikah") ? "selected" : ""; ?>>
Menikah
</option>

</select>

</div>

<div class="mb-3">

<label>Jabatan</label>

<select
name="id_jabatan"
class="form-control"
required>

<?php while($j=mysqli_fetch_assoc($jabatan)){ ?>

<option
value="<?= $j['id_jabatan']; ?>"
<?= ($j['id_jabatan']==$row['id_jabatan']) ? 'selected' : ''; ?>>

<?= $j['nama_jabatan']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"><?= $row['alamat']; ?></textarea>

</div>

<div class="mb-3">

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= $row['no_hp']; ?>">

</div>

<div class="mb-3">

<label>Tanggal Masuk</label>

<input
type="date"
name="tanggal_masuk"
class="form-control"
value="<?= $row['tanggal_masuk']; ?>"
required>

</div>

<button
type="submit"
class="btn btn-success">

<i class="fas fa-save"></i>

Simpan Perubahan

</button>

<a
href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

<?php
include '../../template/footer.php';
?>