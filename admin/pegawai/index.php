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
$query = mysqli_query($koneksi, "

SELECT 
pegawai.*,
jabatan.nama_jabatan

FROM pegawai

INNER JOIN jabatan 
ON pegawai.id_jabatan = jabatan.id_jabatan

ORDER BY id_pegawai DESC

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

text:'Data Pegawai berhasil dihapus.',

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

text:'Data Pegawai berhasil diperbarui.',

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

text:'Data Pegawai berhasil ditambahkan.',

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

text:'Data Pegawai gagal ditambahkan.',

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

        <h2>
            Data Pegawai
        </h2>

        <p>
            Kelola seluruh data pegawai perusahaan.
        </p>

    </div>



    <div class="card-custom">


        <div class="toolbar">


            <a href="#"
            class="btn-tambah"
            data-bs-toggle="modal"
            data-bs-target="#modalPegawai">


                <i class="fas fa-user-plus"></i>

                Tambah Pegawai


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

                    <th width="60">
                        No
                    </th>

                    <th>
                        NIP
                    </th>

                    <th>
Nama Pegawai
</th>

<th>
Status Pernikahan
</th>

<th>
Jabatan
</th>
                    <th>
                        Tanggal Masuk
                    </th>

                    <th width="150">
                        Aksi
                    </th>


                </tr>

            </thead>



            <tbody>


            <?php

            $no=1;


            while($row=mysqli_fetch_assoc($query)){

            ?>


            <tr>


                <td>
                    <?= $no++; ?>
                </td>


                <td>
                    <?= $row['nip']; ?>
                </td>


                <td>
<?= $row['nama_pegawai']; ?>
</td>

<td>
<?= $row['status_pernikahan']; ?>
</td>

<td>
<?= $row['nama_jabatan']; ?>
</td>


                <td>

                    <?= $row['tanggal_masuk']; ?>

                </td>


                <td>


                   <a
                        href="edit.php?id=<?= $row['id_pegawai']; ?>"
                        class="btn btn-warning btn-sm">

                        <i class="fas fa-pen"></i>

                    </a>


                    <a
                        href="proses_hapus.php?id=<?= $row['id_pegawai']; ?>"
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

<!-- Modal Tambah Pegawai -->

<div class="modal fade" id="modalPegawai" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">


<form action="proses_tambah.php" method="POST">


<div class="modal-header">

<h5 class="modal-title">

<i class="fas fa-user-plus"></i>

Tambah Pegawai

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
NIP
</label>


<input
type="text"
name="nip"
class="form-control"
required>

</div>



<div class="mb-3">

<label class="form-label">
Nama Pegawai
</label>


<input
type="text"
name="nama_pegawai"
class="form-control"
required>

</div>
<div class="mb-3">

<label class="form-label">
Status Pernikahan
</label>

<select
name="status_pernikahan"
class="form-control"
required>

<option value="">-- Pilih Status Pernikahan --</option>

<option value="Single">Single</option>

<option value="Menikah">Menikah</option>

</select>

</div>
<div class="mb-3">

<label class="form-label">
Jabatan
</label>


<select 
name="id_jabatan"
class="form-control"
required>


<option value="">
-- Pilih Jabatan --
</option>


<?php

while($j=mysqli_fetch_assoc($jabatan)){

?>


<option value="<?= $j['id_jabatan']; ?>">

<?= $j['nama_jabatan']; ?>

</option>


<?php } ?>


</select>


</div>





<div class="mb-3">

<label class="form-label">
Alamat
</label>


<textarea
name="alamat"
class="form-control">
</textarea>


</div>




<div class="mb-3">

<label class="form-label">
No HP
</label>


<input
type="text"
name="no_hp"
class="form-control">


</div>




<div class="mb-3">

<label class="form-label">
Tanggal Masuk
</label>


<input
type="date"
name="tanggal_masuk"
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

            text:'Data pegawai akan dihapus permanen.',

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