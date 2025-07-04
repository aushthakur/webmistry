<?php
// admin.php
session_start();

$admin_email = "admin@askwebmistry.com";
if (!isset($_SESSION['admin'])) {
    if (isset($_GET['admin'])) {
        $_SESSION['admin'] = $_GET['admin'];
    } else {
        die("Access denied. Add ?admin=$admin_email to URL.");
    }
}

include_once ('db_connect.php');

if (!$con) die("DB Error");

$selected_date = isset($_GET['date']) ? $_GET['date'] : null;
$where = $selected_date ? "WHERE log_date='$selected_date'" : "";
$dates = mysqli_query($con, "SELECT DISTINCT log_date FROM attendance ORDER BY log_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Attendance Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f5f5; font-family: 'Segoe UI', sans-serif; }
    .container { margin-top: 30px; }
    table { background: white; border-radius: 10px; overflow: hidden; }
    thead { background: #212529; color: white; }
    .calendar-form { max-width: 400px; margin: 0 auto 30px auto; }
  </style>
</head>
<body>
<div class="container">
  <h2 class="text-center mb-4">Admin - Daily Attendance Report</h2>

  <form class="calendar-form mb-4" method="get">
    <div class="input-group">
      <input type="hidden" name="admin" value="<?php echo $_SESSION['admin']; ?>">
      <input type="date" name="date" class="form-control" value="<?php echo $selected_date; ?>">
      <button class="btn btn-primary" type="submit">View</button>
    </div>
  </form>

  <?php
    $date_query = $selected_date ? "SELECT DISTINCT log_date FROM attendance WHERE log_date='$selected_date'" : "SELECT DISTINCT log_date FROM attendance ORDER BY log_date DESC";
    $date_result = mysqli_query($con, $date_query);
    while ($d = mysqli_fetch_assoc($date_result)):
      $day = $d['log_date'];
      $res = mysqli_query($con, "SELECT a.*, r.first_name, r.last_name FROM attendance a JOIN registration r ON a.email = r.email WHERE log_date='$day'");
  ?>
  <div class="card mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <span><?php echo date('l, d M Y', strtotime($day)); ?></span>
      <strong>
        <?php
          $sum_query = mysqli_query($con, "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_hours))) as total FROM attendance WHERE log_date='$day'");
          $sum_row = mysqli_fetch_assoc($sum_query);
          echo "Total: " . ($sum_row['total'] ?? '00:00:00');
        ?>
      </strong>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered m-0">
          <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Login</th>
            <th>Break</th>
            <th>Continue</th>
            <th>Logout</th>
            <th>Break Duration</th>
            <th>Total Hours</th>
          </tr>
          </thead>
          <tbody>
          <?php $i=1; while ($row = mysqli_fetch_assoc($res)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['login_time']; ?></td>
              <td><?php echo $row['break_time']; ?></td>
              <td><?php echo $row['continue_time']; ?></td>
              <td><?php echo $row['logout_time']; ?></td>
              <td><?php echo gmdate('H:i:s', $row['break_duration']); ?></td>
              <td><?php echo $row['total_hours']; ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>
</body>
</html>
