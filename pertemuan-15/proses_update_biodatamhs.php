<?php
session_start();
require "koneksi.php";
require_once "fungsi.php";

/* cek method */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

/* validasi id */
$nim = filter_input(INPUT_POST, 'Nim', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$nim) {
    $_SESSION['flash_error'] = 'ID Tidak Valid.';
    redirect_ke('read.php');
}

/* ambil & sanitasi */
$nim = bersihkan($_POST["txtNim"] ?? "");
    $nama = bersihkan($_POST["txtNmLengkap"] ?? "");
    $tempat = bersihkan($_POST["txtT4Lhr"] ?? "");
    $tanggal = bersihkan($_POST["txtTglLhr"] ?? "");
    $hobi = bersihkan($_POST["txtHobi"] ?? "");
    $pasangan = bersihkan($_POST["txtPasangan"] ?? "");
    $pekerjaan = bersihkan($_POST["txtKerja"] ?? "");
    $ortu = bersihkan($_POST["txtNmOrtu"] ?? "");
    $kakak = bersihkan($_POST["txtNmKakak"] ?? "");
    $adik = bersihkan($_POST["txtNmAdik"] ?? "");

$errors = [];

if ($nama === '')     $errors[] = 'Nama Lengkap harus di isi!';
if ($tempat === '')   $errors[] = 'Tempat Lahir harus di isi!';
if ($tanggal === '')  $errors[] = 'Tanggal Lahir harus di isi!';
if ($hobi === '')     $errors[] = 'Hobi harus di isi!';
if ($pasangan === '') $errors[] = 'Pasangan harus di isi!';
if ($kerja === '')    $errors[] = 'Pekerjaan harus di isi!';
if ($ortu === '')     $errors[] = 'Nama Orang Tua harus di isi!';
if ($kakak === '')    $errors[] = 'Nama Kakak harus di isi!';
if ($adik === '')     $errors[] = 'Nama Adik harus di isi!';

if (mb_strlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
}

if (!empty($errors)) {
    $_SESSION['old'] = [
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
    $_SESSION['flash_error'] = implode('', $errors);
    redirect_ke('edit_biodata.php?Nim=' . (int)$Nim);
}

/* UPDATE prepared statement */
$stmt = mysqli_prepare(
    $conn,
    "UPDATE tblbiodata_mhs
     SET nama_lengkap = ?, tempat_lahir = ?, tanggal_lahir = ?,
         hobi = ?, pasangan = ?, pekerjaan = ?, nama_ortu = ?,
         nama_kakak = ?, nama_adik = ?
     WHERE Nim = ?"
);

if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit_biodata.php?Nim=' . (int)$Nim);
}

mysqli_stmt_bind_param(
    $stmt,
    $nama,
    $tempat,
    $tanggal,
    $hobi,
    $pasangan,
    $kerja,
    $ortu,
    $kakak,
    $adik,
);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Data biodata sudah diperbaharui.';
    redirect_ke('read.php');  // PRG: kembali ke file pembaca
} else {
    $_SESSION['old'] = [
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
    redirect_ke('edit_biodata.php?Nim=' . (int)$Nim);
}

mysqli_stmt_close($stmt);