<?php
session_start();
require "koneksi.php";
require "fungsi.php";

#ambil pesan flash kalau ada
$flash_sukses = $_SESSION["flash_sukses"] ?? "";
$flash_error  = $_SESSION["flash_error"] ?? "";

unset($_SESSION["flash_sukses"], $_SESSION["flash_error"]);

#--------------------------------------------------
# DATA TABEL TAMU (CONTACT)
#--------------------------------------------------
$sqlTamu = "SELECT * FROM tbl_tamu ORDER BY cid DESC";
$qTamu   = mysqli_query($conn, $sqlTamu);
if (!$qTamu) {
    die("Query error (tamu): " . mysqli_error($conn));
}

#--------------------------------------------------
# DATA TABEL BIODATA SEDERHANA MAHASISWA 
#--------------------------------------------------
$sqlBio = "SELECT * FROM Tblbiodata_mhs ORDER BY id DESC";
$qBio   = mysqli_query($conn, $sqlBio);
if (!$qBio) {
    die("Query error (biodata): " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Tamu Dan Biodata Sederhana Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Database Biodata Sederhana Mahasiswa</h1>
</header>

<main>
<section id="flash">
    <?php if (!empty($flash_sukses)) : ?>
        <div style="padding:10px;margin-bottom:10px;background:#d4edda;color:#155724;border-radius:6px;">
            <?= $flash_sukses ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash_error)) : ?>
        <div style="padding:10px;margin-bottom:10px;background:#f8d7da;color:#721c24;border-radius:6px;">
            <?= $flash_error ?>
        </div>
    <?php endif; ?>
</section>

<!-- ==========================================
     1. TABEL BUKU TAMU
     ========================================== -->
<section id="tamu">
    <h2>Data Buku Tamu</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>Created At</th>
        </tr>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($qTamu)) :
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>
                <a href="edit.php?cid=<?= (int)$row["cid"] ?>">Edit</a>
                |
                <a href="proses_delete.php?cid=<?= (int)$row["cid"] ?>"
                   onclick="return confirm('Hapus data tamu ini?')">Delete</a>
            </td>
            <td><?= $row["cid"] ?></td>
            <td><?= htmlspecialchars($row["cnama"]) ?></td>
            <td><?= htmlspecialchars($row["cemail"]) ?></td>
            <td><?= nl2br(htmlspecialchars($row["cpesan"])) ?></td>
            <td><?= formatTanggal(htmlspecialchars($row["dcreated_at"])) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>

<!-- ==========================================
     2. TABEL BIODATA MAHASISWA
     ========================================== -->
<section id="biodata-list">
    <h2>Data Biodata Mahasiswa</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>ID</th>
            <th>NIM</th>
            <th>Nama Lengkap</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Hobi</th>
            <th>Pasangan</th>
            <th>Pekerjaan</th>
            <th>Nama Ortu</th>
            <th>Nama Kakak</th>
            <th>Nama Adik</th>
        </tr>
        <?php
        $j = 1;
        while ($row = mysqli_fetch_assoc($qBio)) :
        ?>
        <tr>
            <td><?= $j++ ?></td>
            <td>
                <a href="edit_biodata.php?id=<?= (int)$row["id"] ?>">Edit</a>
                |
                <a href="proses_delete_biodata.php?id=<?= (int)$row["id"] ?>"
                   onclick="return confirm('Ingin hapus biodata ini?')">Delete</a>
            </td>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["nim"]) ?></td>
            <td><?= htmlspecialchars($row["nama_lengkap"]) ?></td>
            <td><?= htmlspecialchars($row["tempat_lahir"]) ?></td>
            <td><?= htmlspecialchars($row["tanggal_lahir"]) ?></td>
            <td><?= htmlspecialchars($row["hobi"]) ?></td>
            <td><?= htmlspecialchars($row["pasangan"]) ?></td>
            <td><?= htmlspecialchars($row["pekerjaan"]) ?></td>
            <td><?= htmlspecialchars($row["nama_ortu"]) ?></td>
            <td><?= htmlspecialchars($row["nama_kakak"]) ?></td>
            <td><?= htmlspecialchars($row["nama_adik"]) ?></td>
        <?php endwhile; ?>
    </table>
</section>
</main>
</body>
</html>