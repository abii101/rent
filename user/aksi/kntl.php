<?php
session_start();
include "../../koneksi.php"; // Include your database connection

// Check if the id_kembali is set
if (isset($_GET['id_kembali'])) {
    $id_kembali = $_GET['id_kembali'];

    // Fetch kekurangan and denda from tbl_transaksi based on id_kembali
    $query = mysqli_query($koneksi, "SELECT t.kekurangan, k.denda 
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
            echo "<script>alert('Payment successful. Status: $status'); window.location.href='databayar.php';</script>";
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
    <title>Bayar - Pembayaran</title>
    <link rel="stylesheet" href="../../template/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Bayar</h2>
    <p>Total yang harus dibayar: <?php echo number_format($total, 2, ',', '.'); ?></p>

    <form method="POST" action="">
        <div class="form-group">
            <label for="tgl_bayar">Tanggal Bayar:</label>
            <input type="date" name="tgl_bayar" class="form-control" value="<?php echo $today; ?>" required>
        </div>
        <div class="form-group">
            <label for="total_bayar">Total Bayar:</label>
            <input type="number" name="total_bayar" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Bayar</button>
    </form>
</div>
<script src="../../template/js/jquery.min.js"></script>
<script src="../../template/js/bootstrap.min.js"></script>
</body>
</html>
