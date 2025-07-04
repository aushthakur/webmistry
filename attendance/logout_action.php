<?php
session_start();
include('db_connect.php');
header('Content-Type: application/json');

$email = $_SESSION['user'];
$logout_time = date('Y-m-d H:i:s');

$query = "SELECT login_time FROM attendance WHERE email='$email' AND logout_time IS NULL ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $login_time = $row['login_time'];
    $duration = round((strtotime($logout_time) - strtotime($login_time)) / 3600, 2);
    $update = "UPDATE attendance SET logout_time='$logout_time', total_hours='$duration' WHERE email='$email' AND logout_time IS NULL";
    mysqli_query($con, $update);
}

echo json_encode(["status" => "success"]);
?>