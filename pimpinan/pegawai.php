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


include '../config/koneksi.php';


$query = mysqli_query($koneksi,"
SELECT 
pegawai.*,
jabatan.nama_jabatan
FROM pegawai
JOIN jabatan
ON pegawai.id_jabatan = jabatan.id_jabatan
ORDER BY pegawai.id_pegawai DESC
");


include '../template/header.php';
include '../template/sidebar_pimpinan.php';
include '../template/navbar.php';

?>


<div class="content">


<div class="page-title">

<h2>
Data Pegawai
</h2>

<p>
Informasi data pegawai perusahaan.
</p>

</div>



<div class="card-custom">


<h3>

<i class="fas fa-users"></i>

Data Pegawai

</h3>



<table class="table table-hover">


<thead>

<tr>

<th>No</th>

<th>NIP</th>

<th>Nama Pegawai</th>

<th>Jabatan</th>

<th>Alamat</th>

<th>Lama Bekerja</th>


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
<?= $row['nama_jabatan']; ?>
</td>


<td>
<?= $row['alamat']; ?>
</td>


<td>

<?php

$tanggalMasuk = new DateTime($row['tanggal_masuk']);

$hariIni = new DateTime();

$lamaKerja = $tanggalMasuk->diff($hariIni)->y;

echo $lamaKerja . " Tahun";

?>

</td>


</tr>


<?php } ?>


</tbody>


</table>


</div>


</div>



<?php

include '../template/footer.php';

?>