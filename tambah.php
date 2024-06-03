<?php
session_start();
if (isset($_SESSION['pengguna'])) {
    $user = $_SESSION['pengguna'];
    $idusr = $user['user_id'];
    $nama = $user['name'];
} else {
    header('Location: login.php');
}
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
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

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
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control form-control-alternative">
                <br>
                <label for="jenis_produk">Jenis Produk</label>
                <input type="text" name="jenis_produk" class="form-control form-control-alternative">
                <br>
                <label for="nama_barang">Nama Buku</label>
                <input type="text" name="nama_barang" class="form-control form-control-alternative">
                <br>
                <label for="penulis">Penulis</label>
                <input type="text" name="penulis" class="form-control form-control-alternative">
                <br>
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" class="form-control form-control-alternative">
                <br>
                <label for="harga">Harga</label>
                <input type="text" name="harga" class="form-control form-control-alternative">
                <br>
                <label for="foto">Foto</label>
                <input type="file" name="foto" class="form-control form-control-alternative">
                <br>
                <div class="row align-items-center">
                    <div class="col-8">
                        <a href="tabel.php" class="btn btn-block mt-3 mb-3">Kembali</a>
                    </div>
                    <div class="col-4">
                        <input type="submit" value="Simpan" class="btn btn-primary btn-md mt-3 mb-3">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    include 'config.php';
    if ($_POST) {
        // Upload file
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_ext = array("jpg", "jpeg", "png");

        if (in_array($foto_ext, $allowed_ext)) {
            $foto_path = "upload/" . uniqid() . ".$foto_ext";
            move_uploaded_file($foto_tmp, $foto_path);

            // Insert data into produk table
            $sql = "INSERT INTO produk (nama_produk, jenis_produk, harga) VALUES ('{$_POST['nama_produk']}', '{$_POST['jenis_produk']}', '{$_POST['harga']}')";
            $query = mysqli_query($koneksi, $sql);

            // Get the last inserted id_produk
            $last_id = mysqli_insert_id($koneksi);

            // Insert data into buku table
            $sql = "INSERT INTO buku (id_produk, nama_buku, penulis, penerbit, foto) VALUES ('$last_id', '{$_POST['nama_barang']}', '{$_POST['penulis']}', '{$_POST['penerbit']}', '$foto_path')";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                echo "Data berhasil disimpan";
                header('Location: tabel.php');
            } else {
                echo "Data gagal disimpan" . $koneksi->connect_error;
            }
        } else {
            echo "Ekstensi file yang diunggah tidak diizinkan.";
        }
    }
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
