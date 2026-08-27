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
absensi.*,
pegawai.nama_pegawai
FROM absensi
JOIN pegawai
ON absensi.id_pegawai = pegawai.id_pegawai
WHERE id_absensi='$id'
");

$data = mysqli_fetch_assoc($query);

$pegawai = mysqli_query($koneksi,"
SELECT * FROM pegawai
ORDER BY nama_pegawai ASC
");

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<div class="content">

    <div class="page-title">

        <h2>Edit Absensi</h2>

        <p>Edit data absensi pegawai.</p>

    </div>

    <div class="card-custom">

        <form action="proses_edit.php" method="POST">

            <input
                type="hidden"
                name="id_absensi"
                value="<?= $data['id_absensi']; ?>">

        <div class="mb-3">

    <label class="form-label">
        Pegawai
    </label>

    <select
        name="id_pegawai"
        class="form-select"
        required>

        <?php while($p = mysqli_fetch_assoc($pegawai)){ ?>

        <option
            value="<?= $p['id_pegawai']; ?>"
            <?= ($p['id_pegawai']==$data['id_pegawai']) ? 'selected' : ''; ?>>

            <?= $p['nama_pegawai']; ?>

        </option>

        <?php } ?>

    </select>

</div>

<div class="mb-3">

    <label class="form-label">
        Tanggal Absensi
    </label>

    <input
        type="date"
        name="tanggal_absensi"
        class="form-control"
        value="<?= $data['tanggal_absensi']; ?>"
        required>

</div>

<div class="mb-3">

    <label class="form-label">
        Jumlah Hadir
    </label>

    <input
        type="number"
        name="jumlah_hadir"
        class="form-control"
        value="<?= $data['jumlah_hadir']; ?>"
        required>

</div>

<div class="mb-3">

    <label class="form-label">
        Lembur (Jam)
    </label>

    <input
        type="number"
        name="lembur_jam"
        class="form-control"
        value="<?= $data['lembur_jam']; ?>">

</div>

<div class="mb-3">

    <label class="form-label">
        Keterangan
    </label>

    <textarea
        name="keterangan"
        class="form-control"
        rows="3"><?= $data['keterangan']; ?></textarea>

</div>

<div class="mt-3">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fas fa-save"></i>

        Update

    </button>

    <a
        href="index.php"
        class="btn btn-secondary">

        Kembali

    </a>

</div>

</form>

</div>

</div>

<?php
include '../../template/footer.php';
?>