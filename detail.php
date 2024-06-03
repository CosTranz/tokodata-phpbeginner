<?php
session_start();

include 'config.php';

if (isset($_SESSION['pengguna'])) {
    $user = $_SESSION['pengguna'];
    $idusr = $user['user_id'];
    $nama = $user['name'];
} else {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Query SQL untuk mendapatkan detail produk
    $sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk WHERE produk.id_produk = $id_produk";
    $query = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>

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

        .anav {
            text-decoration: none;
            color: white;
        }

        .product-image {
            max-width: 300px;
            max-height: 300px;
            margin-right: 20px;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <h3><a href="index.php" class="anav">BUKUTOPIA</a></h3>
            <div class="d-flex">
                <?php
                if ($user) {
                    echo '<span style="color: white;" class="me-2">' . $nama . ' (' . $idusr . ')</span>';
                    echo '<a href="logout.php" class="btn btn-sm btn-danger me-2">Logout</a>';
                    echo '<a href="tabel.php" class="btn btn-sm btn-primary me-2">Tabel</a>';
                    echo '<a href="gantiakun.php" class="btn btn-sm btn-primary">Ganti Akun</a>';
                } else {
                    echo '<a href="login.php" class="btn btn-sm btn-primary">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Detail Produk</h2>
        <div class="row">
            <div class="col-md-3">
                <?php if (!empty($data['foto'])) : ?>
                    <img src="<?= $data['foto'] ?>" alt="Foto Produk" class="product-image">
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <table class="table table-striped table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th>Nama Produk</th>
                            <td><?php echo $data['nama_produk'] ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Produk</th>
                            <td><?php echo $data['jenis_produk'] ?></td>
                        </tr>
                        <tr>
                            <th>Nama Buku</th>
                            <td><?php echo $data['nama_buku'] ?></td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td><?php echo $data['penulis'] ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td><?php echo $data['penerbit'] ?></td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp<?php echo number_format($data['harga'], 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="tabel.php" class="btn btn-primary btn-md">Kembali</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>