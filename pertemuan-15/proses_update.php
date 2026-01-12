<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

// Cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// Validasi bid wajib angka dan > 0
$bid = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$bid) {
    $_SESSION['flash_error'] = 'ID Tidak Valid.';
    redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

// Ambil dan bersihkan (sanitasi) nilai dari form
$nim      = bersihkan($_POST['txtNim'] ?? '');
$nama     = bersihkan($_POST['txtNmLengkap'] ?? '');
$tempat   = bersihkan($_POST['txtTmpLhr'] ?? '');
$tanggal  = bersihkan($_POST['txtTglLhr'] ?? '');
$hobi     = bersihkan($_POST['txtHobi'] ?? '');
$pasangan = bersihkan($_POST['txtPasangan'] ?? '');
$kerja    = bersihkan($_POST['txtKerja'] ?? '');
$ortu     = bersihkan($_POST['txtNmOrtu'] ?? '');
$kakak    = bersihkan($_POST['txtNmKakak'] ?? '');
$adik     = bersihkan($_POST['txtNmAdik'] ?? '');
$captcha  = bersihkan($_POST['txtCaptcha'] ?? '');

// Validasi sederhana
$errors = []; // Array untuk menampung semua error

if ($nim === '') {
    $errors[] = 'NIM wajib diisi.';
}

if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
}

if ($tempat === '') {
    $errors[] = 'Tempat Lahir wajib diisi.';
}

if ($tanggal === '') {
    $errors[] = 'Tanggal Lahir wajib diisi.';
}

if ($captcha === '') {
    $errors[] = 'Pertanyaan wajib diisi.';
}

if (mb_strlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
}

if ($captcha !== "6") {
    $errors[] = 'Jawaban ' . $captcha . ' captcha salah.';
}

/*
Kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
    $_SESSION['old_bio'] = [
        'nim'      => $nim,
        'nama'     => $nama,
        'tempat'   => $tempat,
        'tanggal'  => $tanggal,
        'hobi'     => $hobi,
        'pasangan' => $pasangan,
        'kerja'    => $kerja,
        'ortu'     => $ortu,
        'kakak'    => $kakak,
        'adik'     => $adik
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

/*
Prepared statement untuk anti SQL injection.
Menyiapkan query UPDATE dengan prepared statement 
(WAJIB WHERE bid = ?)
*/
$stmt = mysqli_prepare($conn, "UPDATE tbl_biodatamhs 
                              SET cnim = ?, cnama = ?, ctempat_lahir = ?, dtanggal_lahir = ?, chobi = ?, cpasangan = ?, cpekerjaan = ?, cnama_ortu = ?, cnama_kakak = ?, cnama_adik = ? 
                              WHERE bid = ?");
if (!$stmt) {
    // Jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

// Bind parameter dan eksekusi (s = string, i = integer)
mysqli_stmt_bind_param($stmt, "ssssssssssi", $nim, $nama, $tempat, $tanggal, $hobi, $pasangan, $kerja, $ortu, $kakak, $adik, $bid);

if (mysqli_stmt_execute($stmt)) { // Jika berhasil, kosongkan old value
    unset($_SESSION['old_bio']);
    /*
    Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Data biodata sudah diperbaharui.';
    redirect_ke('read.php'); // Pola PRG: kembali ke data dan exit()
} else { // Jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old_bio'] = [
        'nim'      => $nim,
        'nama'     => $nama,
        'tempat'   => $tempat,
        'tanggal'  => $tanggal,
        'hobi'     => $hobi,
        'pasangan' => $pasangan,
        'kerja'    => $kerja,
        'ortu'     => $ortu,
        'kakak'    => $kakak,
        'adik'     => $adik,
    ];
    $_SESSION['flash_error'] = 'Data biodata gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

// Tutup statement
mysqli_stmt_close($stmt);

// Redirect akhir (meskipun seharusnya tidak tercapai)
redirect_ke('edit_biodata.php?bid=' . (int)$bid);
?>