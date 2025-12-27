<?php
require "db.php";

$name = $_POST['name'] ?? '';
$department = $_POST['department'] ?? '';

if(!$name || !$department){
    echo "error";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO scholarships (name, department) VALUES (?, ?)");
if($stmt->execute([$name, $department])){
    echo "success";
} else {
    echo "error";
}
