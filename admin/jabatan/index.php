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

$query = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY id_jabatan DESC");

include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';
?>

<?php

if(isset($_GET['pesan'])){

    if($_GET['pesan']=="sukses"){
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data Jabatan berhasil ditambahkan.',
        confirmButtonColor: '#059669'
    });
});
</script>
<?php
    }

    if($_GET['pesan']=="update"){
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data Jabatan berhasil diperbarui.',
        confirmButtonColor: '#059669'
    });
});
</script>
<?php
    }

    if($_GET['pesan']=="hapus"){
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data Jabatan berhasil dihapus.',
        confirmButtonColor: '#059669'
    });
});
</script>
<?php
    }

    if($_GET['pesan']=="gagal"){
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Data gagal disimpan.',
        confirmButtonColor: '#DC2626'
    });
});
</script>
<?php
    }

}
?>

<div class="content">

    <div class="page-title">

        <h2>Data Jabatan</h2>

        <p>Kelola seluruh data jabatan pegawai perusahaan.</p>

    </div>

    <div class="card-custom">

        <div class="toolbar">

            <a href="#"
   class="btn-tambah"
   data-bs-toggle="modal"
   data-bs-target="#modalJabatan">

    <i class="fas fa-plus"></i>

    Tambah Jabatan

</a>

            <div class="search-box">

                <i class="fas fa-search"></i>

                <input 
                    type="text" 
                    id="searchJabatan"
                    placeholder="Cari jabatan...">

            </div>

        </div>

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="70">No</th>

                    <th>Nama Jabatan</th>

                    <th>Gaji Pokok</th>

                    <th>Tunjangan</th>

                    <th width="170">Aksi</th>

                </tr>

            </thead>

            <tbody id="tableJabatan">

            <?php
            $no = 1;

            while($row = mysqli_fetch_assoc($query)){
            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $row['nama_jabatan']; ?></td>

                    <td>Rp <?= number_format($row['gaji_pokok'],0,",","."); ?></td>

                    <td>Rp <?= number_format($row['tunjangan'],0,",","."); ?></td>

                    <td>

                        <a
                            href="edit.php?id=<?= $row['id_jabatan']; ?>"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-pen"></i>

                        </a>

                       <a
                            href="javascript:void(0)"
                            onclick="hapusData(<?= $row['id_jabatan']; ?>)"
                            class="btn btn-danger btn-sm">

                            <i class="fas fa-trash"></i>

                        </a>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<!-- Modal Tambah Jabatan -->

<div class="modal fade" id="modalJabatan" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="proses_tambah.php" method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-briefcase"></i>

                        Tambah Jabatan

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
                            Nama Jabatan
                        </label>

                        <input
                            type="text"
                            name="nama_jabatan"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Gaji Pokok
                        </label>

                        <input
                            type="number"
                            name="gaji_pokok"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Tunjangan
                        </label>

                        <input
                            type="number"
                            name="tunjangan"
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

function hapusData(id){

    Swal.fire({

        title: 'Apakah Anda yakin?',

        text: "Data jabatan yang dihapus tidak dapat dikembalikan!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#DC2626',

        cancelButtonColor: '#6B7280',

        confirmButtonText: 'Ya, Hapus',

        cancelButtonText: 'Batal'

    }).then((result)=>{


        if(result.isConfirmed){

            window.location.href =
            "proses_hapus.php?id=" + id;

        }


    });

}

</script>

<script>

document
.getElementById("searchJabatan")
.addEventListener("keyup", function(){

    let keyword = this.value.toLowerCase();

    let rows = document
    .querySelectorAll("#tableJabatan tr");


    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();


        if(text.includes(keyword)){

            row.style.display="";

        }else{

            row.style.display="none";

        }


    });


});


</script>

<?php
include '../../template/footer.php';
?>