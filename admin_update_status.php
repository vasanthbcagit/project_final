<?php
include "db.php";

$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE applications SET status='$status' WHERE id=$id";

if(mysqli_query($conn, $sql)){
    echo "success";
} else {
    echo "error";
}
?>
