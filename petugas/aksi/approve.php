<?php
// Memulai session
session_start();

// Memasukkan file koneksi ke database
include '../../koneksi.php';

// Mendapatkan id_transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Memastikan id_transaksi tidak kosong
if (isset($id_transaksi)) {
    // Pertama, ambil nomor polisi (nopol) dari transaksi
    $sql_get_nopol = "SELECT nopol FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi'";
    $result = mysqli_query($koneksi, $sql_get_nopol);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nopol = $row['nopol'];

        // Query untuk update status transaksi menjadi 'approve'
        $sql_update_transaksi = "UPDATE tbl_transaksi SET status = 'aprove' WHERE id_transaksi = '$id_transaksi'";
        
        // Mengeksekusi query untuk update transaksi
        if (mysqli_query($koneksi, $sql_update_transaksi)) {
            // Update status mobil menjadi 'tidak'
            $sql_update_mobil = "UPDATE tbl_mobil SET status = 'tidak' WHERE nopol = '$nopol'";
            
            if (mysqli_query($koneksi, $sql_update_mobil)) {
                // Redirect ke halaman yang diinginkan setelah sukses
                $_SESSION['message'] = "Transaksi berhasil di-approve dan mobil status diupdate";
                header("Location: ../datatrans.php"); // Sesuaikan dengan halaman yang sesuai
                exit();
            } else {
                // Jika gagal update status mobil
                $_SESSION['error'] = "Gagal mengupdate status mobil";
                header("Location: ../datatrans.php");
                exit();
            }
        } else {
            // Jika gagal, tampilkan pesan error
            $_SESSION['error'] = "Gagal mengapprove transaksi";
            header("Location: ../datatrans.php");
            exit();
        }
    } else {
        // Jika tidak ditemukan nopol
        $_SESSION['error'] = "Nomor polisi tidak ditemukan";
        header("Location: ../datatrans.php");
        exit();
    }
} else {
    // Jika id_transaksi tidak ditemukan
    $_SESSION['error'] = "ID Transaksi tidak ditemukan";
    header("Location: ../datatrans.php");
    exit();
}
?>
