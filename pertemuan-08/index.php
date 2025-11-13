<?php
session_start();

$sesnama = "";
if (isset($_SESSION["sesnama"])):
  $sesnama = $_SESSION["sesnama"];
endif;

$sesemail = "";
if (isset($_SESSION["sesemail"])):
  $sesemail = $_SESSION["sesemail"];
endif;

$sespesan = "";
if (isset($_SESSION["sespesan"])):
  $sespesan = $_SESSION["sespesan"];
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Judul Halaman</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Ini Header</h1>
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
      &#9776;
    </button>
    <nav>
      <ul>
        <li><a href="#home">Beranda</a></li>
        <li><a href="#about">Tentang</a></li>
        <li><a href="#contact">Kontak</a></li>
        <li><a href="#entry">Entry Data Mahasiswa</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="home">
      <h2>Selamat Datang</h2>
      <?php
      echo "Halo Dunia!<br>";
      echo "Nama saya Muhammad Tio Saputra<br>";
      ?>
     
   </section>
        <section id="about">
            <?php
            $NIM = "2511500058";
            $nama = "Muhammad Tio Saputra";
            $tempatlahir = "Bangka Tengah";
            $tanggallahir = "24 September 2006";
            $hobi = " Mendengarkan musik, menonton film atau anime, dan bermain game";
            $pasangan = "Tidak ada &#9786";
            $pekerjaan = "Mahasiswa ISB Atma Luhur💙";
            $namaortu = "Bapak Zuharli dan Ibu Zaila";
            $namakakak = "M.Aprianto, Siti Noparia, Septi Yulanda Sari";
            ?>
            <h2>Tentang Muhammad Tio Saputra</h2>

            <p><strong>NIM:</strong><?php echo $NIM; ?></p>
            <p><strong>Nama Lengkap:</strong><?php echo $nama; ?></p>
            <p><strong>Tempat Lahir:</strong><?php echo $tempatlahir; ?></p>
            <p><strong>Tanggal Lahir:</strong><?php echo $tanggallahir; ?></p>
            <p><strong>Hobi:</strong><?php echo $hobi; ?></p>
            <p><strong>Pasangan:</strong><?php echo $pasangan; ?></p>
            <p><strong>Pekerjaan:</strong><?php echo $pekerjaan; ?></p>
            <p><strong>Nama Orang Tua:</strong><?php echo $namaortu; ?></p>
            <p><strong>Nama Kakak:</strong><?php echo $namakakak; ?></p>
        </section>

        <section id="entry"
        <h2>Entry Data Mahasiswa</h2>
                    <label for="NIM">:</label>
                    <input type="text" id="pasangan" name="pasangan">
                </div>
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan:</label>
                    <input type="text" id="pekerjaan" name="pekerjaan">
                </div>
                <div class="form-group">
                    <label for="nama_orang_tua">Nama Orang Tua:</label>
                    <input type="text" id="nama_orang_tua" name="nama_orang_tua">
                </div>
                <div class="form-group">
                    <label for="nama_kakak">Nama Kakak:</label>
                    <input type="text" id="nama_kakak" name="nama_kakak">
                </div>
                <div class="form-group">
                    <label for="nama_adik">Nama Adik:</label>
                    <input type="text" id="nama_adik" name="nama_adik">
                </div>

    <section id="contact">
      <h2>Kontak Kami</h2>
      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required autocomplete="name">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required autocomplete="email">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..." required></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>


        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>

      <?php if (!empty($sesnama)): ?>
        <br><hr>
        <h2>Yang menghubungi kami</h2>
        <p><strong>Nama :</strong> <?php echo $sesnama ?></p>
        <p><strong>Email :</strong> <?php echo $sesemail ?></p>
        <p><strong>Pesan :</strong> <?php echo $sespesan ?></p>
      <?php endif; ?>



    </section>
  </main>

  <footer>
    <p>&copy; 2025 Muhammad Tio Saputra [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>