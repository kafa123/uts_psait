<?php

require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        getNamaMahasiswa();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getNamaMahasiswa() {
    global $mysqli;
    $query = "SELECT nama
FROM mahasiswa";
    $data=array();
    $result = $mysqli->query($query);
    while($row=mysqli_fetch_object($result))
    {
        $data[]=$row;
    }
    $response=array(
        'status' => 1,
        'message' =>'Get List Mahasiswa Successfully.',
        'data' => $data
     );
header('Content-Type: application/json');
echo json_encode($response);
}