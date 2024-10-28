<?php
include "../../koneksi.php"; // Pastikan koneksi database sudah benar

if (isset($_POST['submit'])) {
    // Mendapatkan data dari form
    $id_transaksi = $_POST['id_transaksi'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $denda = $_POST['denda'];

    // Query untuk insert data ke tbl_kembali
    $query_insert = "INSERT INTO tbl_kembali VALUES (null, '$id_transaksi', '$tgl_kembali', '$kondisi_mobil', '$denda')";

    // Eksekusi query untuk insert
    if (mysqli_query($koneksi, $query_insert)) {
        // Jika insert ke tbl_kembali berhasil, lanjutkan untuk update status di tbl_transaksi
        $query_update = "UPDATE tbl_transaksi SET status = 'dikembalikan' WHERE id_transaksi = '$id_transaksi'";

        // Eksekusi query untuk update status
        if (mysqli_query($koneksi, $query_update)) {
            echo "Data berhasil disimpan dan status transaksi diubah menjadi 'kembali'.";
            header('Location: ../datatrans.php'); // Redirect ke halaman sukses (ubah sesuai kebutuhan)
        } else {
            // Jika update status gagal
            echo "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika insert ke tbl_kembali gagal
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
                
                <?php
                // Ambil id_transaksi dari URL
                if (isset($_GET['id_transaksi'])) {
                    $id_transaksi = $_GET['id_transaksi'];
                } else {
                    // Jika id_transaksi tidak ada di URL
                    echo "ID Transaksi tidak ditemukan.";
                    exit;
                }
                ?>

                <!-- Input untuk id_transaksi (hidden) -->
                <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">

                <!-- Tanggal Kembali -->
                <div class="form-group">
                    <label for="tgl_kembali">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required>
                </div>

                <!-- Kondisi Mobil -->
                <div class="form-group">
                    <label for="kondisi_mobil">Kondisi Mobil</label>
                    <textarea name="kondisi_mobil" id="kondisi_mobil" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Denda -->
                <div class="form-group">
                    <label for="denda">Denda (Rp.)</label>
                    <input type="number" name="denda" id="denda" class="form-control" step="0.01" placeholder="Masukkan denda" required>
                </div>

                <br>
                <button class="btn btn-lg btn-primary btn-block mt-3" name="submit" type="submit">Submit</button>
                <a class="btn btn-lg btn-danger btn-block mt-3" href="../dashboard.php" type="button">Batal</a>

                <p class="mt-5 mb-3 text-muted">© 2020</p>
            </form>
        </div>
    </div>

    <script src="../../template/js/jquery.min.js"></script>
    <script src="../../template/js/bootstrap.min.js"></script>
    <script>
        // Mengatur value input menjadi tanggal hari ini
        document.getElementById('tgl_booking').valueAsDate = new Date();

        // Fungsi untuk menghitung total biaya sewa
        function hitungTotal() {
            const harga = parseFloat(document.querySelector('input[name="harga"]').value.replace(/[^\d,-]/g, '').replace(',', '.')); // Memperbaiki parsing harga
            const tglAmbil = new Date(document.getElementById('tgl_ambil').value);
            const tglKembali = new Date(document.getElementById('tgl_kembali').value);
            const supir = parseInt(document.getElementById('supir').value);

            if (tglAmbil && tglKembali && !isNaN(harga)) {
                // Menghitung durasi peminjaman dalam hari
                const durasi = (tglKembali - tglAmbil) / (1000 * 60 * 60 * 24); // Hitung dalam hari

                // Pastikan durasi tidak negatif
                if (durasi > 0) {
                    // Hitung total
                    let total = durasi * harga;

                    // Tambah biaya supir jika dipilih
                    if (supir === 1) {
                        total += 50000 * durasi; // Tambah 50000 per hari jika ada supir
                    }

                    document.getElementById('total').value = total.toFixed(2); // Set total di form
                    hitungKekurangan(); // Hitung kekurangan
                }
            }
        }

        function hitungKekurangan() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const downpayment = parseFloat(document.getElementById('downpayment').value) || 0;
            const kekurangan = total - downpayment;
            document.getElementById('kekurangan').value = kekurangan.toFixed(2); // Set kekurangan di form
        }
    </script>
</body>
</html>

