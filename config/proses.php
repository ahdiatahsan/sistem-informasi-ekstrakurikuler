<?php
include "koneksi.php";

// USER dan ADMIN//
//  todo tambah data user
if (isset($_POST['tambahDataUser'])) {

    $nis = $_POST['nis'];
    $namaUser = $_POST['namaUser'];
    $tptLahir = $_POST['tptLahir'];
    $tgLahir = $_POST['tgLahir'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $noHp = $_POST['noHp'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO user VALUES (NULL, '$nis', '$namaUser', '$tptLahir', '$tgLahir', '$alamat', '$kelas', '$jurusan', '$noHp', '$username', '$password', 'user')";

    if ($koneksi->query($sql) == true) {
        header("location:../data_user.php");
    } else {
        echo '<script>
              alert("Gagal Menambahkan Data User");
              window.history.back();
              </script>';
    }

    //  todo tambah data admin
} else if (isset($_POST['tambahDataAdmin'])) {

    $namaAdmin = $_POST['namaAdmin'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $noHp = $_POST['noHp'];

    $sql = "INSERT INTO user VALUES (NULL, NULL, '$namaAdmin', NULL, NULL, NULL, NULL, NULL, '$noHp', '$username', '$password', 'admin')";

    if ($koneksi->query($sql) == true) {
        header("location:../data_admin.php");
    } else {
        echo '<script>
              alert("Gagal Menambahkan Data Admin");
              window.history.back();
              </script>';
    }

    //  todo hapus data user
} else if (isset($_GET['hapusDataUser'])) {

    $id_user = $_GET['hapusDataUser'];
    $sql = "DELETE FROM user WHERE id = '$id_user'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_user.php");
    } else {
        echo '<script>
            alert("Gagal Menghapus Data User");
            window.history.back();
            </script>';
    }

    //  todo hapus data admin
} else if (isset($_GET['hapusDataAdmin'])) {

    $id_admin = $_GET['hapusDataAdmin'];
    $sql = "DELETE FROM user WHERE id = '$id_admin'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_admin.php");
    } else {
        echo '<script>
            alert("Gagal Menghapus Data Admin");
            window.history.back();
            </script>';
    }

    //  todo edit data user
} else if (isset($_POST['editDataUser'])) {

    $idLogin  = $_POST['idLogin'];
    $idUser   = $_POST['idUser'];
    $nis = $_POST['nis'];
    $namaUser = $_POST['namaUser'];
    $tptLahir = $_POST['tptLahir'];
    $tgLahir = $_POST['tgLahir'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $noHp = $_POST['noHp'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "UPDATE user SET nis = '$nis', nama = '$namaUser', tpt_lahir = '$tptLahir', tgl_lahir = '$tgLahir', alamat = '$alamat',
            kelas = '$kelas', jurusan_id = '$jurusan', username = '$username', password = '$password', no_hp = '$noHp' 
            WHERE id = '$idUser'";

    if ($koneksi->query($sql) == true) {
        if ($idLogin == $idUser) {
            session_start();
            session_unset();
            header("location:../index.php");
        } else {
            header("location:../data_user.php");
        }
    } else {
        echo "error :";
        //TAMPILKAN NAMA NOMOR DAN DESKRIPSI ERRORNYA
        echo mysqli_errno($koneksi) . " : ";
        echo mysqli_error($koneksi);
    }

    //  todo edit data admin
} else if (isset($_POST['editDataAdmin'])) {

    $idAdmin     = $_POST['idAdmin'];
    $namaAdmin  = $_POST['namaAdmin'];
    $username   = $_POST['username'];
    $password   = md5($_POST['password']);
    $no_hp      = $_POST['no_hp'];

    $sql = "UPDATE user SET nama = '$namaAdmin', username = '$username',
    password = '$password', no_hp = '$no_hp' WHERE id = '$idAdmin'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_admin.php");
    } else {
        echo '<script>
            alert("Gagal Mengedit Data Admin");
            window.history.back();
            </script>';
    }
}


// JURUSAN //
//  todo tambah data jurusan
if (isset($_POST['tambahDataJurusan'])) {

    $nama = $_POST['nama'];

    $sql = "INSERT INTO jurusan VALUES (NULL, '$nama')";

    if ($koneksi->query($sql) == true) {
        header("location:../data_jurusan.php");
    } else {
        echo '<script>
          alert("Gagal Menambahkan Data Jurusan");
          window.history.back();
          </script>';
    }

    //  todo hapus data Jurusan
} else if (isset($_GET['hapusDataJurusan'])) {

    $id = $_GET['hapusDataJurusan'];
    $sql = "DELETE FROM jurusan WHERE id = '$id'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_jurusan.php");
    } else {
        echo '<script>
          alert("Gagal Menghapus Data Jurusan");
          window.history.back();
          </script>';
    }

    //  todo edit data Jurusan
} else if (isset($_POST['editDataJurusan'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];

    $sql = "UPDATE jurusan SET nama = '$nama' WHERE id = '$id'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_jurusan.php");
    } else {
        echo '<script>
          alert("Gagal Mengedit Data Jurusan");
          window.history.back();
          </script>';
    }
}


