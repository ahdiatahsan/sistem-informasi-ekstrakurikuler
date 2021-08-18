<?php
include "./config/koneksi.php";
include "./session_.php";
if (!isset($_SESSION['username'])) {
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
  <title>Data Ekstrakurikuler | Sistem Informasi Ekstrakurikuler</title>
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
        <h3>Data Ekstrakurikuler</h3>
      </center>
    </div>
  </div>


  <!--todo container-->
  <div class="container">

    <!--todo tabel ekstrakurikuler-->
    <div class="row">
      <?php
      if ($_SESSION['level'] != "user") {
      ?>
        <div class="col-lg-12 margin-bottom" align="center">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-md btn1" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-plus"></i>
            Tambah Data Ekstrakurikuler
          </button>
        </div>
      <?php } ?>

      <div class="col-lg-12 offset-lg-0">
        <table class="table table-hover table-bordered table-sm display nowrap table1" id="tabel" cellspacing="0">
          <thead class="thead-inverse">
            <tr>
              <th>No.</th>
              <th>Nama Ekstrakurikuler</th>
              <th>Pembimbing</th>
              <th>Jadwal</th>
              <th>Jumlah Anggota</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM ekstrakurikuler ORDER BY nama ASC");
            while ($row = mysqli_fetch_assoc($sql)) {
              $jam = strtotime($row['jam']);
              $id_ekstra = $row['id'];
            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><a href="img/artwork_storage/<?php echo $row['path_artwork'] ?>" target="_blank"><?php echo $row['nama']; ?></a></td>
                <td><?php echo $row['pembimbing']; ?></td>
                <td><?php echo "Hari " . $row['hari'] . ", Pukul " . date("H:i", $jam); ?></td>
                <td>
                  <?php
                  $sql2 = mysqli_query($koneksi, "SELECT * FROM user_ekstrakurikuler WHERE id_ekstra = '$id_ekstra'");
                  //var_dump($sql2);
                  $jumlah = mysqli_num_rows($sql2);
                  if ($jumlah == NULL) {
                    echo "0";
                  } else {
                    echo $jumlah;
                  }
                  ?>
                </td>
                <td style="text-align: center; width: 50px">
                  <?php
                  if ($_SESSION['level'] != "user") {
                  ?>
                    <a href="config/proses.php?hapusDataEkskul=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" id="hapusData" name="hapusDataEkskul"><i class="fas fa-times"></i></a>
                    <a href="./edit_ekstra.php?id_ekstra=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['level'] == "user") {
                  ?>
                    <a href="config/proses.php?idEkskul=<?php echo $row['id']; ?>&idUser=<?php echo $idLogin ?>" class="btn btn-success btn-sm" id="regisEkskul" name="regisEkskul"><i class="fas fa-check"></i> Registrasi</a>
                  <?php
                  }
                  ?>
                  <a href="./detail_ekstra.php?id_ekstra=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-search"></i></a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

    </div> <!-- end row -->

  </div>
  <!--end container-->

  <!--todo modal-->
  <!--modal tambah-->
  <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!--todo form tambah-->
      <form method="post" action="config/proses.php" name="tambahDataEkskul" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Tambah Data </h4>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="nama">Nama Ekstrakurikuler</label>
              <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="pembimbing">Nama Pembimbing</label>
              <input type="text" class="form-control" id="pembimbing" name="pembimbing" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="lokasi">Lokasi Kegiatan</label>
              <input type="text" class="form-control" id="lokasi" name="lokasi" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="hari">Hari</label>
              <select name="hari" class="form-control" id="hari" required>
                <?php
                $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
                foreach ($hari as $value => $label) {
                  $option .= "<option value=$label>" . ucfirst($label) . "</option>";
                }
                echo $option;
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="jam">Waktu / Jam kegiatan</label>
              <input type="time" class="form-control" id="jam" name="jam" autocomplete="off" required>
            </div>
            <div class="form-group">
              <div class="input-group-prepend">
                <label for="deskripsi">Deskripsi</label>
              </div>
              <textarea class="form-control" autocomplete="off" name="deskripsi"></textarea>
            </div>
            <div class="form-group">
              <label for="logo">Logo Ekstrakurikuler</label>
              <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
            </div>
            <div class="alert alert-danger" id="dvMsg" role="alert" style="display: none;">
              File Harus Dibawah 2MB Agar Dapat Diupload!
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnSubmit" name="tambahDataEkskul">Tambah</button>
            <input type="reset" value="Reset" class="btn btn-danger" id="resetForm">
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

  <!--javascript Modal Regis-->
  <script>
    $(document).on("click", "#regisEkskul", function(e) {
      var link = $(this).attr("href"); // mendapatkan link yang dimaksud
      e.preventDefault();

      swal({
          title: "Registrasi Di Ekskul Ini?",
          text: "Anda akan terdaftar sebagai anggota ekskul ini!",
          type: "success",
          showCancelButton: true,
          confirmButtonColor: "#5cb85c",
          confirmButtonText: "Ya, Daftar!",
          closeOnConfirm: true
        },
        function(result) {
          if (result) {
            document.location.href = link; // jika di klik ok maka menuju link pada atribut href
          }
        });
    });
  </script>

  <!-- cek size gambar yang ingin diupload -->
  <script type="text/javascript">
    $(function() {
      $('input[type=file]').change(function() {
        var submit = $("[id*=btnSubmit]");
        var browse = $("[id*=logo]");
        var size = parseFloat($("#logo")[0].files[0].size).toFixed(2);
        var Maxvalue = 2097152;
        if (size > Maxvalue) {
          $('#dvMsg')[0].style.display = 'block';
          submit.attr("disabled", "disabled");
          browse.attr("disabled", "disabled");
        } else {
          $('#dvMsg')[0].style.display = "none";
          submit.removeAttr("disabled");
          browse.removeAttr("disabled");
        }
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#resetForm").click(function(event) {
        event.preventDefault();
        $('#dvMsg')[0].style.display = "none";
        $("[id*=btnSubmit]").prop("disabled", false); // Element(s) are now enabled.
        $("[id*=logo]").prop("disabled", false); // Element(s) are now enabled.
        $(this).closest('form').find("input[type=file], #nama, #deskripsi").val("");
      });
    });
  </script>

</body>

</html>