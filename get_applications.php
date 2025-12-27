<?php
require "db.php";

$stmt = $pdo->query("
    SELECT a.*, s.name AS scholarship_name, s.department AS scholarship_dept 
    FROM scholarship_applications a
    JOIN scholarships s ON a.scholarship_id = s.id
    ORDER BY a.applied_at DESC
");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($applications);
?>
