<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet"href="mystyle.css">
</head>
<body>
    <h1 class="title">Perkuliahan</h1>
    <table id="nilai_table">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Kode Matakuliah</th>
                <th>Nama Matakuliah</th>
                <th>SKS</th>
                <th>Nilai</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ambil data dari API
            $data = file_get_contents('http://localhost/UTS_PSAIT/api.php');
            $data = json_decode($data, true);

            // Cek apakah data berhasil diambil
            if ($data['status'] == 1) {
                foreach ($data['data'] as $item) {
                    echo '<tr>';
                    echo '<td>' . $item['nim'] . '</td>';
                    echo '<td>' . $item['nama_mahasiswa'] . '</td>';
                    echo '<td>' . $item['alamat'] . '</td>';
                    echo '<td>' . $item['tanggal_lahir'] . '</td>';
                    echo '<td>' . $item['kode_mk'] . '</td>';
                    echo '<td>' . $item['nama_mk'] . '</td>';
                    echo '<td>' . $item['sks'] . '</td>';
                    echo '<td>' . $item['nilai'] . '</td>';
                    echo '<td class="action-buttons">';
                    echo '<button class="edit" onclick="location.href=\'editpage.php?nim=' . $item['nim'] . '&kode_mk=' . $item['kode_mk'] . '\'">Edit</button>';
                    echo '<button class="delete" onclick="deleteData(\'' . $item['nim'] . '\', \'' . $item['kode_mk'] . '\')">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="9">Gagal mengambil data: ' . $data['message'] . '</td></tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="add-button">
        <a href="halamanaddnilai.php">Add Nilai</a>
    </div>

    <!-- ini ngeprompt pak untuk auto refresh ketika delete data -->
    <script>
        function deleteData(nim, kode_mk) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.reload();
                    }
                };
                xhttp.open("GET", "deletedata.php?nim=" + nim + "&kode_mk=" + kode_mk, true);
                xhttp.send();
            }
        }
    </script>
</body>
</html>
