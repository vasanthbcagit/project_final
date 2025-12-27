<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin_id'])) {
    echo "unauthorized";
    exit;
}

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

// Allow ONLY these values
$allowed = ['approved', 'cancelled'];

if (!$id || !in_array($status, $allowed, true)) {
    echo "invalid";
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE scholarship_applications SET status=? WHERE id=?"
);

if ($stmt->execute([$status, $id])) {
    echo "success";
} else {
    echo "error";
}
