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
penggajian.*,
pegawai.nama_pegawai
FROM penggajian
JOIN pegawai
ON penggajian.id_pegawai = pegawai.id_pegawai
ORDER BY id_gaji DESC
");


include '../template/header.php';
include '../template/sidebar_pimpinan.php';
include '../template/navbar.php';

?>


<div class="content">


<div class="page-title">

<h2>
Data Penggajian
</h2>

<p>
Informasi penggajian pegawai.
</p>

</div>



<div class="card-custom">


<h3>

<i class="fas fa-money-bill-wave"></i>

Data Penggajian

</h3>



<table class="table table-hover">


<thead>

<tr>

<th>No</th>

<th>Nama Pegawai</th>

<th>Bulan</th>

<th>Tahun</th>

<th>Total Gaji</th>

<th>Tanggal Gaji</th>

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
<?= $row['bulan']; ?>
</td>


<td>
<?= $row['tahun']; ?>
</td>


<td>

Rp <?= number_format($row['total_gaji'],0,",","."); ?>

</td>


<td>
<?= $row['tanggal_gaji']; ?>
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