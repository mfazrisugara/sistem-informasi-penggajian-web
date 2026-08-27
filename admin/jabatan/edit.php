<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE id_jabatan='$id'");

$data = mysqli_fetch_assoc($query);

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<div class="content">

    <div class="page-title">

        <h2>Edit Jabatan</h2>

        <p>Ubah data jabatan.</p>

    </div>

    <div class="card-custom">

        <form action="proses_edit.php" method="POST">

            <input
                type="hidden"
                name="id_jabatan"
                value="<?= $data['id_jabatan']; ?>">

            <div class="mb-3">

                <label>Nama Jabatan</label>

                <input
                    type="text"
                    name="nama_jabatan"
                    class="form-control"
                    value="<?= $data['nama_jabatan']; ?>"
                    required>

            </div>

            <div class="mb-3">

                <label>Gaji Pokok</label>

                <input
                    type="number"
                    name="gaji_pokok"
                    class="form-control"
                    value="<?= $data['gaji_pokok']; ?>"
                    required>

            </div>

            <div class="mb-3">

                <label>Tunjangan</label>

                <input
                    type="number"
                    name="tunjangan"
                    class="form-control"
                    value="<?= $data['tunjangan']; ?>"
                    required>

            </div>

            <button class="btn btn-success">

                <i class="fas fa-save"></i>

                Update

            </button>

            <a href="index.php" class="btn btn-secondary">

                Batal

            </a>

        </form>

    </div>

</div>

<?php
include '../../template/footer.php';
?>