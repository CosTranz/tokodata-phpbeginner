<?php
session_start();

include 'config.php';

if (isset($_SESSION['pengguna'])) {
    $user = $_SESSION['pengguna'];
    $idusr = $user['user_id'];
    $nama = $user['name'];
} else {
    header('Location: login.php');
}

$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    // Modifikasi query SQL untuk mencari data yang sesuai dengan kata kunci
    $sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk 
            WHERE produk.nama_produk LIKE '%$keyword%' OR buku.nama_buku LIKE '%$keyword%' 
            ORDER BY produk.jenis_produk ASC";
} else {
    $sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk ORDER BY produk.jenis_produk ASC";
}

$query = mysqli_query($koneksi, $sql);

// Simpan data dalam bentuk array
$data = array();
$totalHarga = 0; // Menyimpan total harga
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
    $totalHarga += $row['harga']; // Menambahkan harga produk ke totalHarga
}

// Panggil fungsi untuk membuat laporan PDF
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Fungsi untuk membuat laporan PDF
function createPDFReport($data, $totalHarga)
{
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set judul laporan
    $pdf->SetTitle('Laporan Produk');

    // Tambahkan halaman
    $pdf->AddPage();

    // Buat tabel laporan
    $html = '<h2 style="text-align: center;">Laporan Produk</h2>';
    $html .= '<table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; text-align: center;">No</th>
                        <th style="padding: 10px; text-align: center;">Nama Produk</th>
                        <th style="padding: 10px; text-align: center;">Jenis Produk</th>
                        <th style="padding: 10px; text-align: center;">Nama Buku</th>
                        <th style="padding: 10px; text-align: center;">Penulis</th>
                        <th style="padding: 10px; text-align: center;">Penerbit</th>
                        <th style="padding: 10px; text-align: center;">Harga</th>
                        <th style="padding: 10px; text-align: center;">Foto</th>
                    </tr>
                </thead>
                <tbody>';

    $i = 1;
    foreach ($data as $row) {
        $html .= '<tr>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">' . $i . '</td>
                    <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">' . $row['nama_produk'] . '</td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">' . $row['jenis_produk'] . '</td>
                    <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">' . $row['nama_buku'] . '</td>
                    <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">' . $row['penulis'] . '</td>
                    <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">' . $row['penerbit'] . '</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">Rp' . number_format($row['harga'], 0, ',', '.') . '</td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;"><img src="' . $row['foto'] . '" alt="Foto Produk" style="max-width: 100px; max-height: 100px;"></td>
                </tr>';
        $i++;
    }

    $html .= '<tr>
                <td colspan="6" style="padding: 10px; text-align: right; border: 1px solid #ddd;">Total Harga:</td>
                <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">Rp' . number_format($totalHarga , 0, ',', '.'). '</td>
                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;"></td>
            </tr>';

    $html .= '</tbody></table>';

    // Tambahkan konten laporan ke PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Get the generated PDF document content
    $output = $pdf->Output('laporan_produk.pdf', 'S');

    // Output pdf akan otomatis ke browser
    header('Content-Type: application/pdf');
    echo $output;
}

// Panggil fungsi untuk membuat laporan PDF
createPDFReport($data, $totalHarga);
?>
