<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
  header("location:./login.php");
}
if (!isset($_GET['id_user'])) {
  header("location:./index.php");
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
  <?php if ($_SESSION['level'] == "user") { ?>
    <title>Profil Saya | Sistem Informasi Ekstrakurikuler</title>
  <?php } else { ?>
    <title>Detail Data Siswa / User | Sistem Informasi Ekstrakurikuler</title>
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
            <a class="nav-link" href="./data_ekstra.php">Ekstrakurikuler <span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./detail_user.php?id_user=<?php echo $idLogin; ?>">
              <b>Profil </b><span class="sr-only"></span>
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
          <h3>Profil Saya</h3>
        </center>
      <?php } else { ?>
        <center>
          <h3>Detail Data Siswa / User</h3>
        </center>
      <?php } ?>
    </div>
  </div>

  <!--todo container-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="card">

          <?php
          $detailUser = $_GET['id_user'];

          $sql = mysqli_query($koneksi, "SELECT user.*, jurusan.nama as namajurusan FROM user INNER JOIN jurusan ON
                              user.jurusan_id = jurusan.id WHERE user.id='$detailUser'");
          if (mysqli_num_rows($sql) == 0) {
            header("location:./index.php");
          } else {
            $row = mysqli_fetch_assoc($sql);
          }

          if ($_SESSION['id_log'] != $detailUser && $_SESSION['level'] == "user") {
            header("location:./data_user.php");
          }

          ?>
          <div class="card-block">
            <form method="#" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-12" style="text-align: right;">
                    <a href="./edit_user.php?id_user=<?php echo $row['id']; ?>" class="btn btn-primary btn-md"><i class="fas fa-pencil-alt"> Edit Profil</i></a>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="nis">Nomor Induk Siswa</label>
                    <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $row['nis']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" autocomplete="off" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="tptlahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tptlahir" name="tptlahir" value="<?php echo $row['tpt_lahir']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="tgLahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tgLahir" name="tgLahir" value="<?php echo $row['tgl_lahir']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="noHp">Nomor Handphone</label>
                    <input type="text" class="form-control" id="noHp" name="noHp" value="<?php echo $row['no_hp']; ?>" autocomplete="off" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="klsjrs">Kelas - Jurusan</label>
                    <input type="text" class="form-control" id="klsjrs" name="klsjrs" value="<?php echo $row['kelas'] . " - " . $row['namajurusan']; ?>" autocomplete="off" readonly>
                  </div>
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

  <div class="container">
    <!--todo tabel ekstrakurikuler-->
    <center>
      <h4>Daftar Ekstrakurikuler Yang Diikuti</h4>
      <br>
    </center>
    <div class="row">

      <div class="col-lg-12 offset-lg-0">
        <table class="table table-hover table-bordered table-sm display nowrap table1" id="tabel" cellspacing="0">
          <thead class="thead-inverse">
            <tr>
              <th>No.</th>
              <th>Nama Ekstrakurikuler</th>
              <?php
              if ($_SESSION['level'] != "user") {
              ?>
                <th>Options</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql2 = mysqli_query($koneksi, "SELECT user_ekstrakurikuler.*, ekstrakurikuler.nama as namaekskul FROM user_ekstrakurikuler 
                                INNER JOIN ekstrakurikuler ON user_ekstrakurikuler.id_ekstra = ekstrakurikuler.id
                                WHERE id_user = '$detailUser' ORDER BY namaekskul ASC");
            while ($row2 = mysqli_fetch_assoc($sql2)) {
            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $row2['namaekskul']; ?></a></td>
                <?php
                if ($_SESSION['level'] != "user") {
                ?>
                  <td style="text-align: center; width: 50px">
                    <a href="config/proses.php?hapusUserEkskul=<?php echo $row2['id']; ?>" class="btn btn-danger btn-sm" id="hapusData" name="hapusDataEkskul"><i class="fas fa-times"></i> Keluarkan Anggota</a>
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
      "sScrollX": false,
      "bScrollCollapse": true,
      "columns": [{
          "width": "10%"
        },
        {
          "width": "60%"
        },
        {
          "width": "30%"
        }
      ]
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