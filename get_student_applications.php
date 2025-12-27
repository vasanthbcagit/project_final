<?php
session_start();
require "db.php";

if(!isset($_SESSION['student_id'])) {
    echo json_encode(['error' => 'You are not logged in.']);
    exit;
}

$student_id = $_SESSION['student_id'];

$stmt = $pdo->prepare("SELECT id, scholarship_name, department, status FROM scholarship_applications WHERE student_id = ? ORDER BY applied_at DESC");
$stmt->execute([$student_id]);
$apps = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($apps);
?>