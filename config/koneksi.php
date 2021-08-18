<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_ekstrakurikuler");

if ($koneksi->connect_error) {
    echo "Koneksi Gagal";
}
