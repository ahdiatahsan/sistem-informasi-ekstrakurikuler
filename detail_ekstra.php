<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
  header("location:./login.php");
}
if (!isset($_GET['id_ekstra'])) {
  header("location:./data_ekstra.php");
}

$nomor = 1;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" charset="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/icon.png">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.css">
  <link rel="stylesheet" href="assets/sweetalert/dist/sweetalert.css">
  <link rel="stylesheet" href="css/mainstyle.css">
  <link rel="stylesheet" href="assets/datatable/media/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/datatable/extensions/Responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/datatable/extensions/Scroller/css/scroller.bootstrap4.min.css">
  <title>Detail Ekstrakurikuler | Sistem Informasi Ekstrakurikuler</title>
</head>

<body>

  <!--todo navbar-->
  <nav class="navbar navbar-expand-sm bg-primary text-white" id="navbar">
    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-toggleable-md" id="navbarResponsive">
      <a class="navbar-brand hidden-sm-down hidden-md-down" href="#"><img src="img/icon.png" style="width: 70%;"></a>

      <ul class="nav navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Dashboard<span class="sr-only"></span></a>
        </li>
        <?php
        if ($_SESSION['level'] != "user") {
        ?>
          <li class="nav-item">
            <a class="nav-link" href="./data_ekstra.php"><b>Ekstrakurikuler </b><span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./data_jurusan.php">Jurusan <span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./data_user.php">Siswa <span class="sr-only"></span></a>
          </li>
          <?php
          if ($_SESSION['level'] == "superadmin") {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="./data_admin.php">Admin <span class="sr-only"></span></a>
            </li>
        <?php
          }
        }
        ?>

        <?php
        if ($_SESSION['level'] == "user") {
        ?>
          <li class="nav-item">
            <a class="nav-link" href="./data_ekstra.php"><b>Ekstrakurikuler </b><span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./detail_user.php?id_user=<?php echo $idLogin; ?>">
              Profil <span class="sr-only"></span>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>

      <span class="navbar-text float-xs-right">
        <a href="./logout.php" class="text-white btn btn-danger btn-sm" style="margin-left: 20px;" id="logout"><i class="fa fa-sign-out"></i> Logout</a>
      </span>

      <span class="navbar-text float-xs-right text-white">
        Welcome <b><?php echo $namaUserLogin ?></b>
      </span>

    </div>
  </nav>

  <!--content-->
  <div class="jumbotron">
    <div class="container">
      <center>
        <h3>Detail Data Ekstrakurikuler</h3>
      </center>
    </div>
  </div>

  <!--todo container-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="card">

          <?php
          $idDataEkskul = $_GET['id_ekstra'];
          $sql = mysqli_query($koneksi, "SELECT *, TIME_FORMAT(jam, '%H:%i') AS waktu FROM ekstrakurikuler WHERE id = '$idDataEkskul'");

          if (mysqli_num_rows($sql) == 0) {
            header("location:./data_ekstra.php");
          } else {
            $row = mysqli_fetch_assoc($sql);
            $id_ekstra = $row['id'];
            $sql2 = mysqli_query($koneksi, "SELECT * FROM user_ekstrakurikuler WHERE id_ekstra = '$id_ekstra'");
            $jumlah = mysqli_num_rows($sql2);
            if ($jumlah == NULL) {
              $jumlah == 0;
            }
          }

          ?>
          <div class="card-block">
            <form method="#" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" readonly hidden>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="nama">Nama Ekstrakurikuler</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="pembimbing">Nama Pembimbing</label>
                    <input type="text" class="form-control" id="pembimbing" name="pembimbing" value="<?php echo $row['pembimbing']; ?>" autocomplete="off" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="lokasi">Lokasi Kegiatan</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $row['lokasi']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="hari">Jadwal Kegiatan</label>
                    <input type="text" class="form-control" id="hari" name="hari" value="<?php echo $row['hari'] . ", Pukul " . $row['waktu']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="anggota">Jumlah Anggota</label>
                    <input type="text" class="form-control" id="anggota" name="anggota" value="<?php echo $jumlah; ?>" autocomplete="off" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" readonly><?php echo $row['deskripsi']; ?></textarea>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="logo"><br></label>
                    <img src="img/artwork_storage/<?php echo $row['path_artwork'] ?>" alt="logo" class="img-thumbnail mx-auto d-block" width="80%">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <br><br>
    <hr><br>
    <!--todo tabel ekstrakurikuler-->
    <center>
      <h4>Daftar Anggota <?php echo $row['nama']; ?></h4>
      <br>
    </center>
    <div class="row">
      <?php
      if ($_SESSION['level'] != "user") {
      ?>
        <div class="col-lg-12 margin-bottom" align="center">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-md btn1" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-plus"></i>
            Tambah Anggota
          </button>
        </div>
      <?php } ?>

      <div class="col-lg-12 offset-lg-0">
        <table class="table table-hover table-bordered table-sm display nowrap table1" id="tabel" cellspacing="0">
          <thead class="thead-inverse">
            <tr>
              <th>No.</th>
              <th>Nomor Induk Siswa</th>
              <th>Nama Lengkap</th>
              <th>Kelas - Jurusan</th>
              <?php
              if ($_SESSION['level'] != "user") {
              ?>
                <th>Options</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql3 = mysqli_query($koneksi, "SELECT user_ekstrakurikuler.*, user_ekstrakurikuler.id as idUserEkskul, user.*, user.id as idUser, jurusan.nama as namajurusan FROM user_ekstrakurikuler INNER JOIN user ON
                                            user_ekstrakurikuler.id_user = user.id INNER JOIN jurusan ON user.jurusan_id = jurusan.id 
                                            WHERE id_ekstra = '$idDataEkskul' ORDER BY user.nis ASC");
            while ($row3 = mysqli_fetch_assoc($sql3)) {
            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $row3['nis']; ?></a></td>
                <td><?php echo $row3['nama']; ?></a></td>
                <td><?php echo $row3['kelas'] . " - " . $row3['namajurusan']; ?></a></td>
                <?php
                if ($_SESSION['level'] != "user") {
                ?>
                  <td style="text-align: center; width: 50px">
                    <a href="config/proses.php?hapusUserEkskul=<?php echo $row3['idUserEkskul']; ?>" class="btn btn-danger btn-sm" id="hapusData" name="hapusDataEkskul"><i class="fas fa-times"></i> Keluarkan Anggota</a>
                    <a href="./detail_user.php?id_user=<?php echo $row3['idUser']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-search"></i> Detail Siswa</a>
                  </td>
                <?php
                }
                ?>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

    </div> <!-- end row -->
  </div>

  <!--todo modal-->
  <!--modal tambah-->
  <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!--todo form tambah-->
      <form method="post" action="config/proses.php" name="tambahAnggota">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Tambah Data </h4>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="namaekskul">Nama Ekstrakurikuler</label>
              <input type="text" class="form-control" id="namaekskul" name="namaekskul" value="<?php echo $row['nama']; ?>" autocomplete="off" readonly required>
              <input type="text" class="form-control" id="id_ekstra" name="id_ekstra" value="<?php echo $idDataEkskul ?>" autocomplete="off" hidden required>
            </div>
            <div class="form-group">
              <label for="id_user">Siswa / User</label>
              <select name="id_user" class="form-control" id="id_user" required>
                <?php
                $sql2 = mysqli_query($koneksi, "SELECT * FROM user WHERE level = 'user' ORDER BY nama ASC");
                while ($row2 = mysqli_fetch_assoc($sql2)) {
                  $value = $row2['id'];
                  echo '<option value="' . $row2['id'] . '">' .  $row2['nama'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="tambahAnggota">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <br>
  <!--footer-->
  <footer class="footer bg-inverse">
    <div class="container">
      <center>
        - @ABCD | Sistem Informasi Ekstrakurikuler -
      </center>
    </div>
  </footer>

  <!--Javascript-->
  <script src="javascript/jquery-3.2.1.min.js"></script>
  <script src="assets/sweetalert/dist/sweetalert.min.js"></script>
  <script src="assets/bootstrap/js/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/bootbox/bootbox.min.js"></script>
  <script src="assets/datatable/media/js/jquery.dataTables.min.js"></script>
  <script src="assets/datatable/media/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/datatable/extensions/Responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="assets/datatable/extensions/Scroller/js/dataTables.scroller.min.js"></script>

  <!-- logout -->
  <script>
    $(document).on("click", "#logout", function(e) {
      var link = $(this).attr("href"); // mendapatkan link yang dimaksud
      e.preventDefault();
      bootbox.confirm("<h4><i class='fa fa-sign-out'></i> Logout ?<h4>", function(result) {
        if (result) {
          document.location.href = link; // jika di klik ok maka menuju link pada atribut href
        }
      });
    });
  </script>

  <!--data table-->
  <script>
    $(document).ready(function() {
      $('#tabel').DataTable();
    });
  </script>

  <script>
    $('#tabel').dataTable({
      "info": false,
      "paging": true,
      "sScrollX": "110%",
      "bScrollCollapse": true
    });
  </script>

  <!--javascript Modal Delete-->
  <script>
    $(document).on("click", "#hapusData", function(e) {
      var link = $(this).attr("href"); // mendapatkan link yang dimaksud
      e.preventDefault();

      swal({
          title: "Anda Yakin?",
          text: "Data yang terhapus tidak dapat di recovery!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapus!",
          closeOnConfirm: true
        },
        function(result) {
          if (result) {
            document.location.href = link; // jika di klik ok maka menuju link pada atribut href
          }
        });
    });
  </script>

</body>

</html>