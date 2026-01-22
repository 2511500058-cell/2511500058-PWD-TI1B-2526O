<?php
session_start();
require "koneksi.php";
require "fungsi.php";

// Cek method request, hanya izinkan GET (untuk delete via link)
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// Validasi pid dari GET
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$pid) {
    $_SESSION['flash_error'] = 'ID Tidak Valid.';
    redirect_ke('read.php');
}

// Prepared statement untuk delete
$sql = "DELETE FROM tbl_pengunjung WHERE pid = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $pid);
    
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, set flash sukses
        $_SESSION['flash_sukses'] = 'Data Biodata Mahasiswa Berhasil Dihapus.';
    } else {
        // Jika gagal, set flash error
        $_SESSION['flash_error'] = 'Gagal Menghapus Data Biodata Mahasiswa.';
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
}

// Redirect ke read.php
redirect_ke('read.php');
?>