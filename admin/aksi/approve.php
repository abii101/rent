<?php
// Memulai session
session_start();

// Memasukkan file koneksi ke database
include '../../koneksi.php';

// Mendapatkan id_transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Memastikan id_transaksi tidak kosong
if (isset($id_transaksi)) {
    // Query untuk update status menjadi 'approve'
    $sql = "UPDATE tbl_transaksi SET status = 'aprove' WHERE id_transaksi = '$id_transaksi'";
    
    // Mengeksekusi query
    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke halaman yang diinginkan setelah sukses
        $_SESSION['message'] = "Transaksi berhasil di-approve";
        header("Location: ../datatrans.php"); // Sesuaikan dengan halaman yang sesuai
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        $_SESSION['error'] = "Gagal mengapprove transaksi";
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
