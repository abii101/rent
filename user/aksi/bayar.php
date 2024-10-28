<?php
session_start();
include "../../koneksi.php"; // Include your database connection

// Check if the id_kembali is set
if (isset($_GET['id_kembali'])) {
    $id_kembali = $_GET['id_kembali'];

    // Fetch kekurangan and denda from tbl_transaksi based on id_kembali
    $query = mysqli_query($koneksi, "SELECT t.kekurangan, k.denda, k.kondisi_mobil
                                      FROM tbl_transaksi t 
                                      JOIN tbl_kembali k ON t.id_transaksi = k.id_transaksi
                                      WHERE k.id_kembali = '$id_kembali' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    
    if ($data) {
        $kekurangan = $data['kekurangan'];
        $denda = $data['denda'];
        $total = $kekurangan + $denda; // Calculate the total amount to be paid
    } else {
        echo "Data not found.";
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tgl_bayar = $_POST['tgl_bayar'];
        $total_bayar = $_POST['total_bayar'];
        
        // Determine payment status
        $status = ($total_bayar >= $total) ? 'lunas' : 'belum lunas';

        // Insert into tbl_bayar
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_bayar (id_kembali, tgl_bayar, total_bayar, status) 
                                           VALUES ('$id_kembali', '$tgl_bayar', '$total_bayar', '$status')");

        if ($insert) {
            echo "<script>alert('Payment successful. Status: $status'); window.location.href='../databayar.php';</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
} else {
    echo "Invalid request.";
    exit;
}

// Get today's date in the required format (YYYY-MM-DD)
$today = date('Y-m-d');
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
    <link rel="stylesheet" href="../../template/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="../../template/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="../../template/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="../../template/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../../template/css/app-dark.css" id="darkTheme">
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
          <h2 class="my-3 mt-2">Bayar</h2>
          <div class="form-group">
            <label for="total"> Total Kekurangan </label>
            <input type="text" name="total" disabled value="<?php echo number_format($total, 2, ',', '.'); ?>" id="inputEmail" class="form-control form-control-lg" placeholder="Username" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="total"> Detail Kerusakan </label>
            <input type="text" name="total" disabled value="<?php echo $data['kondisi_mobil']; ?>" id="inputEmail" class="form-control form-control-lg" placeholder="Username" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="total"> Tanggal </label>
            <input type="date" disabled name="tgl_bayar" disabled value="<?php echo $today; ?>" id="inputEmail" class="form-control form-control-lg" placeholder="Username" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="total"> Total Bayar </label>
            <input type="number" name="total_bayar" id="inputPassword" class="form-control form-control-lg" placeholder="Jumlah Bayar" required="">
          </div>
          <br>
          <button class="btn btn-lg btn-primary btn-block mt-3" name="submit" type="submit">Bayar</button>
          <p class="mt-5 mb-3 text-muted">© 2020</p>
        </form>
      </div>
    </div>
    <script src="../../template/js/jquery.min.js"></script>
    <script src="../../template/js/popper.min.js"></script>
    <script src="../../template/js/moment.min.js"></script>
    <script src="../../template/js/bootstrap.min.js"></script>
    <script src="../../template/js/simplebar.min.js"></script>
    <script src='../../template/js/daterangepicker.js'></script>
    <script src='../../template/js/jquery.stickOnScroll.js'></script>
    <script src="../../template/js/tinycolor-min.js"></script>
    <script src="../../template/js/config.js"></script>
    <script src="../../template/js/apps.js"></script>
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