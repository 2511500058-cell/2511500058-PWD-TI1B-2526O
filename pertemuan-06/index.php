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
                <li><a href="#ipk">IPK</a></li>
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

        <section id="ipk">
        <h2>Nilai Saya</h2>
        <?php
        $namaMatkul1 = "Algoritma dan Struktur Data";
        $namaMatkul2 = "Agama";
        $namaMatkul3 = "Bahasa Inggris";
        $namaMatkul4 = "Matematika Komputer";
        $namaMatkul5 = "Pemrograman Web Dasar";

        $sksMatkul1 = 4;
        $sksMatkul2 = 2;
        $sksMatkul3 = 3;
        $sksMatkul4 = 3;
        $sksMatkul5 = 3;

        $nilaiHadir1 = 90; $nilaiTugas1 = 60; $nilaiUTS1 = 80; $nilaiUAS1 = 70;
        $nilaiHadir2 = 70; $nilaiTugas2 = 50; $nilaiUTS2 = 60; $nilaiUAS2 = 80;
        $nilaiHadir3 = 85; $nilaiTugas3 = 75; $nilaiUTS3 = 65; $nilaiUAS3 = 80;
        $nilaiHadir4 = 95; $nilaiTugas4 = 85; $nilaiUTS4 = 80; $nilaiUAS4 = 90;
        $nilaiHadir5 = 69; $nilaiTugas5 = 80; $nilaiUTS5 = 90; $nilaiUAS5 = 100;

        function hitungNilaiAkhir($hadir, $tugas, $uts, $uas) {
          return (0.1 * $hadir) + (0.2 * $tugas) + (0.3 * $uts) + (0.4 * $uas);
        }

        function tentukanGrade($nilaiAkhir, $hadir) {
          if ($hadir < 70) return "E";
          if ($nilaiAkhir >= 85) return "A";
          elseif ($nilaiAkhir >= 80) return "A-";
          elseif ($nilaiAkhir >= 75) return "B+";
          elseif ($nilaiAkhir >= 70) return "B";
          elseif ($nilaiAkhir >= 65) return "B-";
          elseif ($nilaiAkhir >= 60) return "C+";
          elseif ($nilaiAkhir >= 55) return "C";
          elseif ($nilaiAkhir >= 50) return "C-";
          elseif ($nilaiAkhir >= 45) return "D";
          else return "E";
        }

        function angkaMutu($grade) {
          switch ($grade) {
            case "A": return 4.00;
            case "A-": return 3.70;
            case "B+": return 3.30;
            case "B": return 3.00;
            case "B-": return 2.70;
            case "C+": return 2.30;
            case "C": return 2.00;
            case "C-": return 1.70;
            case "D": return 1.00;
            default: return 0.00;
          }
        }

        function statusKelulusan($grade) {
          return ($grade == "D" || $grade == "E") ? "Gagal" : "Lulus";
        }

        for ($i=1; $i<=5; $i++) {
          ${"nilaiAkhir$i"} = hitungNilaiAkhir(${"nilaiHadir$i"}, ${"nilaiTugas$i"}, ${"nilaiUTS$i"}, ${"nilaiUAS$i"});
          ${"grade$i"} = tentukanGrade(${"nilaiAkhir$i"}, ${"nilaiHadir$i"});
          ${"mutu$i"} = angkaMutu(${"grade$i"});
          ${"bobot$i"} = ${"mutu$i"} * ${"sksMatkul$i"};
          ${"status$i"} = statusKelulusan(${"grade$i"});
        }

        $totalBobot = $bobot1 + $bobot2 + $bobot3 + $bobot4 + $bobot5;
        $totalSKS = $sksMatkul1 + $sksMatkul2 + $sksMatkul3 + $sksMatkul4 + $sksMatkul5;
        $IPK = $totalBobot / $totalSKS;

        for ($i=1; $i<=5; $i++) {
          echo "<hr>";
          echo "<p><strong>Nama Matakuliah ke-$i :</strong> ${'namaMatkul'.$i}</p>";
          echo "<p><strong>SKS :</strong> ${'sksMatkul'.$i}</p>";
          echo "<p><strong>Kehadiran :</strong> ${'nilaiHadir'.$i}</p>";
          echo "<p><strong>Tugas :</strong> ${'nilaiTugas'.$i}</p>";
          echo "<p><strong>UTS :</strong> ${'nilaiUTS'.$i}</p>";
          echo "<p><strong>UAS :</strong> ${'nilaiUAS'.$i}</p>";
          echo "<p><strong>Nilai Akhir :</strong> " . number_format(${"nilaiAkhir$i"}, 2) . "</p>";
          echo "<p><strong>Grade :</strong> ${'grade'.$i}</p>";
          echo "<p><strong>Angka Mutu :</strong> " . number_format(${"mutu$i"}, 2) . "</p>";
          echo "<p><strong>Bobot :</strong> " . number_format(${"bobot$i"}, 2) . "</p>";
          echo "<p><strong>Status :</strong> ${'status'.$i}</p>";
        }

        echo "<hr>";
        echo "<p><strong>Total Bobot =</strong> " . number_format($totalBobot, 2) . "</p>";
        echo "<p><strong>Total SKS =</strong> $totalSKS</p>";
        echo "<p><strong>IPK =</strong> " . number_format($IPK, 2) . "</p>";
        ?>
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