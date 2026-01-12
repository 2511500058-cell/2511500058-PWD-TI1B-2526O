<?php
session_start();
require "koneksi.php";
require "fungsi.php";

/* Validasi id dari GET */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$id) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}
/* Ambil data lama dari Biodata */
$stmt = mysqli_prepare($conn, "SELECT bid, cnim, cnama, ctempat, dtanggal, chobi, cpasangan, cpekerjaan, cnama_ortu, cnama_kakak, cnama_adik 
                                  FROM tbl_biodatamhs WHERE bid = ? LIMIT 1");

if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('read.php');
}
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if (!$row) {
    $_SESSION['flash_error'] = 'Record tidak ditemukan.';
    redirect_ke('read.php');
}
/* Nilai awal (prefill form) */
$nim = $row['cnim'] ?? '';
$nama_lengkap = $row['cnama'] ?? '';
$tempat_lahir = $row['ctempat'] ?? '';
$tanggal_lahir = $row['dtanggal'] ?? '';
$hobi = $row['chobi'] ?? '';
$pasangan = $row['cpasangan'] ?? '';
$pekerjaan = $row['cpekerjaan'] ?? '';
$nama_ortu = $row['cnama_ortu'] ?? '';
$nama_kakak = $row['cnama_kakak'] ?? '';
$nama_adik = $row['cnama_adik'] ?? '';
$bid = $row['bid'] ?? '';

/* Tampilkan form edit */
include 'edit_biodatamhs.php';
?>

<?php
redirect_ke('edit.php?bid=' . (int)$bid);
}



/* Jika ada error, simpan data lama ke session dan kembalikan ke form edit */
if (!empty($errors)) {
    $_SESSION['old'] = [
        'nama'  => $nama,
        'email' => $email,
        'pesan' => $pesan,
    ];
    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit.php?bid=' . (int)$bid);
}
/* Update data ke database */
$sql = "UPDATE tbl_tamu SET 
        cnama = ?, 
        cemail = ?, 
        cpesan = ? 
        WHERE bid = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit.php?bid=' . (int)$bid);
}
mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $pesan, $bid);
if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Data tamu berhasil diperbarui!';
    redirect_ke('read.php');
} else {
    $_SESSION['flash_error'] = 'Data tamu gagal diperbarui. Silakan coba lagi.';
    redirect_ke('edit.php?bid=' . (int)$bid);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Biodata Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Ini Header</h1>
</header>
<main>
<section id="biodata">
    <h2>Edit Biodata Sederhana Mahasiswa</h2>

    <?php if (!empty($flash_error)) : ?>
        <div style="padding:10px;margin-bottom:10px;background:#f8d7da;color:#721c24;border-radius:6px;">
            <?= $flash_error ?>
        </div>
    <?php endif; ?>

    <form action="proses_update_biodata.php" method="POST">
        <input type="hidden" name="id" value="<?= (int)$id ?>">

        <label for="txtNimEd"><span>NIM</span>
            <input type="text" id="txtNimEd" name="txtNimEd"
                   value="<?= htmlspecialchars($nim) ?>" readonly>
        </label>

        <label for="txtNamaLengkapEd"><span>Nama Lengkap</span>
            <input type="text" id="txtNamaLengkapEd" name="txtNamaLengkapEd"
                   value="<?= htmlspecialchars($nama_lengkap) ?>">
        </label>

        <label for="txtTempatLahirEd"><span>Tempat Lahir</span>
            <input type="text" id="txtTempatLahirEd" name="txtTempatLahirEd"
                   value="<?= htmlspecialchars($tempat_lahir) ?>">
        </label>

        <label for="txtTanggalLahirEd"><span>Tanggal Lahir</span>
            <input type="date" id="txtTanggalLahirEd" name="txtTanggalLahirEd"
                   value="<?= htmlspecialchars($tanggal_lahir) ?>">
        </label>

        <label for="txtHobiEd"><span>Hobi</span>
            <input type="text" id="txtHobiEd" name="txtHobiEd"
                   value="<?= htmlspecialchars($hobi) ?>">
        </label>

        <label for="txtPasanganEd"><span>Pasangan</span>
            <input type="text" id="txtPasanganEd" name="txtPasanganEd"
                   value="<?= htmlspecialchars($pasangan) ?>">
        </label>

        <label for="txtPekerjaanEd"><span>Pekerjaan</span>
            <input type="text" id="txtPekerjaanEd" name="txtPekerjaanEd"
                   value="<?= htmlspecialchars($pekerjaan) ?>">
        </label>

        <label for="txtNamaOrtuEd"><span>Nama Orang Tua</span>
            <input type="text" id="txtNamaOrtuEd" name="txtNamaOrtuEd"
                   value="<?= htmlspecialchars($nama_ortu) ?>">
        </label>

        <label for="txtNamaKakakEd"><span>Nama Kakak</span>
            <input type="text" id="txtNamaKakakEd" name="txtNamaKakakEd"
                   value="<?= htmlspecialchars($nama_kakak) ?>">
        </label>

        <label for="txtNamaAdikEd"><span>Nama Adik</span>
            <input type="text" id="txtNamaAdikEd" name="txtNamaAdikEd"
                   value="<?= htmlspecialchars($nama_adik) ?>">
        </label>
        <button type="submit">Update Biodata</button>
        <button type="reset">Batal</button>
        <a href="read.php" class="reset">Kembali</a>
    </form>
</section>
</main>
</body>
</html> 