<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sqlTamu = "SELECT * FROM tbl_tamu ORDER BY cid DESC";
  $qTamu = mysqli_query($conn, $sqlTamu);
  if (!$qTamu) die("Query Tamu error: " . mysqli_error($conn));

  $sqlBio = "SELECT * FROM tbl_pengunjung ORDER BY pid DESC";
  $qBio = mysqli_query($conn, $sqlBio);
  if (!$qBio) die("Query Biodata error: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Data Pengunjung</title>
  <style>
    /* Reset dan font dasar */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f7fa;
      color: #333;
      line-height: 1.6;
      padding: 20px;
    }

    /* Header */
    h1 {
      color: #2c3e50;
      margin-bottom: 10px;
      font-size: 2.5em;
      text-align: center;
    }
    .header-link {
      display: block;
      text-align: center;
      margin-bottom: 30px;
    }
    .header-link a {
      color: #3498db;
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border: 2px solid #3498db;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }
    .header-link a:hover {
      background-color: #3498db;
      color: white;
    }

    /* Flash messages */
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: bold;
      text-align: center;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    /* Section headers */
    h2 {
      color: #2c3e50;
      border-bottom: 3px solid #3498db;
      padding-bottom: 10px;
      margin-top: 40px;
      margin-bottom: 20px;
      font-size: 1.8em;
    }

    /* Tables */
    .table-container {
      overflow-x: auto;
      margin-bottom: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #3498db;
      color: white;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 0.9em;
    }
    tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    tr:hover {
      background-color: #e9ecef;
    }
    td a {
      color: #3498db;
      text-decoration: none;
      font-weight: bold;
      margin-right: 10px;
    }
    td a:hover {
      text-decoration: underline;
    }
    .delete-link {
      color: #e74c3c;
    }
    .delete-link:hover {
      color: #c0392b;
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        padding: 10px;
      }
      h1 {
        font-size: 2em;
      }
      th, td {
        padding: 8px 10px;
        font-size: 0.9em;
      }
      .table-container {
        font-size: 0.8em;
      }
    }
  </style>
</head>
<body>

<h1>Halaman Semua Data Pengunjung</h1>
<div class="header-link">
  <a href="index.php">Pergi ke Halaman Utama</a>
</div>

<?php
  $flash_sukses = $_SESSION['flash_sukses'] ?? ''; 
  $flash_error  = $_SESSION['flash_error'] ?? ''; 
  unset($_SESSION['flash_sukses'], $_SESSION['flash_error']); 
?>

<?php if (!empty($flash_sukses)): ?>
  <div class="alert alert-success"><?= htmlspecialchars($flash_sukses); ?></div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($flash_error); ?></div>
<?php endif; ?>

<h2>Data Buku Tamu</h2>
<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Aksi</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Pesan</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while ($row = mysqli_fetch_assoc($qTamu)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td>
            <a href="edit.php?cid=<?= htmlspecialchars($row['cid']); ?>">Edit</a> | 
            <a class="delete-link" onclick="return confirm('Hapus Tamu?')" href="proses_delete.php?cid=<?= htmlspecialchars($row['cid']); ?>">Hapus</a>
          </td>
          <td><?= htmlspecialchars($row['cid']); ?></td>
          <td><?= htmlspecialchars($row['cnama']); ?></td>
          <td><?= htmlspecialchars($row['cemail']); ?></td>
          <td><?= nl2br(htmlspecialchars($row['cpesan'])); ?></td>
          <td><?= formatTanggal(htmlspecialchars($row['dcreated_at'])); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<h2>Data Biodata Pengunjung</h2>
<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Aksi</th>
        <th>ID</th>
        <th>NIM</th>
        <th>Nama Lengkap</th>
        <th>Tempat, Tanggal Lahir</th>
        <th>Hobi</th>
        <th>Pasangan</th>
        <th>Pekerjaan</th>
        <th>Nama Ortu</th>
        <th>Nama Kakak</th>
        <th>Nama Adik</th>
        <th>Create At</th>
      </tr>
    </thead>
    <tbody>
      <?php $j = 1; while ($bio = mysqli_fetch_assoc($qBio)): ?>
        <tr>
          <td><?= $j++ ?></td>
          <td>
            <a href="edit_biodatapengunjung.php?pid=<?= htmlspecialchars($bio['pid']); ?>">Edit</a> | 
            <a class="delete-link" onclick="return confirm('Hapus Biodata <?= htmlspecialchars($bio['cnama']); ?>?')" href="proses_delete_biodatapengunjung.php?pid=<?= htmlspecialchars($bio['pid']); ?>">Hapus</a>
          </td>
          <td><?= htmlspecialchars($bio['pid']); ?></td>
          <td><?= htmlspecialchars($bio['cnim']); ?></td>
          <td><?= htmlspecialchars($bio['cnama']); ?></td>
          <td>
            <?= htmlspecialchars($bio['ctempat_lahir']); ?>, 
            <?= date('d-m-Y', strtotime($bio['dtanggal_lahir'])); ?>
          </td>
          <td><?= htmlspecialchars($bio['chobi']); ?></td>
          <td><?= htmlspecialchars($bio['cpasangan']); ?></td>
          <td><?= htmlspecialchars($bio['cpekerjaan']); ?></td>
          <td><?= htmlspecialchars($bio['cnama_ortu']); ?></td>
          <td><?= htmlspecialchars($bio['cnama_kakak']); ?></td>
          <td><?= htmlspecialchars($bio['cnama_adik']); ?></td>
          <td><?= formatTanggal(htmlspecialchars($bio['dcreated_at'])); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>