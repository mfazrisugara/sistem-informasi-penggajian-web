<?php

require('../../fpdf.php');
include('../../config/koneksi.php');

$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? date('Y');

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
    $sql.=" AND penggajian.bulan='$bulan'";
}

if($tahun!=""){
    $sql.=" AND penggajian.tahun='$tahun'";
}

$sql.=" ORDER BY pegawai.nama_pegawai ASC";

$query=mysqli_query($koneksi,$sql);

$pdf=new FPDF('L','mm','A4');

$pdf->AddPage();

$pdf->SetTitle("Laporan Penggajian");

$pdf->SetFont('Arial','B',18);

$pdf->Cell(0,10,'SISTEM INFORMASI PENGGAJIAN',0,1,'C');

$pdf->SetFont('Arial','',12);

$pdf->Cell(0,7,'Payroll Management System',0,1,'C');

$pdf->Ln(2);

$pdf->SetDrawColor(0,120,0);

$pdf->Line(10,30,287,30);

$pdf->Ln(5);

$pdf->SetFont('Arial','B',14);

$pdf->Cell(0,8,'LAPORAN PENGGAJIAN PEGAWAI',0,1,'C');

$pdf->Ln(3);

$pdf->SetFont('Arial','',11);

$pdf->Cell(30,7,'Periode',0,0);

$pdf->Cell(70,7,': '.($bulan==''?'Semua Bulan':$bulan).' '.$tahun,0,1);

$pdf->Cell(30,7,'Tanggal Cetak',0,0);

$pdf->Cell(70,7,': '.date('d-m-Y'),0,1);

$pdf->Ln(5);

/* HEADER */

$pdf->SetFillColor(220,220,220);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,10,'No',1,0,'C',true);
$pdf->Cell(65,10,'Nama Pegawai',1,0,'C',true);
$pdf->Cell(55,10,'Jabatan',1,0,'C',true);
$pdf->Cell(35,10,'Bulan',1,0,'C',true);
$pdf->Cell(20,10,'Tahun',1,0,'C',true);
$pdf->Cell(45,10,'Total Gaji',1,1,'C',true);

/* DATA */

$pdf->SetFont('Arial','',10);

$no=1;

$total=0;

while($d=mysqli_fetch_assoc($query))
{

$pdf->Cell(10,8,$no++,1,0,'C');

$pdf->Cell(65,8,$d['nama_pegawai'],1);

$pdf->Cell(55,8,$d['nama_jabatan'],1);

$pdf->Cell(35,8,$d['bulan'],1,0,'C');

$pdf->Cell(20,8,$d['tahun'],1,0,'C');

$pdf->Cell(45,8,'Rp '.number_format($d['total_gaji'],0,',','.'),1,1,'R');

$total += $d['total_gaji'];

}

/* TOTAL */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(185,9,'TOTAL PENGELUARAN',1,0,'R');

$pdf->Cell(45,9,'Rp '.number_format($total,0,',','.'),1,1,'R');

$pdf->Ln(18);

$pdf->SetFont('Arial','',11);

$pdf->Cell(0,7,'Mengetahui,',0,1,'R');

$pdf->Cell(0,7,'Pimpinan',0,1,'R');

$pdf->Ln(20);

$pdf->Cell(0,7,'(...............................)',0,1,'R');

$pdf->Output();

?>