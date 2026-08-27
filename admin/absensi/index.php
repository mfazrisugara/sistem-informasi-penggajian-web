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


// Ambil data pegawai + nama jabatan
$query = mysqli_query($koneksi,"
SELECT
absensi.*,
pegawai.nama_pegawai
FROM absensi
JOIN pegawai
ON absensi.id_pegawai = pegawai.id_pegawai
ORDER BY id_absensi DESC
");


// Ambil data jabatan untuk dropdown nanti
$jabatan = mysqli_query($koneksi,"
SELECT * FROM jabatan ORDER BY nama_jabatan ASC
");


include '../../template/header.php';
include '../../template/sidebar.php';
include '../../template/navbar.php';

?>

<?php

if(isset($_GET['pesan'])){

if($_GET['pesan']=="hapus"){
?>

<script>

document.addEventListener("DOMContentLoaded", function(){

Swal.fire({

icon:'success',

title:'Berhasil',

text:'Data Absensi berhasil dihapus.',
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

text:'Data Absensi berhasil diperbarui.',

confirmButtonColor:'#059669'

});

});

</script>

<?php
}

if($_GET['pesan']=="sukses"){

?>

<script>

document.addEventListener("DOMContentLoaded", function(){

Swal.fire({

icon:'success',

title:'Berhasil',

text:'Data Absensi berhasil ditambahkan.',

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

text:'Data Absensi gagal ditambahkan.',

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

    <h2>Data Absensi</h2>

    <p>Kelola data absensi pegawai.</p>

</div>



    <div class="card-custom">


        <div class="toolbar">


            <a href="#"
                class="btn-tambah"
                data-bs-toggle="modal"
                data-bs-target="#modalAbsensi">

                <i class="fas fa-plus"></i>

                    Tambah Absensi

            </a>


            <div class="search-box">


                <i class="fas fa-search"></i>


                <input 
                type="text"
                placeholder="Cari pegawai...">


            </div>


        </div>





        <table class="table table-hover">


            <thead>

<tr>

    <th width="70">No</th>

    <th>Pegawai</th>

<th>Tanggal</th>

<th>Status</th>

<th>Jumlah Hadir</th>
    <th>Lembur (Jam)</th>

    <th>Keterangan</th>

    <th width="170">Aksi</th>

</tr>

</thead>


<tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($query)){

?>

<tr>

    <td><?= $no++; ?></td>

    <td><?= $row['nama_pegawai']; ?></td>

<td><?= $row['tanggal_absensi']; ?></td>

<td><?= $row['status_absensi']; ?></td>

<td><?= $row['jumlah_hadir']; ?></td>
    <td><?= $row['lembur_jam']; ?> Jam</td>

    <td><?= $row['keterangan']; ?></td>

   <td>

    <a
        href="edit.php?id=<?= $row['id_absensi']; ?>"
        class="btn btn-warning btn-sm">

        <i class="fas fa-pen"></i>

    </a>

    <a
        href="proses_hapus.php?id=<?= $row['id_absensi']; ?>"
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



<script>

document.querySelectorAll(".btn-hapus").forEach(function(button){

    button.addEventListener("click", function(e){

        e.preventDefault();

        let url = this.href;

        Swal.fire({

            title:'Yakin ingin menghapus?',

            text:'Data absensi akan dihapus permanen.',

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

<!-- Modal Tambah Absensi -->

<div class="modal fade" id="modalAbsensi" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="proses_tambah.php" method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-calendar-check"></i>

                        Tambah Absensi

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

        $pegawai = mysqli_query($koneksi,
        "SELECT * FROM pegawai ORDER BY nama_pegawai ASC");

        while($p = mysqli_fetch_assoc($pegawai)){

        ?>

        <option value="<?= $p['id_pegawai']; ?>">

            <?= $p['nama_pegawai']; ?>

        </option>

        <?php } ?>

    </select>

</div>

<div class="mb-3">

    <label class="form-label">

        Tanggal Absensi

        <div class="mb-3">

<label class="form-label">

Status Absensi

</label>

<select
name="status_absensi"
class="form-select"
required>

<option value="">-- Pilih Status --</option>

<option value="Hadir">Hadir</option>

<option value="Izin">Izin</option>

<option value="Sakit">Sakit</option>

</select>

</div>

    </label>

    <input
        type="date"
        name="tanggal_absensi"
        class="form-control"
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
        value="0">

</div>

<div class="mb-3">

    <label class="form-label">

        Keterangan

    </label>

    <textarea
        name="keterangan"
        class="form-control"
        rows="3"></textarea>

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

<?php

include '../../template/footer.php';

?>