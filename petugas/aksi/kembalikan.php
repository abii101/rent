<?php
include "../../koneksi.php"; // Pastikan koneksi database sudah benar

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Ambil informasi transaksi (tgl_kembali, nopol)
    $query_transaksi = "SELECT tgl_kembali, nopol FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi'";
    $result_transaksi = mysqli_query($koneksi, $query_transaksi);
    
    if ($result_transaksi && mysqli_num_rows($result_transaksi) > 0) {
        $row_transaksi = mysqli_fetch_assoc($result_transaksi);
        $tgl_kembali_transaksi = $row_transaksi['tgl_kembali'];
        $nopol = $row_transaksi['nopol'];
        
        // Ambil harga mobil berdasarkan nopol
        $query_mobil = "SELECT harga FROM tbl_mobil WHERE nopol = '$nopol'";
        $result_mobil = mysqli_query($koneksi, $query_mobil);
        
        if ($result_mobil && mysqli_num_rows($result_mobil) > 0) {
            $row_mobil = mysqli_fetch_assoc($result_mobil);
            $harga_per_hari = $row_mobil['harga'];
        } else {
            echo "Error: Mobil tidak ditemukan.";
            exit;
        }
    } else {
        echo "Error: Transaksi tidak ditemukan.";
        exit;
    }
} else {
    echo "ID Transaksi tidak ditemukan.";
    exit;
}

if (isset($_POST['submit'])) {
    $tgl_kembali = $_POST['tgl_kembali'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $denda_lambat = $_POST['denda_lambat']; // Denda keterlambatan dari form (hidden input)
    $denda_kondisi = $_POST['denda_kondisi'];
    $total_denda = $denda_lambat + $denda_kondisi;

    // Query untuk insert data ke tbl_kembali
    $query_insert = "INSERT INTO tbl_kembali VALUES (null, '$id_transaksi', '$tgl_kembali', '$kondisi_mobil','$total_denda')";

    if (mysqli_query($koneksi, $query_insert)) {
        $query_update_transaksi = "UPDATE tbl_transaksi SET status = 'kembali' WHERE id_transaksi = '$id_transaksi'";
        if (mysqli_query($koneksi, $query_update_transaksi)) {
            $query_update_mobil = "UPDATE tbl_mobil SET status = 'tersedia' WHERE nopol = '$nopol'";
            if (mysqli_query($koneksi, $query_update_mobil)) {
                echo "Data berhasil disimpan, status transaksi diubah menjadi 'dikembalikan', dan mobil status diupdate menjadi 'tersedia'.";
                header('Location: ../datatrans.php');
            } else {
                echo "Error: " . $query_update_mobil . "<br>" . mysqli_error($koneksi);
            }
        } else {
            echo "Error: " . $query_update_transaksi . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "Error: " . $query_insert . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.ico">
    <title>Buat Reservasi</title>
    <!-- Include CSS files -->
    <link rel="stylesheet" href="../../template/css/simplebar.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../template/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../../template/css/app-dark.css" id="darkTheme">
</head>
<body>
     <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-6 col-md-8 col-10 mx-auto text-center" action="" method="post">
                <h2 class="my-3">Form Pengembalian Mobil</h2>

                <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">

                <div class="form-group">
                    <label for="tgl_kembali_transaksi">Tanggal Kembali Sesuai Transaksi</label>
                    <input type="date" name="tgl_kembali_transaksi" id="tgl_kembali_transaksi" class="form-control" value="<?php echo $tgl_kembali_transaksi; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="tgl_kembali">Tanggal Kembali (Sebenarnya)</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required>
                </div>

                <!-- Denda Keterlambatan -->
                <div class="form-group">
                    <label for="denda">Denda Keterlambatan</label>
                    <input type="hidden" name="denda_lambat" id="denda_lambat" value="0"> <!-- Hidden field -->
                    <input type="number" id="denda" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="kondisi_mobil">Kondisi Mobil</label>
                    <textarea name="kondisi_mobil" id="kondisi_mobil" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="denda_kondisi">Denda Kondisi</label>
                    <input type="number" name="denda_kondisi" id="denda_kondisi" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="totaldenda">Total Denda</label>
                    <input type="number" disabled name="totaldenda" id="totaldenda" class="form-control" required>
                </div>

                <button class="btn btn-lg btn-primary btn-block mt-3" name="submit" type="submit">Submit</button>
                <a class="btn btn-lg btn-danger btn-block mt-3" href="../dashboard.php" type="button">Batal</a>
            </form>
        </div>
    </div>

    <script>
    function hitungTotalDenda() {
        const dendaKeterlambatan = parseFloat(document.getElementById('denda_lambat').value) || 0;
        const dendaKondisi = parseFloat(document.getElementById('denda_kondisi').value) || 0;
        const totalDenda = dendaKeterlambatan + dendaKondisi;
        document.getElementById('totaldenda').value = totalDenda.toFixed(2);
    }

    document.getElementById('tgl_kembali').addEventListener('change', function() {
        const tglKembaliTransaksi = new Date(document.getElementById('tgl_kembali_transaksi').value);
        const tglKembaliSebenarnya = new Date(document.getElementById('tgl_kembali').value);
        const hargaPerHari = <?php echo $harga_per_hari; ?>;

        if (tglKembaliSebenarnya > tglKembaliTransaksi) {
            const terlambatHari = Math.ceil((tglKembaliSebenarnya - tglKembaliTransaksi) / (1000 * 60 * 60 * 24));
            const denda = terlambatHari * hargaPerHari;
            document.getElementById('denda').value = denda.toFixed(2);
            document.getElementById('denda_lambat').value = denda.toFixed(2); // Set hidden value
        } else {
            document.getElementById('denda').value = 0;
            document.getElementById('denda_lambat').value = 0; // Reset hidden value
        }

        hitungTotalDenda(); 
    });

    document.getElementById('denda_kondisi').addEventListener('input', function() {
        hitungTotalDenda();
    });
    </script>

</body>
</html>
