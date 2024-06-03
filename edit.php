<?php
include 'config.php';

session_start();
ob_start();
if (isset($_SESSION['pengguna'])) {
    $user = $_SESSION['pengguna'];
    $idusr = $user['user_id'];
    $nama = $user['name'];
} else {
    header('Location: login.php');
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM produk INNER JOIN buku ON produk.id_produk=buku.id_produk WHERE produk.id_produk='$id'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO DATA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <form action="" method="post" name="tambah" onsubmit="return validateForm()" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id_produk'] ?>">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control form-control-alternative" value="<?= $data['nama_produk'] ?>">
                <br>
                <label for="jenis_produk">Jenis Produk</label>
                <input type="text" name="jenis_produk" class="form-control form-control-alternative" value="<?= $data['jenis_produk'] ?>">
                <br>
                <label for="nama_barang">Nama Buku</label>
                <input type="text" name="nama_barang" class="form-control form-control-alternative" value="<?= $data['nama_buku'] ?>">
                <br>
                <label for="penulis">Penulis</label>
                <input type="text" name="penulis" class="form-control form-control-alternative" value="<?= $data['penulis'] ?>">
                <br>
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" class="form-control form-control-alternative" value="<?= $data['penerbit'] ?>">
                <br>
                <label for="harga">Harga</label>
                <input type="text" name="harga" class="form-control form-control-alternative" value="<?= $data['harga'] ?>">
                <br>
                <label for="foto">Foto</label>
                <div>
                    <?php if (!empty($data['foto'])) : ?>
                        <img src="<?= $data['foto'] ?>" alt="Foto Produk" style="max-width: 200px; margin-bottom: 10px;">
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control form-control-alternative">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                </div>

                <div class="row align-items-center">
                    <div class="col-8">
                        <a href="tabel.php" class="btn btn-block mt-3 mb-3">Kembali</a>
                    </div>
                    <div class="col-4">
                        <input type="submit" value="Update" class="btn btn-sm btn-warning mt-3 mb-3">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_POST) {
        $nama_produk = $_POST['nama_produk'];
        $jenis_produk = $_POST['jenis_produk'];
        $harga = $_POST['harga'];
        $nama_buku = $_POST['nama_barang'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];

        $sql_produk = "UPDATE produk SET nama_produk = '$nama_produk', jenis_produk = '$jenis_produk', harga = '$harga' WHERE id_produk = '$id'";
        $sql_buku = "UPDATE buku SET nama_buku = '$nama_buku', penulis = '$penulis', penerbit = '$penerbit' WHERE id_produk = '$id'";

        $query_produk = mysqli_query($koneksi, $sql_produk);
        $query_buku = mysqli_query($koneksi, $sql_buku);

        if ($query_produk && $query_buku) {
            if (!empty($_FILES['foto']['name'])) {
                $foto_name = $_FILES['foto']['name'];
                $foto_tmp = $_FILES['foto']['tmp_name'];
                $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
                $allowed_ext = array("jpg", "jpeg", "png");
                // Hapus foto lama jika ada
                if (!empty($data['foto'])) {
                    unlink($data['foto']);
                }
                if (in_array($foto_ext, $allowed_ext)) {
                    $folder = "upload/";
                    $new_filename = uniqid() . ".$foto_ext";
                    $foto_path = $folder . $new_filename;

                    move_uploaded_file($foto_tmp, $foto_path);

                    $sql_foto = "UPDATE buku SET foto = '$foto_path' WHERE id_produk = '$id'";
                    $query_foto = mysqli_query($koneksi, $sql_foto);

                    if ($query_foto) {
                        echo "Data berhasil diupdate";
                        header('Location: tabel.php');
                        exit();
                    } else {
                        echo "Gagal mengupdate foto" . $koneksi->error;
                    }
                } else {
                    echo "Ekstensi file yang diunggah tidak diizinkan.";
                }
            } else {
                echo "Data berhasil diupdate";
                header('Location: tabel.php');
                exit();
            }
        } else {
            echo "Data gagal diupdate" . $koneksi->error;
        }
    }

    ob_end_flush();
    ?>

</body>

<script>
    function validateForm() {
        if (document.forms["tambah"]["nama_produk"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["nama_produk"].focus();
            return false;
        }
        if (document.forms["tambah"]["jenis_produk"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["jenis_produk"].focus();
            return false;
        }
        if (document.forms["tambah"]["nama_barang"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["nama_barang"].focus();
            return false;
        }
        if (document.forms["tambah"]["penulis"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["penulis"].focus();
            return false;
        }
        if (document.forms["tambah"]["penerbit"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["penerbit"].focus();
            return false;
        }
        if (document.forms["tambah"]["harga"].value == "") {
            alert("Tidak boleh ada kolom kosong");
            document.forms["tambah"]["harga"].focus();
            return false;
        }
        if (isNaN(document.forms["tambah"]["harga"].value)) {
            alert("Isi kolom harga harus berupa angka");
            document.forms["tambah"]["harga"].focus();
            return false;
        }
    }
</script>

</html>