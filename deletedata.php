<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nim']) && isset($_GET['kode_mk'])) {
    $nim = $_GET['nim'];
    $kode_mk = $_GET['kode_mk'];

    // URL untuk melakukan permintaan delete
    $url = 'http://localhost/UTS_PSAIT/api.php?nim=' . $nim . '&kode_mk=' . $kode_mk;

    // Inisialisasi cURL
    $ch = curl_init();
    
    // Set URL dan metode request
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi request
    $result = curl_exec($ch);
    $result = json_decode($result, true);

    // Tutup koneksi cURL
    curl_close($ch);

    // Tampilkan status dan pesan respons
    print("<center><br>status :  {$result["status"]} "); 
    print("<br>");
    print("message :  {$result["message"]} "); 
    echo "<br><a href=mahasiswa.php> OK </a>";
}
?>
