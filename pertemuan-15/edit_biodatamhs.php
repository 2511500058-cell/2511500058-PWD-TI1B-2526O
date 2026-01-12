<?php
session_start();
require "koneksi.php";
require "fungsi.php";

// Cek jika ada bid di URL (GET)
$bid = filter_input(INPUT_GET, 'bid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$bid) {
    $_SESSION['flash_error'] = 'ID Tidak Valid.';
    redirect_ke('read.php');
}

// Jika metode POST, proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* validasi bid */
    $bid_post = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);
    if (!$bid_post || $bid_post != $bid) {
        $_SESSION['flash_error'] = 'ID Tidak Valid.';
        redirect_ke('edit_biodatamhs.php?bid=' . (int)$bid);
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

    if (count($errors) > 0) {
        $_SESSION['flash_error'] = implode('<br>', $errors);
        $_SESSION['old_bio'] = [
            'nim' => $nim,
            'nama' => $nama_lengkap,
            'tempat' => $tempat_lahir,
            'tanggal' => $tanggal_lahir,
            'hobi' => $hobi,
            'pasangan' => $pasangan,
            'pekerjaan' => $pekerjaan,
            'ortu' => $nama_ortu,
            'kakak' => $nama_kakak,
            'adik' => $nama_adik
        ];
        redirect_ke('edit_biodatamhs.php?bid=' . (int)$bid);
    }

    /* update ke database */
    $sql = "UPDATE tbl_biodatamhs SET
                cnim = ?,
                cnama = ?,
                ctempat_lahir = ?,
                dtanggal_lahir = ?,
                chobi = ?,
                cpasangan = ?,
                cpekerjaan = ?,
                cnama_ortu = ?,
                cnama_kakak = ?,
                cnama_adik = ?
            WHERE bid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
        redirect_ke('edit_biodatamhs.php?bid=' . (int)$bid);
    }
    mysqli_stmt_bind_param($stmt, "ssssssssssi",
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
        $bid
    );
    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION['old_bio']);
        $_SESSION['flash_sukses'] = 'Data biodata sudah diperbaharui.';
        redirect_ke('read.php');
    } else {
        $_SESSION['old_bio'] = [
            'nim' => $nim,
            'nama' => $nama_lengkap,
            'tempat' => $tempat_lahir,
            'tanggal' => $tanggal_lahir,
            'hobi' => $hobi,
            'pasangan' => $pasangan,
            'pekerjaan' => $pekerjaan,
            'ortu' => $nama_ortu,
            'kakak' => $nama_kakak,
            'adik' => $nama_adik
        ];
        $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
        redirect_ke('edit_biodatamhs.php?bid=' . (int)$bid);
    }
    mysqli_stmt_close($stmt);
}

// Jika GET, ambil data dari database untuk form
$sql = "SELECT * FROM tbl_biodatamhs WHERE bid = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $bid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bio = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem.';
    redirect_ke('read.php');
}

if (!$bio) {
    $_SESSION['flash_error'] = 'Data tidak ditemukan.';
    redirect_ke('read.php');
}

// Ambil old_bio dari session jika ada
$old_bio = $_SESSION['old_bio'] ?? [];

// Ambil flash messages
$flash_sukses = $_SESSION['flash_sukses'] ?? '';
$flash_error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old_bio']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        form { max-width: 600px; margin: auto; }
        label { display: block; margin-bottom: 10px; }
        label span { display: inline-block; width: 150px; }
        input { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 20px; margin-right: 10px; }
        .biodata-display { margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px; }
        .biodata-display h2 { margin-bottom: 10px; }
        .biodata-display p { margin: 5px 0; }
    </style>
</head>
<body>

<h1>Edit Biodata Mahasiswa</h1>
<a href="read.php">Kembali ke Halaman Admin</a>

