<?php
include_once('db_connect.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

$email = $_SESSION['user'];
$today = date('Y-m-d');

$res = mysqli_query($con, "SELECT * FROM attendance WHERE email='$email' AND log_date='$today'");
$row = mysqli_fetch_assoc($res);

if ($row) {
    echo json_encode([
        'status' => 'logged_in',
        'login_time' => $row['login_time'],
        'break_started' => $row['break_started'],
        'break_time' => $row['break_time'] ?? null,
        'continue_time' => $row['continue_time'] ?? null
    ]);
} else {
    echo json_encode(['status' => 'not_logged']);
}
