<?php
require "db.php";

// Fetch all student applications with files
$stmt = $pdo->query("SELECT * FROM scholarship_applications ORDER BY applied_at DESC");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

$result = [];
foreach($applications as $app){
    $files = [
        ['name'=>'Aadhar','path'=>$app['aadhar']],
        ['name'=>'PAN','path'=>$app['pan']],
        ['name'=>'Income Cert','path'=>$app['income_cert']],
        ['name'=>'Community Cert','path'=>$app['community_cert']],
        ['name'=>'Marksheet','path'=>$app['marksheet']],
        ['name'=>'Photo','path'=>$app['photo']],
    ];
    $result[] = [
        'id'=>$app['id'],
        'name'=>$app['full_name'],
        'scholarship_name'=>$app['scholarship_name'],
        'department'=>$app['department'],
        'status'=>$app['status'],
        'files'=>$files
    ];
}
echo json_encode($result);
