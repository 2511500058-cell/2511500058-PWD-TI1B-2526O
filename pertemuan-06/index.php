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
            </ul>
        </nav>
    </header>
    <main>
        <section id="home">
            <h2>Selamat datang</h2>
            <p>Ini contoh paragraf HTML.</p>
            <?php
echo "Halo Dunia!"; 
echo "<br>Nama saya Muhammad Tio Saputra"
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
            <style>
                #about p {
                    display: flex;
                    justify-content: flex-start;
                    align-items: baseline;
                    margin: 0;
                    padding: 6px 0;
                    border-bottom: 1px solid #e6e6e6;
                }

                #about strong {
                    min-width: 180px;
                    color: #003366;
                    font-weight: 600;
                    text-align: right;
                    padding-right: 16px;
                    flex-shrink: 0;
                }

                @media (max-width: 600px) {
                    #about p {
                        flex-direction: column;
                        align-items: flex-start;
                    }

                    #about strong {
                        text-align: left;
                        padding-right: 0;
                        margin-bottom: 2px;
                    }
                }
            </style>
            <p><strong>NIM:</strong> 2511500058<?php echo $NIM; ?></p>
            <p><strong>Nama Lengkap:</strong><?php echo $nama; ?></p>
            <p><strong>Tempat Lahir:</strong><?php echo $tempatlahir; ?></p>
            <p><strong>Tanggal Lahir:</strong><?php echo $tanggallahir; ?></p>
            <p><strong>Hobi:</strong><?php echo $hobi; ?></p>
            <p><strong>Pasangan:</strong><?php echo $pasangan; ?></p>
            <p><strong>Pekerjaan:</strong><?php echo $pekerjaan; ?></p>
            <p><strong>Nama Orang Tua:</strong><?php echo $namaortu; ?></p>
            <p><strong>Nama Kakak:</strong><?php echo $namakakak; ?></p>

        </section>
        <section id="contact">
            <h2>Kontak Saya</h2>
            <form action="" method="GET">
                <label for="txtNama"><span>Nama:</span>
                    <input type="text" id="txtNama" name="txtNama" placeholder="Masukan Nama"
                        requiredautocomplete="name">
                </label>
                <label for="txtEmail"><span>Email:</span>
                    <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukan Email"
                        requiredautocomplete="email">
                </label>
                <label for="txtPesan"><span>Pesan:</span>
                    <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan kamu..."
                        required></textarea>
                    <small id="charCount">0/200 karakter</small>
                </label>
                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Muhammad Tio Saputra [2511500058]</p>
    </footer>
    <script src="script.js"></script>
</body>

</html>