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
      echo "halo dunia!<br>";
      echo "nama saya hadi";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    <section id="about">
      <?php
      $NIM = "0344300002" ;
      $Nama = "Al kautar Benyamin" ;
      $tempat = "Jebus";
      $tanggal = "23 nov 2020" ;
      $hobi = "Mancing" ;
      $pasangan = "Tidak ada" ;
      $pekerjaan = "Mahasiswa" ;
      $namaortu  = "Zuhar" ;
      $namakakak = "Nopa" ;
      $namaadik = "Septi" ;
      ?>
      <h2>Tentang Saya</h2>
      
    <section>
      <p><strong>NIM:</strong><?php echo $NIM ?>
      <p><strong>Nama Lengkap:</strong><?php echo $Nama ?></p>
      <p><strong>Tempat Lahir:</strong><?php echo $tempat ?></p>
      <p><strong>Tanggal Lahir:</strong><?php echo $tanggal ?></p>
      <p><strong>Hobi:</strong><?php echo $hobi ?></p> 
      <p><strong>Pasangan:</strong><?php echo $pasangan ?></p>
      <p><strong>Pekerjaan:</strong><?php echo $pekerjaan ?></p>
      <p><strong>Nama Orang Tua:</strong><?php echo $namaortu ?></p>
      <p><strong>Nama Kakak:</strong><?php echo $namakakak ?></p>
      <p><strong>Nama Adik:</strong><?php echo $namaadik ?></p>
    </section>

    <section id="entry">
    <h2>Entry Data Mahasiswa</h2>
    <form action="index.php" method="POST" id="entry">
                <div class="form-group">
                    <label for="NIM">NIM:</label>
                    <input type="text" id="NIM" name="NIM" required>
                </div>
                <div class="form-group">
                    <label for="Nama">Nama Lengkap:</label>
                    <input type="text" id="Nama" name="Nama" required>
                </div>
                <div class="form-group">
                    <label for="tempat">Tempat Lahir:</label>
                    <input type="text" id="tempat" name="tempat" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal Lahir:</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="hobi">Hobi:</label>
                    <input type="text" id="hobi" name="hobi">
                </div>
                <div class="form-group">
                    <label for="pasangan">Pasangan:</label>
                    <input type="text" id="pasangan" name="pasangan">
                </div>
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan:</label>
                    <input type="text" id="pekerjaan" name="pekerjaan">
                </div>
                <div class="form-group">
                    <label for="namaortu">Nama Orang Tua:</label>
                    <input type="text" id="namaortu" name="namaortu">
                </div>
                <div class="form-group">
                    <label for="namakakak">Nama Kakak:</label>
                    <input type="text" id="namakakak" name="namakakak">
                    <div class="form-group">
                    <label for="namaadik">Nama Adik:</label>
                    <input type="text" id="namaadik" name="namaadik">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Kirim</button>
                    <button type="reset" class="btn-reset">Batal</button>
                </div>
            </form>
        </div>
    </section>
                
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
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>