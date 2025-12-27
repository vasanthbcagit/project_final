<?php
session_start();
require "db.php";

// Fetch all scholarship applications
$stmt = $pdo->query("SELECT * FROM scholarship_applications ORDER BY id DESC");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reviewer Page</title>

<style>
  :root{
  --dark:#12263a;
  --dark-2:#1f2937;
  --gray:#f3f4f6;
  --light:#ffffff;
  --border:#d1d5db;
  --text:#111827;
}

body{
  font-family:"Segoe UI", Arial, sans-serif;
  background:linear-gradient(135deg,#e5e7eb,#f9fafb);
  margin:0;
  padding:30px;
  color:var(--text);
}

/* MAIN CARD */
.container{
  max-width:1250px;
  margin:auto;
  background:var(--light);
  border-radius:18px;
  box-shadow:0 20px 50px rgba(0,0,0,0.15);
  overflow:hidden;
}

/* HEADER (GRAY LIKE ADMIN) */
.header{
  background:linear-gradient(135deg,#1f2937,#374151);
  color:#fff;
  padding:28px 32px;
}
.header h1{
  margin:0;
  font-size:28px;
}
.header p{
  margin-top:6px;
  opacity:.9;
  font-size:14px;
}

/* TABLE */
.table-wrap{
  padding:25px;
  background:var(--gray);
}

table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
}

/* TABLE HEADER */
thead{
  background:#111827;
  color:#fff;
}
th{
  padding:14px;
  font-size:14px;
  text-align:left;
}

/* TABLE BODY */
td{
  padding:14px;
  font-size:14px;
  border-bottom:1px solid var(--border);
  vertical-align:middle;
}

tbody tr:nth-child(even){
  background:#f9fafb;
}
tbody tr:hover{
  background:#e5e7eb;
  transition:.2s;
}

/* FILE BUTTONS (DARK GRAY) */
.file{
  display:inline-block;
  background:#1f2937;
  color:#fff;
  padding:6px 12px;
  margin:4px 4px;
  border-radius:8px;
  font-size:12px;
  font-weight:500;
}

/* STATUS BADGES */
.status{
  padding:8px 16px;
  border-radius:999px;
  font-size:12px;
  font-weight:600;
  display:inline-block;
}

.status-approved{
  background:#10b981;
  color:#fff;
}
.status-cancelled{
  background:#ef4444;
  color:#fff;
}
.status-pending{
  background:#f59e0b;
  color:#fff;
}

/* RESPONSIVE */
@media(max-width:768px){
  th,td{ font-size:12px; }
  .header h1{ font-size:22px; }
}

</style>

</head>
<body>
<div class="container">

  <div class="header">
    <h1>Reviewer Dashboard</h1>
    <p>All student scholarship applications and their status</p>
  </div>

  <div class="table-wrap">
  <?php if(count($applications)>0): ?>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Scholarship</th>
        <th>Department</th>
        <th>Files</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach($applications as $app): ?>
      <tr>
        <td><?= htmlspecialchars($app['full_name']) ?></td>
        <td><?= htmlspecialchars($app['scholarship_name']) ?></td>
        <td><?= htmlspecialchars($app['department']) ?></td>

        <td>
          <?php
          $files=[
            'aadhar'=>'Aadhar',
            'pan'=>'PAN',
            'income_cert'=>'Income',
            'community_cert'=>'Community',
            'marksheet'=>'Marksheet',
            'photo'=>'Photo'
          ];
          foreach($files as $k=>$v){
            if(!empty($app[$k])){
              echo "<span class='file'>📄 $v</span>";
            }
          }
          ?>
        </td>

        <td>
          <span class="status status-<?= strtolower($app['status']) ?>">
            <?= ucfirst($app['status']) ?>
          </span>
        </td>
      </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
  <?php endif; ?>
  </div>

</div>


</body>
</html>
