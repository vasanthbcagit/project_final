<?php
require "db.php";

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

header('Content-Type: application/json');

if(!$id || !$status) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE scholarship_applications SET status=? WHERE id=?");
    $stmt->execute([$status, $id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
