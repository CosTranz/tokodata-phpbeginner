<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_tokodata");
if (mysqli_connect_errno()) {
    echo "Koneksi gagal: " .$koneksi->connect_error;
}else{
  
}

?>