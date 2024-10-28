<?php
include 'koneksi.php';
session_start(); // Start the session

if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Check if user and password are not empty
    if (!empty($user) && !empty($pass)) {
        // First check tbl_user
        $query_user = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE user='$user'");
        $cek_user = mysqli_num_rows($query_user);

        if ($cek_user > 0) {
            // If user found in tbl_user, verify password
            $data_user = mysqli_fetch_array($query_user);
            $hash = $data_user['pass'];

            if (password_verify($pass, $hash)) {
                // Set session and redirect based on user level
                $_SESSION['user'] = $data_user['user'];
                $_SESSION['nik'] = null; // Set NIK to null for tbl_user
                $_SESSION['level'] = $data_user['lvl']; // Storing user level in the session

                if ($data_user['lvl'] == "admin") {
                    $_SESSION['lvl'] = 'admin'; // Set session for admin level
                    header('location:admin/dashboard.php'); // Redirect to admin dashboard
                } elseif ($data_user['lvl'] == "petugas") {
                    $_SESSION['lvl'] = 'petugas'; // Set session for petugas level
                    header('location:petugas/dashboard.php'); // Redirect to petugas dashboard
                }
                exit();
            } else {
                echo "<script>alert('Login gagal: password salah.');</script>";
            }
        } else {
            // If user not found in tbl_user, check tbl_member
            $query_member = mysqli_query($koneksi, "SELECT * FROM tbl_member WHERE user='$user'");
            $cek_member = mysqli_num_rows($query_member);

            if ($cek_member > 0) {
                // If user found in tbl_member, verify password
                $data_member = mysqli_fetch_array($query_member);
                $hash = $data_member['pass'];

                if (password_verify($pass, $hash)) {
                    // Set session and redirect to user dashboard
                    $_SESSION['user'] = $data_member['user'];
                    $_SESSION['nik'] = $data_member['nik']; // Storing NIK in session
                    $_SESSION['lvl'] = 'member'; // Set session for member level

                    header('location:user/dashboard.php');
                    exit();
                } else {
                    echo "<script>alert('Login gagal: password salah.');</script>";
                }
            } else {
                echo "<script>alert('Login gagal: username tidak ditemukan.');</script>";
            }
        }
    } else {
        echo "<script>alert('Harap isi username dan password.');</script>";
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
    <title>Mobilitas - Login</title>
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
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="" method="post">
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
          </a>
          <h2 class="my-3 mt-2">Sign In</h2>
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" name="user" id="inputEmail" class="form-control form-control-lg" placeholder="Username" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="pass" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required="">
          </div>
          <br>
          <button class="btn btn-lg btn-primary btn-block mt-3" name="login" type="submit">Let me in</button>
          <p class="mt-5 mb-3 text-muted">© 2020</p>
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