// EKSTRAKURIKULER //
//  todo tambah data ekstrakurikuler
if (isset($_POST['tambahDataEkskul'])) {

    $allowed = array("jpeg", "jpg", "png");
    $logo_name = $_FILES['logo']['name'];
    $logo_url = $_FILES['logo']['tmp_name'];
    $logo_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);

    $nama = $_POST['nama'];
    $pembimbing = $_POST['pembimbing'];
    $lokasi = $_POST['lokasi'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "INSERT INTO ekstrakurikuler VALUES (NULL, '$nama', '$pembimbing', '$lokasi', '$hari', '$jam', '$deskripsi','$logo_name')";

    if (!in_array($logo_extension, $allowed)) { //cek ekstensi file upload
        echo '<script>
          alert("Gagal Menambahkan Logo Ekstrakurikuler, File Harus Gambar");
          window.history.back();
          </script>';
    } else { //jika syarat terpenuhi, pindahkan file ke storage dan jalankan query
        move_uploaded_file($logo_url, "../img/artwork_storage/$logo_name");
        mysqli_query($koneksi, $sql);
        header("location:../data_ekstra.php");
    }

    //  todo hapus data ekstrakurikuler
} else if (isset($_GET['hapusDataEkskul'])) {

    $id           = $_GET['hapusDataEkskul'];
    $query_hapus  = "SELECT path_artwork FROM ekstrakurikuler WHERE id = '$id'";
    $hapus_gambar = mysqli_query($koneksi, $query_hapus);
    $data         = mysqli_fetch_assoc($hapus_gambar);

    unlink("../img/artwork_storage/" . $data['path_artwork']);

    $sql          = "DELETE FROM ekstrakurikuler WHERE id = '$id'";

    if ($koneksi->query($sql) == true) {
        header("location:../data_ekstra.php");
    } else {
        echo '<script>
          alert("Gagal Menghapus Data Ekstrakurikuler");
          window.history.back();
          </script>';
    }

    //  todo edit data ekstrakurikuler
} else if (isset($_POST['editDataEkskul'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $pembimbing = $_POST['pembimbing'];
    $lokasi = $_POST['lokasi'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $deskripsi = $_POST['deskripsi'];

    $logo_name = $_FILES['logo']['name'];
    $allowed = array("jpeg", "jpg", "png");
    $logo_url = $_FILES['logo']['tmp_name'];
    $logo_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);

    $logo_query = "SELECT * FROM ekstrakurikuler WHERE id='$id'";
    $logo_query_run = mysqli_query($koneksi, $logo_query);
    foreach ($logo_query_run as $row) {
        if ($logo_name == NULL) {
            $logo = $row['path_artwork'];
        } else {
            if ($logo_path = "../img/artwork_storage/" . $row['path_artwork']) {
                unlink($logo_path);
                $logo = $logo_name;
            }
        }
    }

    $sql = "UPDATE ekstrakurikuler SET nama = '$nama', pembimbing = '$pembimbing', lokasi = '$lokasi',
            hari = '$hari', jam = '$jam', deskripsi = '$deskripsi', path_artwork = '$logo' WHERE id = '$id'";
    $query_run = mysqli_query($koneksi, $sql);

    if ($query_run) {
        if ($logo_name == NULL) {
            header("location:../data_ekstra.php");
        } else {
            if (!in_array($logo_extension, $allowed)) { //cek ekstensi file upload
                echo '<script>
                  alert("Gagal Menambahkan Logo Ekstrakurikuler, File Harus Gambar");
                  window.history.back();
                  </script>';
            } else { //jika syarat terpenuhi, pindahkan file ke storage dan jalankan query
                move_uploaded_file($logo_url, "../img/artwork_storage/$logo_name");
                header("location:../data_ekstra.php");
            }
        }
    } else {
        echo '<script> alert("Gagal Mengedit Data Ekstrakurikuler");
                window.history.back();
              </script>';
    }
}


// USER EKSTRAKURIKULER //
// todo tambah data user ekstrakurikuler (sup/admin)
if (isset($_POST['tambahAnggota'])) {

    $id_ekstra = $_POST['id_ekstra'];
    $id_user = $_POST['id_user'];

    $sql = "INSERT INTO user_ekstrakurikuler VALUES (NULL, '$id_user', '$id_ekstra')";

    $sql2 = mysqli_query($koneksi, "SELECT * FROM user_ekstrakurikuler WHERE id_ekstra = '$id_ekstra' AND 
                                    id_user = '$id_user'");

    if (mysqli_num_rows($sql2) > 0) {
        echo '<script>
              alert("Gagal Menambahkan, Anggota Sudah Terdaftar Sebelumnya");
              window.history.back();
              </script>';
    } else {
        if ($koneksi->query($sql) == true) {
            echo '<script>
              alert("Berhasil Menambahkan Anggota");
              window.history.back();
              </script>';
        } else {
            echo '<script>
              alert("Gagal Menambahkan Data Anggota");
              window.history.back();
              </script>';
        }
    }

    //  todo tambah data user ekstrakurikuler (user)
} else if (isset($_GET['idEkskul'], $_GET['idUser'])) {

    $id_ekstra = $_GET['idEkskul'];
    $id_user = $_GET['idUser'];

    $sql = "INSERT INTO user_ekstrakurikuler VALUES (NULL, '$id_user', '$id_ekstra')";

    $sql2 = mysqli_query($koneksi, "SELECT * FROM user_ekstrakurikuler WHERE id_ekstra = '$id_ekstra' AND 
                                    id_user = '$id_user'");

    if (mysqli_num_rows($sql2) > 0) {
        echo '<script>
              alert("Gagal Menambahkan, Anggota Sudah Terdaftar Sebelumnya");
              window.history.back();
              </script>';
    } else {
        if ($koneksi->query($sql) == true) {
            echo '<script>
              alert("Anda Ditambahkan Sebagai Anggota");
              window.history.back();
              </script>';
        } else {
            echo '<script>
              alert("Gagal Menambahkan Data Anggota");
              window.history.back();
              </script>';
        }
    }

    //  todo hapus data user ekstrakurikuler
} else if (isset($_GET['hapusUserEkskul'])) {

    $id = $_GET['hapusUserEkskul'];
    $sql = "DELETE FROM user_ekstrakurikuler WHERE id = '$id'";

    if ($koneksi->query($sql) == true) {
        echo '<script>
          alert("Berhasil Menghapus Status Keanggotaan Siswa");
          window.history.back();
          </script>';
    } else {
        echo '<script>
          alert("Gagal Menghapus Data Jurusan");
          window.history.back();
          </script>';
    }
}
