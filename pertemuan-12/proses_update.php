<?php
session_start();
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = "Akses tidak valid.";
    redirect_ke('read.php');
}

$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$cid) {
    $_SESSION['flash_error'] = 'CID tidak valid.';
    redirect_ke('edit.php?cid='. (int)$cid);
}

$nama    = bersihkan($_POST['txtNama'] ?? '');
$email   = bersihkan($_POST['txtEmail'] ?? '');
$pesan   = bersihkan($_POST['txtPesan'] ?? '');
$captcha = bersihkan($_POST['txtCaptcha'] ?? '');

$errors = [];

if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
} elseif (strlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
}

if ($email === '') {
    $errors[] = 'Email wajib diisi';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format e-mail tidak valid.';
}

if ($pesan === '') {
    $errors[] = 'Pesan wajib diisi';
} elseif (strlen($pesan) < 10) {
    $errors[] = 'Pesan minimal 10 karakter.';
}

if ($captcha === '' || !is_numeric($captcha)) {
    $errors[] = 'Jawaban Captcha wajib diisi dengan angka.';
} elseif ((int)$captcha !== 5) {
    $errors[] = 'Jawaban Captcha salah.';
}

if (mb_starlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
}

if (mb_starlen($pesan) < 10) {
    $errors[] = 'Pesan minimal 10 karakter.';
}

if ($captcha!=="6") {
    $errors[] = 'Jawaban ' . $captcha . 'captchasalah.';
}

if (!empty($errors)) {
    $_SESSION['old'] = [
        'nama'  => $nama,
        'email' => $email,
        'pesan' => $pesan,
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit.php?cid=' . (int)$cid);
}

$stmt = mysqli_prepare($conn, 
"UPDATE tbl_tamu SET cnama = ?, cemail = ?, cpesan = ? WHERE cid = ?"
);

if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit.php?cid=' . (int)$cid);
}

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old']);

    $_SESSION['flash_sukses'] = 'Terima kasih, data berhasil diperbarui.';
    redirect_ke('read.php');
} else {
    $_SESSION['old'] = [
        'nama'  => $nama,
        'email' => $email,
        'pesan' => $pesan,
    ];

    $_SESSION['flash_error'] = 'Data gagal diperbarui, silahkan coba lagi.';
    redirect_ke('edit.php?cid=' . (int)$cid);
}

mysqli_stmt_close($stmt);

redirect_ke('edit.php?cid=' . (int)$cid);