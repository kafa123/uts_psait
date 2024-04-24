<?php
if(isset($_POST['submit']))
{    
    $nim = $_POST['nim']; // tambahkan nim ke dalam data yang dikirimkan
    $kode_mk = $_POST['kode_mk']; // tambahkan kode_mk ke dalam data yang dikirimkan
    $nilai = $_POST['nilai']; // tambahkan nilai ke dalam data yang dikirimkan

    // Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
    $url = 'http://localhost/UTS_PSAIT/api.php?nim=' . $nim . '&kode_mk=' . $kode_mk;
    $ch = curl_init($url);

    // Kirimkan data yang akan diupdate dalam format JSON
    $jsonData = array(
        'nilai' => $nilai // hanya nilai yang perlu diupdate
    );
    //Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //Tell cURL that we want to send a PUT request.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);
    $result = json_decode($result, true);
    curl_close($ch);

    // Check if the request was successful or not
    if ($result !== false) {
        if(isset($result["status"]) && $result["status"] == 1) {
            echo "<center><br>status :  {$result["status"]} "; 
            echo "<br>";
            echo "message :  {$result["message"]} "; 
            echo "<br><a href=index.php> OK </a>";
        } else {
            echo "Gagal mengupdate data: " . $result["message"];
        }
    } else {
        echo "Gagal melakukan permintaan ke server.";
    }
}
?>
