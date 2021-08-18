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
  <title>Sistem Informasi Ekstrakurikuler</title>
</head>

<body>

  <!--todo navbar-->
  <nav class="navbar navbar-expand-sm bg-primary text-white" id="navbar">
    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-toggleable-md" id="navbarResponsive">
      <a class="navbar-brand hidden-sm-down hidden-md-down" href="#"><img src="img/icon.png" style="width: 70%;"></a>

      <ul class="nav navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="./index.php"><b>Dashboard</b><span class="sr-only"></span></a>
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
        <h3>Selamat Datang</h3>
      </center>
    </div>
  </div>

  <!-- card -->
  <?php
  if ($_SESSION['level'] == "superadmin" || $_SESSION['level'] == "admin") {
  ?>
    <div class="row" style="margin-bottom: 30px;">

      <div class="offset-lg-1 col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="card card-1">
          <div class="card-block info-box">
            <i class="fas fa-address-card"></i>
            <div class="count">
              <?php
              $qry = mysqli_query($koneksi, "SELECT id FROM user WHERE level = 'user'");
              $count = mysqli_num_rows($qry);
              if ($count == 0) {
                echo "0";
              } else {
                echo $count;
              }
              ?>
            </div>
            <div class="title">Jumlah Siswa / User</div>
          </div>
        </div>
      </div>

      <div class="offset-lg-0 col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="card card-2">
          <div class="card-block info-box">
            <i class="fas fa-running"></i>
            <div class="count">
              <?php
              $qry = mysqli_query($koneksi, "SELECT id FROM ekstrakurikuler");
              $count = mysqli_num_rows($qry);
              if ($count == 0) {
                echo "0";
              } else {
                echo $count;
              }
              ?>
            </div>
            <div class="title">Jumlah Data Ekstrakurikuler</div>
          </div>
        </div>
      </div>

      <div class="offset-lg-1 col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="card card-3">
          <div class="card-block info-box">
            <i class="fas fa-shapes"></i>
            <div class="count">
              <?php
              $qry = mysqli_query($koneksi, "SELECT id FROM jurusan");
              $count = mysqli_num_rows($qry);
              if ($count == 0) {
                echo "0";
              } else {
                echo $count;
              }
              ?>
            </div>
            <div class="title">Jumlah Data Jurusan</div>
          </div>
        </div>
      </div>

      <div class="offset-lg-0 col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="card card-4">
          <div class="card-block info-box">
            <i class="fas fa-user-cog"></i>
            <div class="count">
              <?php
              $qry = mysqli_query($koneksi, "SELECT id FROM user WHERE level = 'admin'");
              $count = mysqli_num_rows($qry);
              if ($count == 0) {
                echo "0";
              } else {
                echo $count;
              }
              ?>
            </div>
            <div class="title">Jumlah Administrator</div>
          </div>
        </div>
      </div>

    </div>
  <?php
  }
  ?>

  <div class="row margin-bottom1">
    <div class="col-lg-12" style="margin-top: 20px;">

      <?php
      if ($_SESSION['level'] == "user") {
      ?>
        <div class="offset-lg-1 col-lg-4 offset-md-1 col-md-4">
          <img class="image-fluid img-size" src="img/community.png" alt="Community">
        </div>

        <div class="offset-lg-1 col-lg-5 offset-md-1 col-md-4">
          <div class="card card-border">
            <div class="card-body">
              <p class="card-text mx-auto d-block">
              <h2>Sistem Informasi Ekstrakurikuler</h2>
              <br>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum facere doloremque nesciunt pariatur
              quidem impedit explicabo, amet blanditiis voluptatum nihil laborum ullam suscipit recusandae
              temporibus atque voluptatem. Ipsam, est impedit!
              <br><br>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum facere doloremque nesciunt pariatur
              quidem impedit explicabo, amet blanditiis voluptatum nihil laborum ullam suscipit recusandae
              temporibus atque voluptatem. Ipsam, est impedit!
              </p>
            </div>
          </div>
        </div>

      <?php
      }
      ?>

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

</body>

</html>