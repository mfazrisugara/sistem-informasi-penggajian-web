<?php

session_start();

if (!isset($_SESSION['username'])) {

    header("Location: ../../login.php");
    exit;

}


if ($_SESSION['role'] != "pimpinan") {

    header("Location: ../../login.php");
    exit;

}


include '../../config/koneksi.php';


include '../../template/header.php';
include '../../template/sidebar_pimpinan.php';
include '../../template/navbar.php';


?>

<div class="content">


<div class="page-title">

<h2>
Laporan Penggajian
</h2>


<p>
Rekap data penggajian pegawai.
</p>


</div>



<div class="card-custom">

<h3>

<i class="fas fa-file-lines"></i>

Data Laporan

</h3>

<hr>

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Bulan</label>

<select name="bulan" class="form-control">

<option value="">-- Semua Bulan --</option>

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

<div class="col-md-3">

<label>Tahun</label>

<input
type="number"
name="tahun"
class="form-control"
value="<?= date('Y'); ?>">

</div>

<div class="col-md-4">

    <label>&nbsp;</label>

    <div class="d-flex gap-2">

        <button
            type="submit"
            class="btn btn-success">

            <i class="fas fa-search"></i>

            Tampilkan

        </button>

        <button 
type="submit"
formaction="cetak_pdf.php"
class="btn btn-danger">

<i class="fas fa-file-pdf"></i>

Cetak PDF

</button>
   </div>

</div>

</form>

</div>

</div>

<?php

$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';

$sql = "
SELECT
pegawai.nama_pegawai,
jabatan.nama_jabatan,
penggajian.bulan,
penggajian.tahun,
penggajian.total_gaji

FROM penggajian

JOIN pegawai
ON penggajian.id_pegawai = pegawai.id_pegawai

JOIN jabatan
ON pegawai.id_jabatan = jabatan.id_jabatan

WHERE 1=1
";

if($bulan!=""){
    $sql .= " AND penggajian.bulan='$bulan'";
}

if($tahun!=""){
    $sql .= " AND penggajian.tahun='$tahun'";
}

$sql .= " ORDER BY pegawai.nama_pegawai ASC";

$query = mysqli_query($koneksi,$sql);

?>

<br>

<table class="table table-bordered table-striped">

<thead class="table-success">

<tr>

<th>No</th>

<th>Nama Pegawai</th>

<th>Jabatan</th>

<th>Bulan</th>

<th>Tahun</th>

<th>Total Gaji</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama_pegawai']; ?></td>

<td><?= $d['nama_jabatan']; ?></td>

<td><?= $d['bulan']; ?></td>

<td><?= $d['tahun']; ?></td>

<td>
Rp <?= number_format($d['total_gaji'],0,',','.'); ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php
include '../../template/footer.php';
?>