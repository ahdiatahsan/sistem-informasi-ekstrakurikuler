<?php
include "config/koneksi.php";

session_start();
if (isset($_SESSION['username'])) {
  header("location:./index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" charset="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/bootstrap-4-login/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.css">
  <link rel="stylesheet" href="css/login_style.css">
  <link rel="icon" href="img/icon.png">
  <title>Login | Sistem Informasi Ekstrakurikuler</title>
</head>

<body>

  <!--main content -->
  <div class="container-fluid">

    <div class="col-lg-12">

      <center>

        <h4 class="welcome" style="margin-top:125px;">SELAMAT DATANG DI <br> SISTEM INFORMASI EKSTRAKURIKULER</h4>

        <div class="col-lg-5 col-md-6 col-sm-8">

          <div class="card">
            <div class="card-body">
              <h6 class="card-title text-lg-center"><i class="fa fa-sign-in"></i> Masuk </h6>
              <hr>
              <form method="post">
                <div class="form-group">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" autocomplete="off" required>
                </div>

                <?php

                if (isset($_POST['kirim'])) {
                  $username = $_POST['username'];
                  $password = md5($_POST['password']);

                  $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
                  $count = mysqli_num_rows($sql);

                  if ($count == 0) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                              <strong>Username / Password Salah!</strong>
                              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>";
                  } else {
                    $row = mysqli_fetch_assoc($sql);
                    if ($row['level'] == 'admin') {
                      session_start();
                      $_SESSION['id_log'] = $row['id'];
                      $_SESSION['nama'] =  $row['nama'];
                      $_SESSION['username'] = $username;
                      $_SESSION['level'] = $row['level'];
                      header("location:./index.php");
                    } else {
                      session_start();
                      $_SESSION['id_log'] = $row['id'];
                      $_SESSION['nama'] =  $row['nama'];
                      $_SESSION['username'] = $username;
                      $_SESSION['level'] = $row['level'];
                      header("location:./index.php");
                    }
                  }
                }
                ?>

                <div class="text-lg-center text-md-center float-right">
                  <input type="reset" value="Reset" class="btn btn-danger">
                  <input type="submit" value="Login" class="btn btn-primary" name="kirim">
                </div>
              </form>
            </div>
            <div class="card-footer">
              <!-- <p style="margin-top: 10px;">@@@</a></p> -->
            </div>
          </div>
        </div>

      </center>

    </div>

  </div>

</body>

<!--javascript-->
<script src="javascript/jquery-3.2.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

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

</html>