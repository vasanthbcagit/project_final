<?php
include "db.php";

$id = $_GET['id'] ?? 0;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM scholarships WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: admin_dashboard.php");
exit;
?>