<?php if (!empty($flash_sukses)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($flash_sukses); ?></div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($flash_error); ?></div>
<?php endif; ?>

<section>
    <h2>Form Edit Biodata</h2>
    <form action="edit_biodatamhs.php?bid=<?= htmlspecialchars($bid); ?>" method="post">
        <input type="hidden" name="bid" value="<?= htmlspecialchars($bid); ?>">
        <label for="txtNim"><span>NIM:</span>
            <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required
                   value="<?= isset($old_bio['nim']) ? htmlspecialchars($old_bio['nim']) : htmlspecialchars($bio['cnim'] ?? ''); ?>">
        </label>
        <label for="txtNamaLengkap"><span>Nama Lengkap:</span>
            <input type="text" id="txtNamaLengkap" name="txtNamaLengkap" placeholder="Masukkan Nama Lengkap" required
                   value="<?= isset($old_bio['nama']) ? htmlspecialchars($old_bio['nama']) : htmlspecialchars($bio['cnama'] ?? ''); ?>">
        </label>
        <label for="txtTempatLahir"><span>Tempat Lahir:</span>
            <input type="text" id="txtTempatLahir" name="txtTempatLahir" placeholder="Masukkan Tempat Lahir" required
                   value="<?= isset($old_bio['tempat']) ? htmlspecialchars($old_bio['tempat']) : htmlspecialchars($bio['ctempat_lahir'] ?? ''); ?>">
        </label>
        <label for="txtTanggalLahir"><span>Tanggal Lahir:</span>
            <input type="date" id="txtTanggalLahir" name="txtTanggalLahir" required
                   value="<?= isset($old_bio['tanggal']) ? htmlspecialchars($old_bio['tanggal']) : htmlspecialchars($bio['dtanggal_lahir'] ?? ''); ?>">
        </label>
        <label for="txtHobi"><span>Hobi:</span>
            <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required
                   value="<?= isset($old_bio['hobi']) ? htmlspecialchars($old_bio['hobi']) : htmlspecialchars($bio['chobi'] ?? ''); ?>">
        </label>
        <label for="txtPasangan"><span>Pasangan:</span>
            <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required
                   value="<?= isset($old_bio['pasangan']) ? htmlspecialchars($old_bio['pasangan']) : htmlspecialchars($bio['cpasangan'] ?? ''); ?>">
        </label>
        <label for="txtPekerjaan"><span>Pekerjaan:</span>
            <input type="text" id="txtPekerjaan" name="txtPekerjaan" placeholder="Masukkan Pekerjaan" required
                   value="<?= isset($old_bio['pekerjaan']) ? htmlspecialchars($old_bio['pekerjaan']) : htmlspecialchars($bio['cpekerjaan'] ?? ''); ?>">
        </label>
        <label for="txtNamaOrtu"><span>Nama Orang Tua:</span>
            <input type="text" id="txtNamaOrtu" name="txtNamaOrtu" placeholder="Masukkan Nama Orang Tua" required
                   value="<?= isset($old_bio['ortu']) ? htmlspecialchars($old_bio['ortu']) : htmlspecialchars($bio['cnama_ortu'] ?? ''); ?>">
        </label>
        <label for="txtNamaKakak"><span>Nama Kakak:</span>
            <input type="text" id="txtNamaKakak" name="txtNamaKakak" placeholder="Masukkan Nama Kakak"
                   value="<?= isset($old_bio['kakak']) ? htmlspecialchars($old_bio['kakak']) : htmlspecialchars($bio['cnama_kakak'] ?? ''); ?>">
        </label>
        <label for="txtNamaAdik"><span>Nama Adik:</span>
            <input type="text" id="txtNamaAdik" name="txtNamaAdik" placeholder="Masukkan Nama Adik"
                   value="<?= isset($old_bio['adik']) ? htmlspecialchars($old_bio['adik']) : htmlspecialchars($bio['cnama_adik'] ?? ''); ?>">
        </label>
        <button type="submit" name="submit_biodata">Update Biodata</button>
        <button type="reset">Batal</button>
    </form>
</section>

<section class="biodata-display">
    <h2>Biodata Saat Ini</h2>
    <?php
    $biodata = $_SESSION["biodata"] ?? [];
    $fieldConfig = [
        'nim' => 'NIM',
        'nama' => 'Nama Lengkap',
        'tempat' => 'Tempat Lahir',
        'tanggal' => 'Tanggal Lahir',
        'hobi' => 'Hobi',
        'pasangan' => 'Pasangan',
        'pekerjaan' => 'Pekerjaan',
        'ortu' => 'Nama Orang Tua',
        'kakak' => 'Nama Kakak',
        'adik' => 'Nama Adik',
    ];

    foreach ($fieldConfig as $key => $label) {
        $value = $bio[str_replace(['nama', 'tempat', 'tanggal', 'hobi', 'pasangan', 'pekerjaan', 'ortu', 'kakak', 'adik'], ['cnama', 'ctempat_lahir', 'dtanggal_lahir', 'chobi', 'cpasangan', 'cpekerjaan', 'cnama_ortu', 'cnama_kakak', 'cnama_adik'], $key)] ?? '';
        echo "<p><strong>$label:</strong> " . htmlspecialchars($value) . "</p>";
    }
    ?>
</section>

</body>
</html>