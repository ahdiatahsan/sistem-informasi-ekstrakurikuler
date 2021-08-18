<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
  header("location:./login.php");
}
if ($_SESSION['level'] == "user") {
  header("location:./login.php");
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
  <title>Data User | Sistem Informasi Ekstrakurikuler</title>
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
      <center>
        <h3>Data Siswa / User</h3>
      </center>
    </div>
  </div>

  <div class="col-lg-12 margin-bottom" align="center">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-md btn1" data-toggle="modal" data-target="#tambah">
      <i class="fa fa-plus"></i> Tambah Data Siswa/User
    </button>
  </div>

  <!--todo tabel-->
  <div class="row">

    <div class="offset-lg-1 col-lg-10 col-md-12 col-sm-12">
      <table class="table table-hover table-bordered table-sm display nowrap table1" id="tabel" cellspacing="0">
        <thead class="thead-inverse">
          <tr>
            <th>No.</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No. HP</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = mysqli_query($koneksi, "SELECT user.*, jurusan.nama AS jurusan FROM user INNER JOIN jurusan ON user.jurusan_id = jurusan.id WHERE user.level = 'user'");
          while ($row = mysqli_fetch_assoc($sql)) {
          ?>
            <tr>
              <td><?php echo $nomor++ ?></td>
              <td><?php echo $row['nis']; ?></td>
              <td><?php echo $row['nama']; ?></td>
              <td><?php echo $row['kelas']; ?></td>
              <td><?php echo $row['jurusan']; ?></td>
              <td><?php echo $row['no_hp']; ?></td>
              <td style="text-align: center; width: 50px">
                <center>
                  <a href="config/proses.php?hapusDataUser=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" id="hapusData" name="hapusDataUser"><i class="fas fa-times"></i></a>
                  <a href="./edit_user.php?id_user=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                  <a href="./detail_user.php?id_user=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-search"></i></a>
                </center>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
  <!--end tabel-->

  <!--todo modal-->
  <!--modal tambah-->
  <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!--todo form tambah-->
      <form method="post" action="config/proses.php" name="tambahDataUser">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Tambah Data </h4>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="noHp">NIS (Nomor Induk Siswa)</label>
              <input type="text" class="form-control" id="nis" name="nis" maxlength="20" onkeypress="return hanyaAngka(event)" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input type="text" class="form-control" id="namaUser" name="namaUser" onkeypress="return hanyaHuruf1(event)" oninvalid="setCustomValidity('Hanya dapat menginput alphabet. ')" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="tptLahir">Tempat Lahir</label>
              <input type="text" class="form-control" id="tptLahir" name="tptLahir" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="tgLahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tgLahir" name="tgLahir" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <select name="kelas" class="form-control" id="kelas" required>
                <option value="IX">IX (Sembilan)</option>
                <option value="X">X (Sepuluh)</option>
                <option value="XI">XI (Sebelas)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select name="jurusan" class="form-control" id="jurusan" required>
                <?php
                $sql2 = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama ASC");
                while ($row2 = mysqli_fetch_assoc($sql2)) {
                  $value = $row2['id'];
                  echo '<option value="' . $row2['id'] . '">' .  $row2['nama'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="noHp">No. HP</label>
              <input type="text" class="form-control" id="noHp" name="noHp" maxlength="15" onkeypress="return hanyaAngka(event)" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" pattern=".{6,}" autocomplete="off" placeholder="minimal 6 karakter" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn1" name="tambahDataUser">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>

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
      "sScrollX": "100%",
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