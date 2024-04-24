<?php

require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET["nim"])&&!empty($_GET["kode_mk"])) {
            $student_grades = getGradesByNIM($_GET["nim"],$_GET["kode_mk"]);
        } else {
            getAllGrades();
        }
        break;
    case 'POST':
            insertGrade();

        break;
    case 'PUT':
        if(!empty($_GET["nim"]&&!empty($_GET["kode_mk"]))){
            updateGrade($_GET["nim"], $_GET["kode_mk"]);
        }

        break;
    case 'DELETE':
        if(!empty($_GET["nim"] && !empty($_GET["kode_mk"]))){
            deleteGrade($_GET["nim"], $_GET["kode_mk"]);
        }
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


// Function to get all student grades
function getAllGrades() {
    global $mysqli;
    $query = "SELECT m.nim, m.nama AS nama_mahasiswa, m.alamat, m.tanggal_lahir,
    mk.kode_mk, mk.nama_mk, mk.sks,
    p.nilai
FROM mahasiswa m
JOIN perkuliahan p ON m.nim = p.nim
JOIN matakuliah mk ON p.kode_mk = mk.kode_mk";
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

// Function to get grades for a specific student
function getGradesByNIM($nim,$kode_mk)
{
global $mysqli;
$query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, mahasiswa.tanggal_lahir,
                  matakuliah.kode_mk, matakuliah.nama_mk, matakuliah.sks,
                  perkuliahan.nilai
            FROM mahasiswa
            INNER JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim
            INNER JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk";

if($nim != 0)
{
   $query .= " WHERE perkuliahan.nim = '".$nim."' AND perkuliahan.kode_mk='".$kode_mk."'";
}

$data=array();
$result=$mysqli->query($query);

if ($result) {
   while($row=mysqli_fetch_object($result))
   {
         $data[]=$row;
   }
   $response=array(
         'status' => 1,
         'message' =>'Get Mahasiswa Successfully.',
         'data' => $data
   );
} else {
   $response=array(
         'status' => 0,
         'message' =>'Error: Failed to execute query.'
   );
}

// Mengirim respons ke klien
header('Content-Type: application/json');
echo json_encode($response);
}
// Function to insert a new grade for a specific student
function insertGrade() {
    global $mysqli;
    if(!empty($_POST["nim"])){
        $data=$_POST;
     }else{
        $data = json_decode(file_get_contents('php://input'), true);
     }

     $arrcheckpost = array('nim' => '','kode_mk' => '','nilai'=>'');
     $hitung = count(array_intersect_key($data, $arrcheckpost));
     if($hitung == count($arrcheckpost)){
        $query = "INSERT INTO perkuliahan (nim, kode_mk, nilai) VALUES ('$data[nim]', '$data[kode_mk]', $data[nilai])";
        $result=mysqli_query($mysqli,$query);
        if($result)
        {
            $response=array(
                'status' => 1,
                'message' =>'Mahasiswa Added Successfully.'
             );
          }
          else
          {
             $response=array(
                'status' => 0,
                'message' =>'Mahasiswa Addition Failed.'
             );
        }
     }else{
        $response=array(
            'status' => 0,
            'message' =>'Parameter Do Not Match'
        );
     }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Function to update a grade for a specific student
function updateGrade($nim, $kode_mk) {
    {
        global $mysqli;
    
        // Mengambil data dari payload JSON
        $input_data = file_get_contents("php://input");
        $put_data = json_decode($input_data, true);
    
        // Memeriksa apakah 'nilai' ada dalam data yang diterima
        if (isset($put_data["nilai"])) {
            $nilai = $put_data["nilai"];
            $result = mysqli_query($mysqli, "UPDATE perkuliahan SET nilai='$nilai' WHERE nim='$nim' AND kode_mk='$kode_mk'");
            
            // Menangani respons
            if ($result) {
                $response = array(
                    'status' => 1,
                    'message' => 'Nilai Mahasiswa Updated Successfully.'
                );
            } else {
                $response = array(
                    'status' => 0,
                    'message' => 'Nilai Mahasiswa Updation Failed.'
                );
            }
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Data nilai tidak ditemukan dalam permintaan.'
            );
        }
    
        // Mengirim respons ke klien
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Function to delete a grade for a specific student
function deleteGrade($nim, $kode_mk)    {
    global $mysqli;
    $query = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
    if(mysqli_query($mysqli, $query))
    {
       $response=array(
          'status' => 1,
          'message' =>'Mahasiswa Deleted Successfully.'
       );
    }
    else
    {
       $response=array(
          'status' => 0,
          'message' =>'Mahasiswa Deletion Failed.'
       );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
 }
