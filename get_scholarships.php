<?php
require "db.php";

// Fetch all scholarships without ordering by non-existent column
$stmt = $pdo->query("SELECT * FROM scholarships");
$scholarships = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON
header('Content-Type: application/json');
echo json_encode($scholarships, JSON_UNESCAPED_UNICODE);
?>
