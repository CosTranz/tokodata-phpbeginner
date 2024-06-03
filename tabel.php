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

// Cek apakah ada kata kunci pencarian yang dikirimkan
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

// Jumlah data per halaman
$perPage = 5;

// Halaman saat ini
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Hitung jumlah data total
$queryTotal = mysqli_query($koneksi, $sql);
$totalData = mysqli_num_rows($queryTotal);

// Hitung jumlah halaman
$totalPages = ceil($totalData / $perPage);

// Batasan data yang diambil berdasarkan halaman saat ini
$limitStart = ($currentPage - 1) * $perPage;

// Modifikasi query SQL dengan LIMIT
$sql .= " LIMIT $limitStart, $perPage";

$query = mysqli_query($koneksi, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO DATA</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .navbar {
            background-color: #000080;
            padding: 10px;
        }

        .navbar h3 {
            color: #fff;
        }

        .container {
            margin-top: 20px;
        }

        .btn-danger {
            margin-left: 10px;
        }

        .anav {
            text-decoration: none;
            color: white;
        }

        .table {
            margin-top: 20px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: right;
        }

        .pagination a {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <h3><a href="index.php" class="anav">BUKUTOPIA</a></h3>
            <div>
                <?php
                echo '<span style="color: white;" class="me-2">' . $nama . ' (' . $idusr . ')</span>';
                echo '<a href="logout.php" class="btn btn-sm btn-danger me-2">Logout</a>';
                echo '<a href="tabel.php" class="btn btn-sm btn-primary me-2">Tabel</a>';
                echo '<a href="gantiakun.php" class="btn btn-sm btn-primary">Ganti Akun</a>';
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Masukkan kata kunci pencarian" value="<?php echo $keyword; ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <table class="table table-striped table-hover table-bordered">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cetakModal">
                Cetak Laporan
            </button>
            <!-- Modal Cetak -->
            <div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="cetakModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cetakModalLabel">Pilih Format Cetak</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <a href="cetakpdf.php" class="btn btn-success btn-block" id="pdf">Cetak PDF</a>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <a href="cetakexcel.php" class="btn btn-success btn-block" id="pdf">Cetak Excel</a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <a href="cetakword.php" class="btn btn-success btn-block" id="pdf">Cetak Word</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <thead class="table-dark ">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jenis Produk</th>
                    <th>Nama Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $data['nama_produk'] ?></td>
                        <td><?php echo $data['jenis_produk'] ?></td>
                        <td><?php echo $data['nama_buku'] ?></td>
                        <td><?php echo $data['penulis'] ?></td>
                        <td><?php echo $data['penerbit'] ?></td>
                        <td>Rp<?php echo number_format($data['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php if (!empty($data['foto'])) : ?>
                                <img src="<?php echo $data['foto'] ?>" alt="Foto" width="80" height="100">
                            <?php else : ?>
                                Tidak ada foto
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="detail.php?id=<?= $data['id_produk'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                            <a href="edit.php?id=<?= $data['id_produk'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <a href="hapus.php?id=<?= $data['id_produk'] ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>

        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="?page=<?php echo $currentPage - 1; ?>&keyword=<?php echo $keyword; ?>" class="btn btn-primary">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="?page=<?php echo $i; ?>&keyword=<?php echo $keyword; ?>" class="btn btn-primary <?php echo ($currentPage == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="?page=<?php echo $currentPage + 1; ?>&keyword=<?php echo $keyword; ?>" class="btn btn-primary">Next</a>
            <?php endif; ?>
        </div>

        <a href="tambah.php" class="btn btn-primary btn-md mb-3">Tambah Data</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


</body>

</html>