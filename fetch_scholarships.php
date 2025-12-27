<?php
require "db.php";

$stmt = $pdo->query("SELECT * FROM scholarships ORDER BY id DESC");
$sch = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($sch);
