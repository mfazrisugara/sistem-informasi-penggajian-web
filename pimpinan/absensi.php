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
absensi.*,
pegawai.nama_pegawai
FROM absensi
JOIN pegawai
ON absensi.id_pegawai = pegawai.id_pegawai
ORDER BY absensi.id_absensi DESC
");


include '../template/header.php';
include '../template/sidebar_pimpinan.php';
include '../template/navbar.php';

?>


<div class="content">


<div class="page-title">

<h2>
Data Absensi
</h2>

<p>
Informasi absensi pegawai.
</p>

</div>



<div class="card-custom">


<h3>

<i class="fas fa-calendar-check"></i>

Data Absensi

</h3>



<table class="table table-hover">


<thead>

<tr>

<th>No</th>

<th>Nama Pegawai</th>

<th>Tanggal</th>

<th>Jumlah Hadir</th>

<th>Lembur</th>

<th>Keterangan</th>

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
<?= $row['nama_pegawai']; ?>
</td>


<td>
<?= $row['tanggal_absensi']; ?>
</td>


<td>
<?= $row['jumlah_hadir']; ?> Hari
</td>


<td>
<?= $row['lembur_jam']; ?> Jam
</td>


<td>
<?= $row['keterangan']; ?>
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