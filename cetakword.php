<?php
require_once 'vendor/autoload.php';
include 'config.php';

use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;

// Inisialisasi objek PHPWord
$phpWord = new \PhpOffice\PhpWord\PhpWord();

// Buat halaman baru
$section = $phpWord->addSection();

// Tambahkan judul laporan
$section->addTitle('Laporan Produk', 1);

// Buat tabel laporan
$table = $section->addTable();
$table->addRow();
$cellStyle = array(
    'valign' => 'center',
    'borderSize' => 6,
    'borderColor' => '000000'
);
$table->addCell(1500, $cellStyle)->addText('Nama Produk');
$table->addCell(1500, $cellStyle)->addText('Jenis Produk');
$table->addCell(2000, $cellStyle)->addText('Nama Buku');
$table->addCell(2000, $cellStyle)->addText('Penulis');
$table->addCell(2000, $cellStyle)->addText('Penerbit');
$table->addCell(1000, $cellStyle)->addText('Harga (Rp)');
$table->addCell(1500, $cellStyle)->addText('Foto');

// Ambil data dari database
$sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk";
$query = mysqli_query($koneksi, $sql);

$totalHarga = 0; // Menyimpan total harga

while ($row = mysqli_fetch_assoc($query)) {
    $table->addRow();
    $table->addCell(1500, $cellStyle)->addText($row['nama_produk']);
    $table->addCell(1500, $cellStyle)->addText($row['jenis_produk']);
    $table->addCell(2000, $cellStyle)->addText($row['nama_buku']);
    $table->addCell(2000, $cellStyle)->addText($row['penulis']);
    $table->addCell(2000, $cellStyle)->addText($row['penerbit']);
    $table->addCell(2000, $cellStyle)->addText(number_format($row['harga'], 0, ',', '.'));

    // Menambahkan foto
    $imagePath = $row['foto'];
    $imageStyle = array(
        'width' => 50,
        'height' => 50,
        'align' => 'center'
    );
    $table->addCell(1500, $cellStyle)->addImage($imagePath, $imageStyle);

    // Menambahkan harga ke total
    $totalHarga += $row['harga'];
}

// Menambahkan baris total harga
$table->addRow();
$table->addCell(1500, $cellStyle)->addText('Total Harga:', array('bold' => true));
$table->addCell(1500, $cellStyle)->addText('');
$table->addCell(2000, $cellStyle)->addText('');
$table->addCell(2000, $cellStyle)->addText('');
$table->addCell(2000, $cellStyle)->addText('');
$table->addCell(2000, $cellStyle)->addText(number_format($totalHarga, 0, ',', '.'), array('bold' => true));
$table->addCell(1500, $cellStyle)->addText('');

// Simpan dokumen menjadi file Word
$filename = 'laporan_produk.docx';
$phpWord->save($filename);

// Set header untuk melakukan download file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Mengirim file ke output
readfile($filename);

// Hapus file setelah dikirim
unlink($filename);
?>
