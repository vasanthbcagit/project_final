<?php
// connect database
$host = 'localhost';
$db = 'schlorship_portal'; // your database
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try{
    $pdo = new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die("Database connection failed: ".$e->getMessage());
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $scholarship_name = $_POST['scholarship_name'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $dno = $_POST['dno'] ?? '';
    $department = $_POST['department'] ?? '';
    $umis_id = $_POST['umis_id'] ?? '';
    $parent_name = $_POST['parent_name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $caste = $_POST['caste'] ?? '';
    $annual_income = $_POST['annual_income'] ?? '';
    $year = $_POST['year'] ?? '';

    $uploadsDir = "uploads/";
    if(!is_dir($uploadsDir)) mkdir($uploadsDir,0777,true);

    $files = ['aadhar','pan','income_cert','community_cert','photo'];
    $filePaths = [];

    foreach($files as $f){
        if(isset($_FILES[$f]) && $_FILES[$f]['error']===0){
            $ext = pathinfo($_FILES[$f]['name'],PATHINFO_EXTENSION);
            $filename = $uploadsDir.$dno."_".$f.".".$ext;
            move_uploaded_file($_FILES[$f]['tmp_name'],$filename);
            $filePaths[$f] = $filename;
        }else{
            $filePaths[$f] = null;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO scholarship_applications
    (scholarship_name, full_name, dno, department, umis_id, parent_name, gender, caste, annual_income, year, aadhar, pan, income_cert, community_cert, photo)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->execute([
        $scholarship_name, $full_name, $dno, $department, $umis_id, $parent_name, $gender, $caste, $annual_income, $year,
        $filePaths['aadhar'], $filePaths['pan'], $filePaths['income_cert'], $filePaths['community_cert'], $filePaths['photo']
    ]);

    echo "<h2>Registration Successful!</h2>";
    echo "<p><a href='index.html'>Go back to form</a></p>";
}
?>
