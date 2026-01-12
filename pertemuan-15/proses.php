<?php
session_start();
require "koneksi.php";
require_once "fungsi.php";

#------------------------------------------------------
# DETEKSI: FORM BIODATA atau FORM KONTAK
#------------------------------------------------------
$isBiodata = isset($_POST["txtNim"]);

#------------------------------------------------------
# 1. FORM BIODATA MAHASISWA
#------------------------------------------------------
if ($isBiodata) {

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

    if ($nim === "") $errors[] = "NIM harus di isi!";
    if ($nama === "") $errors[] = "Nama Lengkap harus di isi!";
    if ($tempat === "") $errors[] = "Tempat Lahir harus di isi!";
    if ($tanggal === "") $errors[] = "Tanggal Lahir harus di isi!";
    if ($hobi === "") $errors[] = "Hobi harus di isi!";
    if ($pasangan === "") $errors[] = "Pasangan harus di isi!";
    if ($pekerjaan === "") $errors[] = "Pekerjaan harus di isi!";
    if ($ortu === "") $errors[] = "Nama Orang Tua harus di isi!";
    if ($kakak === "") $errors[] = "Nama Kakak harus di isi!";
    if ($adik === "") $errors[] = "Nama Adik harus di isi!";

    if (mb_strlen($nim) < 10) {
        $errors[] = "NIM minimal 10 karakter.";
    }

    if (!empty($errors)) {
        $_SESSION["old"] = [
            "nim"      => $nim,
            "nama"     => $nama,
            "tempat"   => $tempat,
            "tanggal"  => $tanggal,
            "hobi"     => $hobi,
            "pasangan" => $pasangan,
            "pekerjaan" => $pekerjaan,
            "ortu"     => $ortu,
            "kakak"    => $kakak,
            "adik"     => $adik,
        ];
        $_SESSION["flash_error"] = implode ("<br>", $errors);
        redirect_ke("index.php#biodata");
    }

    $sql  = "INSERT INTO Tbl_biodata_mhs
             (Nim, Nm_lengkap, T4_lahir, Tgl_lahir, Hobi, Pasangan, Pekerjaan, Nm_ortu, Nm_kakak, Nm_adik)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        $_SESSION["flash_error"] = "Terjadi kesalahan sistem (prepare gagal).";
        redirect_ke("index.php#biodata");
    }

    mysqli_stmt_bind_param(
        $stmt,
        $nim,
        $nama,
        $tempat,
        $tanggal,
        $hobi,
        $pasangan,
        $pekerjaan,
        $ortu,
        $kakak,
        $adik
    );

    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION["old"]);

        $arrBiodata = [
            "nim" => $nim,
            "nama" => $nama,
            "tempat" => $tempat,
            "tanggal" => $tanggal,
            "hobi" => $hobi,
            "pasangan" => $pasangan,
            "pekerjaan" => $pekerjaan,
            "ortu" => $ortu,
            "kakak" => $kakak,
            "adik" => $adik,
        ];
        $_SESSION["biodata"]      = $arrBiodata;
        $_SESSION["flash_sukses"] = "Biodata berhasil disimpan.";
        redirect_ke("index.php#about");
    } else {
        $_SESSION["old"] = [
            "nim"      => $nim,
            "nama"     => $nama,
            "tempat"   => $tempat,
            "tanggal"  => $tanggal,
            "hobi"     => $hobi,
            "pasangan" => $pasangan,
            "pekerjaan" => $pekerjaan,
            "ortu"     => $ortu,
            "kakak"    => $kakak,
            "adik"     => $adik,
        ];
        $_SESSION["flash_error"] = "Biodata Mahasiswa gagal disimpan. Silakan coba lagi.";
        redirect_ke("index.php#biodata");
    }

    mysqli_stmt_close($stmt);
    exit;
}

#------------------------------------------------------
# 2. FORM KONTAK (BUKU TAMU) – KODE DASAR ASLI
#------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION["flash_error"] = "Akses tidak valid.";
    redirect_ke("index.php#contact");
}

$nama    = bersihkan($_POST["txtNama"]   ?? "");
$email   = bersihkan($_POST["txtEmail"]  ?? "");
$pesan   = bersihkan($_POST["txtPesan"]  ?? "");
$captcha = bersihkan($_POST["txtCaptcha"]?? "");

$errors = [];

if ($nama === "") {
    $errors[] = "Nama harus di isi!.";
}

if ($email === "") {
    $errors[] = "Email harus di isi!.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format e-mail tidak valid.";
}

if ($pesan === "") {
    $errors[] = "Pesan harus di isi!.";
}

if ($captcha === "") {
    $errors[] = "Pertanyaan harus di isi!.";
}

if (mb_strlen($nama) < 3) {
    $errors[] = "Nama minimal 3 karakter.";
}

if (mb_strlen($pesan) < 10) {
    $errors[] = "Pesan minimal 10 karakter.";
}

if ($captcha !== "5") {
    $errors[] = "Jawaban " . $captcha . " captcha salah.";
}

if (!empty($errors)) {
    $_SESSION["old"] = [
        "nama"    => $nama,
        "email"   => $email,
        "pesan"   => $pesan,
        "captcha" => $captcha,
    ];
    $_SESSION["flash_error"] = implode("", $errors);
    redirect_ke("index.php#contact");
}

$sql  = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    $_SESSION["flash_error"] = "Terjadi kesalahan sistem (prepare gagal).";
    redirect_ke("index.php#contact");
}

mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION["old"]);
    $_SESSION["flash_sukses"] = "Terima kasih, data Anda sudah tersimpan.";
    redirect_ke("index.php#contact");
} else {
    $_SESSION["old"] = [
        "nama"    => $nama,
        "email"   => $email,
        "pesan"   => $pesan,
        "captcha" => $captcha,
    ];
    $_SESSION["flash_error"] = "Data gagal disimpan. Silakan coba lagi.";
    redirect_ke("index.php#contact");
}

mysqli_stmt_close($stmt);