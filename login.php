<?php
session_start();
include "db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$type = $_POST['type'] ?? '';

if ($username == '' || $password == '') {
    die("Username or Password missing");
}

if ($type === "student") {

    $stmt = $pdo->prepare("SELECT * FROM students WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['student_id'] = $user['id'];
        $_SESSION['student_name'] = $user['username'];

        header("Location: student.html");
        exit;
    } else {
        echo "<script>alert('Invalid Student Login'); window.location='login.html';</script>";
    }

} elseif ($type === "admin") {

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admin.html");
        exit;
    } else {
        echo "<script>alert('Invalid Admin Login'); window.location='login.html';</script>";
    }

} else {
    die("Invalid login type");
}
?>
