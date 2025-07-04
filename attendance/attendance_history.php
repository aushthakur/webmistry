<?php
include_once('db_connect.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM attendance WHERE email = '$email'");
$total_rows = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_rows / $per_page);

$query = "SELECT * FROM attendance WHERE email = '$email' ORDER BY log_date DESC LIMIT $per_page OFFSET $offset";
$data = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f3f5; }
        .container { max-width: 900px; margin-top: 50px; }
        .table td, .table th { text-align: center; }
    </style>
</head>
<body>
<div class="container bg-white shadow rounded p-4">
    <h4 class="text-center mb-4">📅 My Attendance History</h4>

    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Login</th>
                    <th>Break</th>
                    <th>Continue</th>
                    <th>Logout</th>
                    <th>Total Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($data) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $row['log_date'] ?></td>
                            <td><?= $row['login_time'] ?: '-' ?></td>
                            <td><?= $row['break_time'] ?: '-' ?></td>
                            <td><?= $row['continue_time'] ?: '-' ?></td>
                            <td><?= $row['logout_time'] ?: '-' ?></td>
                            <td><strong><?= $row['total_hours'] ?: '-' ?></strong></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-muted text-center">No attendance records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-3">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</body>
</html>
