<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM applications");

$data = [];
while($row = mysqli_fetch_assoc($result)){
    $row["files"] = explode(",", $row["files"]);
    $data[] = $row;
}

echo json_encode($data);
?>
