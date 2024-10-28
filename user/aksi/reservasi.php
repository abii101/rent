<?php
session_start(); // Pastikan session dimulai

if (isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik']; // Mengambil nilai NIK dari session
} else {
    // Jika nik tidak ada dalam session, redirect atau tampilkan pesan
    die("NIK tidak ditemukan. Silakan login.");
}

include "../../koneksi.php"; // Pastikan koneksi database sudah benar

if (isset($_POST['submit'])) {
    // Mendapatkan data dari form
    $tgl_booking = $_POST['tgl_booking'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = $_POST['supir'];
    $total = $_POST['total'];
    $downpayment = $_POST['downpayment'];
    $kekurangan = $_POST['kekurangan'];
    $nopol = $_POST['nopol']; // Pastikan ini diambil dari form

    // Query untuk memasukkan data ke tabel tbl_transaksi
    $sql = "INSERT INTO tbl_transaksi (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan, status) 
            VALUES ('$nik', '$nopol', '$tgl_booking', '$tgl_ambil', '$tgl_kembali', '$supir', '$total', '$downpayment', '$kekurangan', 'booking')";

    // Eksekusi query dan periksa kesalahan
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Transaksi berhasil dilakukan!'); window.location.href='../dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi); // Menampilkan pesan error
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
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="" method="post">
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                    <?php
                    // Ambil nilai 'nopol' dari URL
                    $nopol = $_GET['nopol'];

                    // Query untuk mengambil data berdasarkan nopol
                    $query = "SELECT * FROM tbl_mobil WHERE nopol = '$nopol' LIMIT 1";
                    $data = mysqli_query($koneksi, $query);

                    // Periksa apakah ada hasil
                    if (mysqli_num_rows($data) > 0) {
                        $d = mysqli_fetch_array($data);
                        ?>
                        <img class="card-img-top" src="../../foto/<?php echo $d['foto']; ?>" alt="Card image cap">
                </a>
                <h2 class="my-3 mt-2"><?php echo $d['brand']; ?> <?php echo $d['type']; ?> <?php echo $d['tahun']; ?></h2>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">No. Polisi</label>
                        <input type="text" name="nopol" disabled value="<?php echo $d['nopol']; ?>" autocomplete="off" id="firstname" class="form-control">
                    </div>
                    <input type="hidden" name="nopol" value="<?php echo $d['nopol']; ?>"> <!-- Hidden input untuk nopol -->
                    <div class="form-group col-md-6">
                        <label for="lastname">Harga / 24jam</label>
                        <input  class="form-control" name="harga" disabled value="<?php echo 'Rp. ' . number_format($d['harga'], 2, ',', '.'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_booking">Tanggal Booking</label>
                    <input type="date" name="tgl_booking" id="tgl_booking" class="form-control" required disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_ambil">Tanggal Ambil</label>
                    <input type="date" name="tgl_ambil" id="tgl_ambil" class="form-control" required onchange="hitungTotal()">
                </div>
                <div class="form-group">
                    <label for="tgl_kembali">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required onchange="hitungTotal()">
                </div>
                <div class="form-group">
                    <label for="supir">Supir (1=Ya, 0=Tidak)</label>
                    <select name="supir" id="supir" class="form-control" onchange="hitungTotal()" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" name="total" id="total" class="form-control" placeholder="Total" step="0.01" readonly>
                </div>
                <div class="form-group">
                    <label for="downpayment">Downpayment</label>
                    <input type="number" name="downpayment" id="downpayment" class="form-control" placeholder="Masukkan Downpayment" step="0.01" onchange="hitungKekurangan()" required>
                </div>
                <div class="form-group">
                    <label for="kekurangan">Kekurangan</label>
                    <input type="number" name="kekurangan" id="kekurangan" class="form-control" placeholder="Kekurangan" step="0.01" readonly>
                </div>
                <br>
                <button class="btn btn-lg btn-primary btn-block mt-3" name="submit" type="submit">Submit</button>
                <a class="btn btn-lg btn-danger btn-block mt-3" href="../dashboard.php" type="button">Batal</a>
                <p class="mt-5 mb-3 text-muted">© 2020</p>
            </form>
            <?php
                    } else {
                        // Jika tidak ada mobil dengan nopol tersebut
                        echo "Mobil dengan nopol tersebut tidak ditemukan.";
                    }
                ?>
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

