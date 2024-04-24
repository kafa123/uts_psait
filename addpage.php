<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet"href="mystyle.css">
</head>
<body>
    <h1>Insert Nilai Mahasiswa</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" required>

        <label for="kode_mk">Kode Mata Kuliah:</label>
        <input type="text" name="kode_mk" id="kode_mk" required>

        <label for="nilai">Nilai:</label>
        <input type="number" name="nilai" id="nilai" min="0" max="100" required>

        <input type="submit" name="submit" value="Submit">
    </form>
    
    <?php
    if(isset($_POST['submit'])) {
        $nim = $_POST['nim'];
        $kode_mk = $_POST['kode_mk'];
        $nilai = $_POST['nilai'];
        $url = 'http://localhost/UTS_PSAIT/api.php';
        $ch = curl_init($url);
        $jsonData = array(
            'nim' =>  $nim,
            'kode_mk' =>  $kode_mk,
            'nilai' =>  $nilai,
        );

        $jsonDataEncoded = json_encode($jsonData);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        curl_close($ch);
        echo "<center><br>status :  {$result["status"]} "; 
        echo "<br>";
        echo "message :  {$result["message"]} "; 
        echo "<br><a href=index.php> OK </a></center>";
    }
    ?>
</body>
</html>
