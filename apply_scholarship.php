<?php
include "db.php";

$name = $_POST['name'] ?? '';
$department = $_POST['department'] ?? '';
$scholarship = $_POST['scholarship'] ?? '';

if (empty($name) || empty($department) || empty($scholarship)) {
    echo "error: All fields are required.";
    exit;
}

$upload_dir = "uploads/";

$files = [];

foreach ($_FILES as $key => $file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = time() . "_" . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $upload_dir . $filename)) {
            $files[] = $filename;
        }
    }
}

$file_str = implode(",", $files);

$stmt = $pdo->prepare("INSERT INTO applications (name, department, scholarship, files, status) VALUES (?, ?, ?, ?, 'In Process')");
if ($stmt->execute([$name, $department, $scholarship, $file_str])) {
    echo "success";
} else {
    echo "error";
}
?>
