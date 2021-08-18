<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
  header("location:./login.php");
}
if (!isset($_GET['id_user'])) {
  header("location:./index.php");
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
  <?php if ($_SESSION['level'] == "user") { ?>
    <title>Edit Profil | Sistem Informasi Ekstrakurikuler</title>
  <?php } else { ?>
    <title>Edit Data Siswa / User | Sistem Informasi Ekstrakurikuler</title>
  <?php } ?>
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
            <a class="nav-link" href="./data_ekstra.php">Ekstrakurikuler <span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./data_jurusan.php">Jurusan <span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./data_user.php"><b>Siswa </b><span class="sr-only"></span></a>
          </li>
          <?php
          if ($_SESSION['level'] == "superadmin") {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="./data_admin.php">Admin<span class="sr-only"></span></a>
            </li>
        <?php
          }
        }
        ?>

        <?php
        if ($_SESSION['level'] == "user") {
        ?>
          <li class="nav-item">
            <a class="nav-link" href="./data_ekstra.php">Ekstrakurikuler <span class="sr-only"></span></a>
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
      <?php if ($_SESSION['level'] == "user") { ?>
        <center>
          <h3>Edit Profil</h3>
        </center>
      <?php } else { ?>
        <center>
          <h3>Edit Data Siswa / User</h3>
        </center>
      <?php } ?>
    </div>
  </div>

  <!--todo container-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 offset-md-2">
        <div class="card">

          <?php
          $editDataUser = $_GET['id_user'];

          $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$editDataUser'");
          if (mysqli_num_rows($sql) == 0) {
            header("location:./index.php");
          } else {
            $row = mysqli_fetch_assoc($sql);
          }

          if ($_SESSION['id_log'] != $editDataUser && $_SESSION['level'] == "user") {
            header("location:./data_user.php");
          }

          ?>
          <div class="card-block">
            <form method="post" action="config/proses.php" name="formEditData">
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" class="form-control" id="idLogin" name="idLogin" value="<?php echo $idLogin; ?>" autocomplete="off" readonly hidden>
                  <input type="text" class="form-control" id="idUser" name="idUser" value="<?php echo $row['id']; ?>" autocomplete="off" readonly hidden>
                </div>
                <div class="form-group">
                  <label for="noHp">NIS (Nomor Induk Siswa)</label>
                  <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $row['nis']; ?>" maxlength="20" onkeypress="return hanyaAngka(event)" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="namaUser">Nama Lengkap</label>
                  <input type="text" class="form-control" id="namaUser" name="namaUser" value="<?php echo $row['nama']; ?>" onkeypress="return hanyaHuruf1(event)" oninvalid="setCustomValidity('Hanya dapat menginput alphabet. ')" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="tptLahir">Tempat Lahir</label>
                  <input type="text" class="form-control" id="tptLahir" name="tptLahir" value="<?php echo $row['tpt_lahir']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="tgLahir">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="tgLahir" name="tgLahir" value="<?php echo $row['tgl_lahir']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <select name="kelas" class="form-control" id="kelas" required>
                    <?php
                    if ($row['kelas'] == 'IX') {
                      echo "<option value='IX' selected>IX (Sembilan)</option>
                            <option value='X'>X (Sepuluh)</option>
                            <option value='XI'>XI (Sebelas)</option>";
                    } else if ($row['kelas'] == 'X') {
                      echo "<option value='IX'>IX (Sembilan)</option>
                            <option value='X' selected>X (Sepuluh)</option>
                            <option value='XI'>XI (Sebelas)</option>";
                    } else {
                      echo "<option value='IX'>IX (Sembilan)</option>
                            <option value='X'>X (Sepuluh)</option>
                            <option value='XI' selected>XI (Sebelas)</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="jurusan">Jurusan</label>
                  <select name="jurusan" class="form-control" id="jurusan" required>
                    <?php
                    $sql2 = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama ASC");
                    while ($row2 = mysqli_fetch_assoc($sql2)) {
                      $value = $row2['id'];
                      echo '<option value="' . $row2['id'] . '" ' . (($value == $row['id']) ? 'selected="selected"' : "") . '>'
                        . $row2['nama'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="noHp">No. HP</label>
                  <input type="text" class="form-control" id="noHp" name="noHp" value="<?php echo $row['no_hp']; ?>" required onkeypress="return hanyaAngka(event)" maxlength="15" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" onkeypress="return hanyaHuruf2(event)" oninvalid="setCustomValidity('Hanya dapat menginput alphabet. ')" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Minimal 6 Karakter" required>
                </div>
                <div class="modal-footer text-lg-center">
                  <a href="./data_user.php" class="btn btn-danger" id="kembali">Kembali</a>
                  <button type="submit" class="btn btn-primary" name="editDataUser">Edit</button>
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

  <!-- hanyaAngka -->
  <script type="text/javascript">
    function hanyaAngka(evt) {
      var charcode = event.keyCode;
      if (charcode > 31 && (charcode < 48 || charcode > 57))
        return false;
      return true;
    }
  </script>

  <!-- hanyaHuruf Spasi-->
  <script type="text/javascript">
    function hanyaHuruf1(evt) {
      var charcode = event.keyCode;
      if ((charcode < 97 || charcode > 122) && (charcode < 65 || charcode > 90) && (charcode != 32))
        return false;
      return true;
    }
  </script>

  <!-- hanyaHuruf username-->
  <script type="text/javascript">
    function hanyaHuruf2(evt) {
      var charcode = event.keyCode;
      if ((charcode < 97 || charcode > 122) && (charcode < 65 || charcode > 90))
        return false;
      return true;
    }
  </script>

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