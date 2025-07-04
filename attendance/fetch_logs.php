<?php
include_once('db_connect.php');
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit('Unauthorized');
}

$email = mysqli_real_escape_string($con, $_SESSION['user']);
$from = mysqli_real_escape_string($con, $_GET['from'] ?? '');
$to = mysqli_real_escape_string($con, $_GET['to'] ?? '');

if (!$from || !$to) {
    echo "<tr><td colspan='6' class='text-danger text-center'>Date range missing</td></tr>";
    exit;
}

$query = "SELECT * FROM attendance 
          WHERE email = '$email' 
          AND log_date BETWEEN '$from' AND '$to' 
          ORDER BY log_date DESC";

$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<tr><td colspan='6' class='text-muted text-center'>No records found for selected range</td></tr>";
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['log_date']}</td>
        <td>" . ($row['login_time'] ?: '-') . "</td>
        <td>" . ($row['break_time'] ?: '-') . "</td>
        <td>" . ($row['continue_time'] ?: '-') . "</td>
        <td>" . ($row['logout_time'] ?: '-') . "</td>
        <td><strong>" . ($row['total_hours'] ?: '-') . "</strong></td>
    </tr>";
}
