<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Mahasiswa</title>
    <link rel="stylesheet"href="mystyle.css">
</head>
<body>
    <div class="container">
        <h1>Edit Nilai Mahasiswa</h1>
        <?php
        // Ambil nim, kode_mk, dan nama_mk dari URL
        $nim = $_GET['nim'];
        $kode_mk = $_GET['kode_mk'];

        // URL untuk mengambil data mahasiswa berdasarkan nim dan kode_mk
        $url = 'http://localhost/UTS_PSAIT/api.php?nim=' . $nim . '&kode_mk=' . $kode_mk;

        // Mengambil data mahasiswa dari API
        $response = file_get_contents($url);

        // Menangani respons JSON
        $data = json_decode($response, true);

        // Memeriksa jika data berhasil diambil
        if ($data['status'] == 1) {
            $nilai = $data['data'][0]['nilai'];
            $kode_mk = $data['data'][0]['kode_mk'];
            $nim_mahasiswa = $data['data'][0]['nim'];

            // Form untuk mengedit nilai mahasiswa
            echo '<form method="POST" action="editdata.php">';
            echo '<input type="hidden" name="nim" value="' . $nim . '">';
            echo '<input type="hidden" name="kode_mk" value="' . $kode_mk . '">';
            echo '<label for="nim_mahasiswa">NIM Mahasiswa</label>';
            echo '<input type="text" id="nim_mahasiswa" name="nim_mahasiswa" value="' . $nim_mahasiswa . '" readonly>';
            echo '<label for="kode_mk">Kode Mata Kuliah</label>';
            echo '<input type="text" id="kode_mk" name="kode_mk" value="' . $kode_mk . '" readonly>';
            echo '<label for="nilai">Nilai</label>';
            echo '<input type="text" id="nilai" name="nilai" value="' . $nilai . '">';
            echo '<input type="submit" name="submit" value="Update">';
            echo '</form>';
        } else {
            // Jika data tidak berhasil diambil
            echo '<p class="message">Gagal mengambil data nilai mahasiswa.</p>';
        }
        ?>
    </div>
</body>
</html>
