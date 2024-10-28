<?php
session_start();
if (isset($_SESSION['user'])) {
    // Include the database connection
    include "../koneksi.php";

    // Assuming $_SESSION['user'] was set during login
    $user = $_SESSION['user'];

    // Fetch user details from the database based on the user
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_member WHERE user = '$user' LIMIT 1");

    // Check if the user exists in the database
    if ($query && mysqli_num_rows($query) > 0) {
        // Fetch the user data from the query result
        $data = mysqli_fetch_assoc($query);

        // Set session variables with the user data
        $_SESSION['nik'] = $data['nik'];   // Storing NIK in session
        $_SESSION['nama'] = $data['nama']; // Example if you want to store the name as well
        $nik = $_SESSION['nik'];
        // Other session variables or logic based on user data
        // e.g., $_SESSION['email'] = $data['email'];

        // Redirect or load the rest of the page/dashboard
        // ... (rest of your dashboard code)
        
    } else {
        echo "Error fetching user data.";
    }
} else {
    // Redirect to login if the user is not logged in
    echo "<script>alert('HALAMAN INI HANYA UNTUK PENGGUNA'); window.location.href='../login.php';</script>";
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
    <title>Admin Page - Mobilitas</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../template/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="../template/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="../template/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="../template/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../template/css/app-dark.css" id="darkTheme">
  </head>
  <body class="vertical  dark  ">
    <div class="wrapper">
      <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <form class="form-inline mr-auto searchform text-muted">
          <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
        </form>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
              <i class="fe fe-sun fe-16"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
              <span class="fe fe-grid fe-16"></span>
            </a>
          </li>
          <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
              <span class="fe fe-bell fe-16"></span>
              <span class="dot dot-md bg-success"></span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="avatar avatar-sm mt-2">
                <img src="../template/assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">Settings</a>
              <a class="dropdown-item" href="#">Activities</a>
            </div>
          </li>
        </ul>
      </nav>
      <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
          <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
          <!-- nav bar -->
          <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
              <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                  <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                  <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                  <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                </g>
              </svg>
            </a>
          </div>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a href="dashboard.php" aria-expanded="false" class="nav-link">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Mobilitas</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2 mt-1">
            <li class="nav-item w-100">
              <a class="nav-link" href="datamobil.php">
                <i class="fe fe-truck fe-16"></i>
                <span class="ml-3 item-text">Data Mobil</span>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav flex-fill w-100 mb-2 mt-1">
            <li class="nav-item w-100">
              <a class="nav-link" href="datatrans.php">
                <i class="fe fe-shopping-bag fe-16"></i>
                <span class="ml-3 item-text">Data Transaksi</span>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav flex-fill w-100 mb-2 mt-1">
            <li class="nav-item w-100">
              <a class="nav-link" href="databayar.php">
                <i class="fe fe-book fe-16"></i>
                <span class="ml-3 item-text">Data Pembayaran</span>
              </a>
            </li>
          </ul>
          <p class="text-muted nav-heading mt-3 mb-1">
            <span>Data Akun</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2 mt-1">
            <li class="nav-item w-100">
              <a class="nav-link" href="datapetugas.php">
                <i class="fe fe-user-check fe-16"></i>
                <span class="ml-3 item-text">Data Petugas</span>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav flex-fill w-100 mb-2 mt-1">
            <li class="nav-item w-100">
              <a class="nav-link" href="datauser.php">
                <i class="fe fe-user fe-16"></i>
                <span class="ml-3 item-text">Data User</span>
              </a>
            </li>
          </ul>
          <div class="btn-box w-100 mt-4 mb-1">
            <a href="../logout.php" class="btn mb-2 btn-primary btn-lg btn-block">
              <i class="fe fe-power fe-12 mx-2"></i><span class="small">Log Out</span>
            </a>
          </div>
        </nav>
      </aside>
      <main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="page-title">Data Pembayaran</h2>
              <div class="row">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                      <h5 class="card-title">
                      <table class="table table-bordered table-hover mb-0">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Tgl. Kembali</th>
                            <th>Kekurangan</th>
                            <th>Denda</th>
                            <th>Total</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            include '../koneksi.php';
                            $no = 1;
                            $data = mysqli_query($koneksi, " SELECT t.kekurangan, k.id_kembali, k.id_transaksi, k.tgl_kembali, k.kondisi_mobil, k.denda
        FROM tbl_kembali k
        JOIN tbl_transaksi t ON k.id_transaksi = t.id_transaksi
        LEFT JOIN tbl_bayar b ON k.id_kembali = b.id_kembali
    ");
                            while($d = mysqli_fetch_array($data)) {
                              $total = $d['kekurangan'] + $d['denda'];
                        ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $d['tgl_kembali']; ?></td>
                              <td><?php echo number_format($d['kekurangan'], 2, ',', '.'); ?></td>
                              <td><?php echo number_format($d['denda'], 2, ',', '.'); ?></td>
                              <td><?php echo number_format($total, 2, ',', '.'); ?></td>
                              <td>  <a href=""disabled class="btn btn-primary w-100">-</a></td>
                          </tr>
                        <?php
                            }
                        ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div> <!-- Bordered table -->
                  <h2 class="page-title">Status Pembayaran</h2>
                  <!-- Bordered table -->
                <div class="col-md-12 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                      <h5 class="card-title">
                      <table class="table table-bordered table-hover mb-0">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            include '../koneksi.php';
                            $no = 1;
                            $data = mysqli_query($koneksi, "SELECT * FROM tbl_bayar; -- Replace '1234567890' with the specific nik
-- Replace '1234567890' with the specific nik
  ");
                            while($d = mysqli_fetch_array($data)) {
                        ?>
                          <tr>
                              <td><?php echo $no++ ?></td>                            
                              <td><?php echo number_format ($d['total_bayar'], 2, ',', '.'); ?></td>
                              <td><?php echo $d['status']; ?></td>
                              <td>  <?php if ($d['status'] == 'belum lunas') : ?>
        <a href=""disabled  class="btn btn-danger w-100">Belum Lunas</a>
    <?php elseif ($d['status'] == 'lunas') : ?>
        <span class="btn btn-success w-100" disabled>Sudah Lunas</span>
    <?php endif; ?></td>
                          </tr>
                        <?php
                            }
                        ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div> <!-- Bordered table -->
              </div> <!-- end section -->
            </div> <!-- .col-12 -->
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
        <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="list-group list-group-flush my-n3">
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-box fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Package has uploaded successfull</strong></small>
                        <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                        <small class="badge badge-pill badge-light text-muted">1m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-download fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Widgets are updated successfull</strong></small>
                        <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                        <small class="badge badge-pill badge-light text-muted">2m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-inbox fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Notifications have been sent</strong></small>
                        <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                        <small class="badge badge-pill badge-light text-muted">30m ago</small>
                      </div>
                    </div> <!-- / .row -->
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-link fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Link was attached to menu</strong></small>
                        <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                        <small class="badge badge-pill badge-light text-muted">1h ago</small>
                      </div>
                    </div>
                  </div> <!-- / .row -->
                </div> <!-- / .list-group -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body px-5">
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Control area</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Activity</p>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Droplet</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Upload</p>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Users</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Settings</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main> <!-- main -->
    </div> <!-- .wrapper -->
    <script src="../template/js/jquery.min.js"></script>
    <script src="../template/js/popper.min.js"></script>
    <script src="../template/js/moment.min.js"></script>
    <script src="../template/js/bootstrap.min.js"></script>
    <script src="../template/js/simplebar.min.js"></script>
    <script src='../template/js/daterangepicker.js'></script>
    <script src='../template/js/jquery.stickOnScroll.js'></script>
    <script src="../template/js/tinycolor-min.js"></script>
    <script src="../template/js/config.js"></script>
    <script src="../template/js/apps.js"></script>
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