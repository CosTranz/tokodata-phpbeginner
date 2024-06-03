<?php

include 'config.php';

$id = (int) $_GET['id'];

if ($id) {
    $sql = "DELETE FROM buku WHERE id_produk='{$id}'";
    $query = mysqli_query($koneksi, $sql);

    $sql = "DELETE FROM produk WHERE id_produk='{$id}'";
    $query = mysqli_query($koneksi, $sql);

}

header('Location: tabel.php');
exit;
?>