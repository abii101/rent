<?php
include "koneksi.php";


if (isset($_POST['submit'])) {
    // Mengecek apakah semua field form diisi
    if (isset($_POST['nik']) && isset($_POST['nama']) && isset($_POST['jk']) && isset($_POST['telp']) && isset($_POST['alamat']) && isset($_POST['user']) && isset($_POST['pass'])) {
        
        // Mendapatkan data dari form
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $jk = $_POST['jk'];
        $telp = $_POST['telp'];
        $alamat = $_POST['alamat'];
        $user = $_POST['user'];
        $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT); // Hashing password

        // Query untuk memasukkan data ke tabel tbl_member
        $sql = "INSERT INTO tbl_member VALUES ('$nik', '$nama', '$jk', '$telp', '$alamat', '$user', '$pass')";

        if ($koneksi->query($sql) === TRUE) {
            echo "<script>alert('Pendaftaran berhasil!');</script>";
        } else {
            echo "<script>alert('Error: " . addslashes($koneksi->error) . "');</script>";
        }

    } else {
        // Jika form tidak diisi lengkap
        echo "<script>alert('Harap isi semua field yang diperlukan.');</script>";
    }
} 

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Mobilitas - Daftar</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="template/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="template/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="template/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="template/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="template/css/app-dark.css" id="darkTheme">
  </head>  
  <body class="dark ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <form class="col-lg-6 col-md-8 col-10 mx-auto" action="" method="post">
          <div class="mx-auto text-center my-4">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
              <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                  <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                  <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                  <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                </g>
              </svg>
            </a>
            <br>
            <h2 class="my-3 mt-2">Mobilitas - Daftar</h2>
          </div>
          <div class="form-group">
            <label for="inputEmail4">NIK</label>
            <input type="number" name="nik" class="form-control" id="inputEmail4">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="firstname">Nama Lengkap</label>
              <input type="text" name="nama" autocomplete="off" id="firstname" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="lastname">No. Telp</label>
              <input type="number" name="telp" id="lastname" class="form-control">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-9">
              <label for="firstname">Alamat</label>
              <input type="text" name="alamat" autocomplete="off" id="firstname" class="form-control">
            </div>
            <div class="form-check form-check-inline col-md-3">
              <input class="form-check-input" type="radio" name="jk" id="jkLaki" value="L" required>
              <label class="form-check-label" for="jkLaki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline col-md-3">
              <input class="form-check-input" type="radio" name="jk" id="jkPerempuan" value="P" required>
              <label class="form-check-label" for="jkPerempuan">Perempuan</label>
            </div>
          </div>
          <hr class="my-4">
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputPassword5">Username</label>
                <input type="text" name="user" class="form-control" id="inputPassword5">
              </div>
              <div class="form-group">
                <label for="inputPassword6">Password</label>
                <input type="password" name="pass" class="form-control" id="inputPassword6">
              </div>
            </div>
            <div class="col-md-6">
              <p class="mb-2">Password requirements</p>
              <p class="small text-muted mb-2"> To create a new password, you have to meet all of the following requirements: </p>
              <ul class="small text-muted pl-4 mb-0">
                <li> Minimum 8 character </li>
                <li>At least one special character</li>
                <li>At least one number</li>
                <li>Can’t be the same as a previous password </li>
              </ul>
            </div>
          </div>
          <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign up</button>
          <p class="mt-5 mb-3 text-muted text-center">© 2020</p>
        </form>
      </div>
    </div>
    <script src="template/js/jquery.min.js"></script>
    <script src="template/js/popper.min.js"></script>
    <script src="template/js/moment.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
    <script src="template/js/simplebar.min.js"></script>
    <script src='template/js/daterangepicker.js'></script>
    <script src='template/js/jquery.stickOnScroll.js'></script>
    <script src="template/js/tinycolor-min.js"></script>
    <script src="template/js/config.js"></script>
    <script src="template/js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
</body>
</html>