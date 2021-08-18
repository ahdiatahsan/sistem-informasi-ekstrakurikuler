<?php
include "./config/koneksi.php";
session_start();
//cek session
$idLogin = $_SESSION['id_log'];
$namaUserLogin = $_SESSION['nama'];
$usernameSession = $_SESSION['username'];
$levelSession = $_SESSION['level'];
$sql = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$usernameSession'");
$row = mysqli_fetch_assoc($sql);
$loginSession = $row['username'];
