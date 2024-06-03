<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Mendapatkan data dari database
include 'config.php';
$sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();

// Membuat lembar kerja aktif
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan judul kolom
$sheet->setCellValue('A1', 'Nama Produk');
$sheet->setCellValue('B1', 'Jenis Produk');
$sheet->setCellValue('C1', 'Nama Buku');
$sheet->setCellValue('D1', 'Penulis');
$sheet->setCellValue('E1', 'Penerbit');
$sheet->setCellValue('F1', 'Harga');
// $sheet->setCellValue('G1', 'Foto');

// Menambahkan data
$row = 2;
$totalHarga = 0; // Menyimpan total harga
foreach ($data as $item) {
    $sheet->setCellValue('A' . $row, $item['nama_produk']);
    $sheet->setCellValue('B' . $row, $item['jenis_produk']);
    $sheet->setCellValue('C' . $row, $item['nama_buku']);
    $sheet->setCellValue('D' . $row, $item['penulis']);
    $sheet->setCellValue('E' . $row, $item['penerbit']);
    $sheet->setCellValue('F' . $row, $item['harga']); // Tambahkan pemisah ribuan pada harga

    // // Menambahkan foto
    // $drawing = new Drawing();
    // $drawing->setName('Foto');
    // $drawing->setDescription('Foto Produk');
    // $drawing->setPath($item['foto']);
    // $drawing->setWidth(20);
    // $drawing->setHeight(20);
    // $drawing->setCoordinates('G'.$row);
    // $drawing->setOffsetX(5); // Menyesuaikan posisi horizontal
    // $drawing->setOffsetY(5); // Menyesuaikan posisi vertikal
    // $drawing->setWorksheet($sheet);

    $totalHarga += $item['harga']; // Menambahkan harga ke total

    $row++;
}

// Menambahkan total harga
$sheet->setCellValue('E' . $row, 'Total Harga:');
$sheet->setCellValue('F' . $row, $totalHarga); 

// Mengatur lebar kolom
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(15);
$sheet->getColumnDimension('G')->setWidth(15);

// Mengatur format judul kolom menjadi tebal dan warna latar biru
$sheet->getStyle('A1:F1')->getFont()->setBold(true);
$sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$sheet->getStyle('A1:F1')->getFill()->getStartColor()->setRGB('0000FF');
$sheet->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');

// Membuat objek writer
$writer = new Xlsx($spreadsheet);

// Menyimpan file Excel
$filename = 'laporan_produk.xlsx';
$writer->save($filename);

// Mengirim file Excel ke browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
