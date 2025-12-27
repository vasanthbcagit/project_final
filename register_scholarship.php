<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function uploadFile($file, $folder) {
        $filename = time() . "_" . basename($file["name"]);
        $path = "uploads/$folder/" . $filename;
        move_uploaded_file($file["tmp_name"], $path);
        return $path;
    }

    $sql = "INSERT INTO scholarship_applications (
        scholarship_name, full_name, dno, department, umis_id,
        parent_name, mobile, gender, caste, annual_income, year,
        aadhar, pan, income_cert, community_cert, marksheet, photo
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['scholarship_name'],
        $_POST['full_name'],
        $_POST['dno'],
        $_POST['department'],
        $_POST['umis_id'],
        $_POST['parent_name'],
        $_POST['mobile'],
        $_POST['gender'],
        $_POST['caste'],
        $_POST['annual_income'],
        $_POST['year'],

        uploadFile($_FILES['aadhar'], "aadhar"),
        uploadFile($_FILES['pan'], "pan"),
        uploadFile($_FILES['income_cert'], "income"),
        uploadFile($_FILES['community_cert'], "community"),
        uploadFile($_FILES['marksheet'], "marksheet"),
        uploadFile($_FILES['photo'], "photo")
    ]);

    echo "<script>alert('Scholarship Applied Successfully'); window.location='student_dashboard.php';
</script>";
}
?>
