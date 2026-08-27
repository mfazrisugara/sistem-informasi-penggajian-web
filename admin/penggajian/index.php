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

$query = mysqli_query($koneksi,"
SELECT
penggajian.*,
pegawai.nama_pegawai
FROM penggajian
JOIN pegawai
ON penggajian.id_pegawai = pegawai.id_pegawai
ORDER BY id_gaji DESC
");

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<?php

if(isset($_GET['pesan'])){

    if($_GET['pesan']=="sukses"){
?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    Swal.fire({

        icon:'success',

        title:'Berhasil',

        text:'Data Penggajian berhasil ditambahkan.',

        confirmButtonColor:'#059669'

    });

});

</script>

<?php
    }

    if($_GET['pesan']=="update"){
?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    Swal.fire({

        icon:'success',

        title:'Berhasil',

        text:'Data Penggajian berhasil diperbarui.',

        confirmButtonColor:'#059669'

    });

});

</script>

<?php
    }

    if($_GET['pesan']=="hapus"){
?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    Swal.fire({

        icon:'success',

        title:'Berhasil',

        text:'Data Penggajian berhasil dihapus.',

        confirmButtonColor:'#059669'

    });

});

</script>

<?php
    }

    if($_GET['pesan']=="gagal"){
?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    Swal.fire({

        icon:'error',

        title:'Gagal',

        text:'Data Penggajian gagal disimpan.',

        confirmButtonColor:'#DC2626'

    });

});

</script>

<?php
    }

}
?>

<div class="content">

    <div class="page-title">

        <h2>Data Penggajian</h2>

        <p>Kelola data penggajian pegawai.</p>

    </div>

    <div class="card-custom">

        <div class="toolbar">

            <a href="#"
               class="btn-tambah"
               data-bs-toggle="modal"
               data-bs-target="#modalGaji">

                <i class="fas fa-plus"></i>

                Tambah Penggajian

            </a>

        </div>

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Pegawai</th>

                    <th>Bulan</th>

                    <th>Tahun</th>

                    <th>Total Gaji</th>

                    <th>Tanggal Gaji</th>

                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php
            $no=1;

            while($row=mysqli_fetch_assoc($query)){
            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $row['nama_pegawai']; ?></td>

                    <td><?= $row['bulan']; ?></td>

                    <td><?= $row['tahun']; ?></td>

                    <td>

                        Rp <?= number_format($row['total_gaji'],0,",","."); ?>

                    </td>

                    <td><?= $row['tanggal_gaji']; ?></td>

                    <td>

                        <a href="edit.php?id=<?= $row['id_gaji']; ?>"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-pen"></i>

                        </a>
                        <a href="proses_hapus.php?id=<?= $row['id_gaji']; ?>"
                            class="btn btn-danger btn-sm btn-hapus">

                            <i class="fas fa-trash"></i>

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<!-- Modal Tambah Penggajian -->

<div class="modal fade" id="modalGaji" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<form action="proses_tambah.php" method="POST">

<div class="modal-header">

<h5 class="modal-title">

<i class="fas fa-money-bill-wave"></i>

Tambah Penggajian

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label class="form-label">

Pegawai

</label>

<select
name="id_pegawai"
class="form-select"
required>

<option value="">-- Pilih Pegawai --</option>

<?php

$pegawai = mysqli_query($koneksi,"
SELECT * FROM pegawai
ORDER BY nama_pegawai ASC
");

while($p=mysqli_fetch_assoc($pegawai)){

?>

<option value="<?= $p['id_pegawai']; ?>">

<?= $p['nama_pegawai']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Bulan

</label>

<select
name="bulan"
class="form-select"
required>

<option value="">-- Pilih Bulan --</option>

<option>Januari</option>
<option>Februari</option>
<option>Maret</option>
<option>April</option>
<option>Mei</option>
<option>Juni</option>
<option>Juli</option>
<option>Agustus</option>
<option>September</option>
<option>Oktober</option>
<option>November</option>
<option>Desember</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Tahun

</label>

<input
type="number"
name="tahun"
class="form-control"
value="<?= date('Y'); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Bonus

</label>

<input
type="number"
name="bonus"
class="form-control"
value="0">

</div>

<div class="mb-3">

<label class="form-label">

Potongan

</label>

<input
type="number"
name="potongan"
class="form-control"
value="0">

</div>

<div class="mb-3">

<label class="form-label">

Tanggal Gaji

</label>

<input
type="date"
name="tanggal_gaji"
class="form-control"
required>

</div>

</div>

<div class="modal-footer">

<button
type="button"
class="btn btn-secondary"
data-bs-dismiss="modal">

Batal

</button>

<button
type="submit"
class="btn btn-success">

<i class="fas fa-save"></i>

Simpan

</button>

</div>

</form>

</div>

</div>

</div>

<script>

document.querySelectorAll(".btn-hapus").forEach(function(button){

    button.addEventListener("click", function(e){

        e.preventDefault();

        let url = this.href;

        Swal.fire({

            title:'Yakin ingin menghapus?',

            text:'Data penggajian akan dihapus permanen.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#DC2626',

            cancelButtonColor:'#6B7280',

            confirmButtonText:'Ya, Hapus!',

            cancelButtonText:'Batal'

        }).then((result)=>{

            if(result.isConfirmed){

                window.location.href = url;

            }

        });

    });

});

</script>

<?php
include '../../template/footer.php';
?>