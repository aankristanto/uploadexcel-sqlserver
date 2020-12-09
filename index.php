<?php
include_once('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPLOAD EXCEL TO SQL SERVER</title>
</head>
<body>
    <h1>UPLOAD DATA EXCEL TO SQL SERVER</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="inputxls" required>
        <button type="submit" name="tblupload">UPLOAD!</button>
    </form>
</body>
</html>
<?php
require 'assets/phpspreadsheet/vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if(isset($_POST['tblupload'])){
    $arr_file = explode('.', $_FILES['inputxls']['name']);
    $extension = end($arr_file);
 
    if('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
 
    $spreadsheet = $reader->load($_FILES['inputxls']['tmp_name']);
     
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    for($i = 1;$i < count($sheetData);$i++){
        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
        $iddata = (int)$sheetData[$i]['0'];
        $nama   = $sheetData[$i]['1'];
        $alamat = $sheetData[$i]['2'];
        $tsql       = "INSERT INTO dbo.tbldata1 (iddata, nama, alamat) VALUES (?, ?, ?)";
        $var = array($iddata, $nama, $alamat);
        $getResults = sqlsrv_query($conn, $tsql, $var);
        
    }
    echo "<script>alert('UPLOAD DATA BERHASIL!')</script>";
}
?>