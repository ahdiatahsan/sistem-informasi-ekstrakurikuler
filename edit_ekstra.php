<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
  header("location:./login.php");
}
if (!isset($_GET['id_ekstra'])) {
  header("location:./data_ekstra.php");
}
if ($_SESSION['level'] == "user") {
  header("location:./login.php");
}
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
  <title>Edit Ekstrakurikuler | Sistem Informasi Ekstrakurikuler</title>
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
        <h3>Edit Data Ekstrakurikuler</h3>
      </center>
    </div>
  </div>

  <!--todo container-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 offset-md-2">
        <div class="card">

          <?php
          $editDataEkskul = $_GET['id_ekstra'];
          $sql = mysqli_query($koneksi, "SELECT *, TIME_FORMAT(jam, '%H:%i') AS waktu FROM ekstrakurikuler WHERE id = '$editDataEkskul'");

          if (mysqli_num_rows($sql) == 0) {
            header("location:./data_ekstra.php");
          } else {
            $row = mysqli_fetch_assoc($sql);
          }

          ?>
          <div class="card-block">
            <form method="post" action="config/proses.php" name="formEditData" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" readonly hidden>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Ekstrakurikuler</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="pembimbing">Nama Pembimbing</label>
                  <input type="text" class="form-control" id="pembimbing" name="pembimbing" value="<?php echo $row['pembimbing']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="lokasi">Lokasi Kegiatan</label>
                  <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $row['lokasi']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="hari">Hari</label>
                  <select name="hari" class="form-control" id="hari" required>
                    <?php
                    $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
                    foreach ($hari as $value => $label) {
                      if ($label == $row['hari']) {
                        $sel = "selected";
                      } else {
                        $sel = "";
                      }
                      $option .= "<option $sel value=$label>" . ucfirst($label) . "</option>";
                    }
                    echo $option;
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="jam">Waktu / Jam kegiatan</label>
                  <input type="time" class="form-control" id="jam" name="jam" value="<?php echo $row['waktu']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <div class="input-group-prepend">
                    <label for="deskripsi">Deskripsi</label>
                  </div>
                  <textarea class="form-control" name="deskripsi"><?php echo $row['deskripsi']; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="logo">Logo Ekstrakurikuler <sup class="text-sm text-warning">*Tidak Harus</sup></label>
                  <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                </div>
                <div class="modal-footer text-lg-center">
                  <a href="./data_artwork.php" class="btn btn-danger">Kembali</a>
                  <button type="submit" class="btn btn-primary" name="editDataEkskul">Edit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
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

</body>

</html>