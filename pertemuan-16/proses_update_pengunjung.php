<?php
session_start();
require "koneksi.php";
require_once "fungsi.php";

/* cek method */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

/* validasi bid */
$bid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$bid) {
    $_SESSION['flash_error'] = 'ID Tidak Valid.';
    redirect_ke('read.php');
}

/* ambil & sanitasi */
$nim = bersihkan($_POST['txtNim'] ?? '');
$nama_lengkap = bersihkan($_POST['txtNamaLengkap'] ?? '');
$tempat_lahir = bersihkan($_POST['txtTempatLahir'] ?? '');
$tanggal_lahir = bersihkan($_POST['txtTanggalLahir'] ?? '');
$hobi = bersihkan($_POST['txtHobi'] ?? '');
$pasangan = bersihkan($_POST['txtPasangan'] ?? '');
$pekerjaan = bersihkan($_POST['txtPekerjaan'] ?? '');
$nama_ortu = bersihkan($_POST['txtNamaOrtu'] ?? '');
$nama_kakak = bersihkan($_POST['txtNamaKakak'] ?? '');
$nama_adik = bersihkan($_POST['txtNamaAdik'] ?? '');

/* validasi sederhana */
$errors = [];

if ($nim === '') {
    $errors[] = 'NIM harus di isi!';
}
if ($nama_lengkap === '') {
    $errors[] = 'Nama Lengkap harus di isi!';
}
if ($tempat_lahir === '') {
    $errors[] = 'Tempat Lahir harus di isi!';
}
if ($tanggal_lahir === '') {
    $errors[] = 'Tanggal Lahir harus di isi!';
}
if ($hobi === '') {
    $errors[] = 'Hobi harus di isi!';
}
if ($pasangan === '') {
    $errors[] = 'Pasangan harus di isi!';
}
if ($pekerjaan === '') {
    $errors[] = 'Pekerjaan harus di isi!';
}
if ($nama_ortu === '') {
    $errors[] = 'Nama Orang Tua harus di isi!';
}
if ($nama_kakak === '') {
    $errors[] = 'Nama Kakak harus di isi!';
}
if ($nama_adik === '') {
    $errors[] = 'Nama Adik harus di isi!';
}
if (mb_strlen($nim) < 3) {
    $errors[] = 'NIM minimal 3 karakter.';
}

/* jika ada error */
if (!empty($errors)) {


    $_SESSION['old'] = [
        'nim'           => $nim,
        'nama_lengkap'  => $nama_lengkap,
        'tempat_lahir'  => $tempat_lahir,
        'tanggal_lahir' => $tanggal_lahir,
        'hobi'          => $hobi,
        'pasangan'      => $pasangan,
        'pekerjaan'     => $pekerjaan,
        'nama_ortu'     => $nama_ortu,
        'nama_kakak'    => $nama_kakak,
        'nama_adik'     => $nama_adik,
    ];
    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit_biodatapengunjung.php?pid=' . (int)$pid);
}

/* update ke database */
$sql = "UPDATE tbl_pengunjung SET
        cnim = ?, 
        cnama = ?, 
        ctempat = ?, 
        dtanggal = ?, 
        chobi = ?, 
        cpasangan = ?, 
        cpekerjaan = ?, 
        cnama_ortu = ?, 
        cnama_kakak = ?, 
        cnama_adik = ?
        WHERE pid = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit_biodatapengunjung.php?pid=' . (int)$pid);
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssssssssi",
    $nim,
    $nama_lengkap,
    $tempat_lahir,
    $tanggal_lahir,
    $hobi,
    $pasangan,
    $pekerjaan,
    $nama_ortu,
    $nama_kakak,
    $nama_adik,
    $pid
);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Biodata berhasil diperbarui!';
    redirect_ke('read.php');
} else {
    $_SESSION['old'] = [
        'nim'           => $nim,
        'nama_lengkap'  => $nama_lengkap,
        'tempat_lahir'  => $tempat_lahir,
        'tanggal_lahir' => $tanggal_lahir,
        'hobi'          => $hobi,
        'pasangan'      => $pasangan,
        'pekerjaan'     => $pekerjaan,
        'nama_ortu'     => $nama_ortu,
        'nama_kakak'    => $nama_kakak,
        'nama_adik'     => $nama_adik,
    ];
    $_SESSION['flash_error'] = 'Biodata gagal diperbarui. Silakan coba lagi.';
    redirect_ke('edit_biodatapengunjung.php?pid=' . (int)$pid);
}

mysqli_stmt_close($stmt);