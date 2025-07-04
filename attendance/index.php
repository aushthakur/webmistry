<?php
include_once('db_connect.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user'];
$query = "SELECT * FROM registration WHERE email = '$email'";
$data = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($data);
$name = $row['first_name'] . " " . $row['last_name'];
$profilePic = !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.png';

date_default_timezone_set("Asia/Kolkata");
$log_date = date('Y-m-d');
$now = date('H:i:s');

// Fetch today's record
$attendance = mysqli_query($con, "SELECT * FROM attendance WHERE email='$email' AND log_date='$log_date'");
$record = mysqli_fetch_assoc($attendance);

$isLoggedIn = $record ? true : false;
$loginTime = $record ? $record['login_time'] : null;
$breakStarted = $record ? $record['break_started'] : 0;
$breakTime = $record ? $record['break_time'] : null;
$logoutDone = $record ? $record['logout_time'] !== null : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar-brand img { height: 40px; }
        .dashboard { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 12px rgba(0,0,0,0.05); }
        .timer { font-size: 1.8rem; margin: 20px 0; font-weight: 600; color: #333; }
        .profile-img { height: 35px; width: 35px; border-radius: 50%; object-fit: cover; }
        .log-table th, .log-table td { text-align: center; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">AskWebMistry</a>
    <div class="ms-auto">
        <div class="dropdown">
            <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <img src="<?php echo $profilePic; ?>" class="profile-img me-2"> <?php echo $name; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> My Profile</a></li>
                <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="dashboard text-center">
    <h2>Welcome, <?php echo $name; ?> 👋</h2>
    <div class="timer" id="timer">00:00:00</div>
    <div>
        <button onclick="startLogin()" class="btn btn-success m-2">Login</button>
        <button onclick="pauseTimer()" class="btn btn-warning m-2">Break</button>
        <button onclick="resumeTimer()" class="btn btn-info m-2">Continue</button>
        <button onclick="handleLogout()" class="btn btn-danger m-2">Logout</button>
    </div>
</div>

<div class="alert alert-warning text-left m-3" style="font-weight:500;">
  ⚠️ <strong>Important Rules:</strong><br>
  🔹 Do <u>not reload or close</u> the tab during working hours.<br>
  🔹 If you logout by mistake, <u>immediately inform your reporting manager</u>.<br>
  🔹 <u>Never login twice</u> on the same day.<br>
  🔹 <u>Always press Break</u> before Continue.<br>
  🔹 <u>Never press Continue</u> without a Break.<br>
  🔹 <u>Logout only after informing</u> your manager.  
</div>


<script>
    
window.onbeforeunload = function () {
  return "Are you sure you want to leave? Your session and timer may be lost!";
};
window.addEventListener('beforeunload', function () {
  navigator.sendBeacon('?action=break');
});
localStorage.setItem('isOnBreak', true);
const wasOnBreak = localStorage.getItem('isOnBreak') === 'true';
history.pushState(null, null, window.location.href);
window.onpopstate = function () {
  history.go(1);
};
// Save timestamp on tab close
window.addEventListener('beforeunload', () => {
    if (!isLoggedOut && !isPaused) {
        localStorage.setItem('lastLeft', Date.now());
    } else {
        localStorage.removeItem('lastLeft');
    }
});

let interval = null;
let isPaused = <?php echo $breakStarted ? 'true' : 'false'; ?>;
let loginTime = "<?php echo $loginTime; ?>";
let timer = 0;

function formatTime(sec) {
    const h = String(Math.floor(sec / 3600)).padStart(2, '0');
    const m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
    const s = String(sec % 60).padStart(2, '0');
    return `${h}:${m}:${s}`;
}

function calculateElapsed() {
    if (!loginTime) return;
    const now = new Date();
    const login = new Date(now.toDateString() + ' ' + loginTime);
    timer = Math.floor((now - login) / 1000);
    updateDisplay();
}

function updateDisplay() {
    document.getElementById('timer').textContent = formatTime(timer);
}

function startLogin() {
    fetch('?login=1')
    .then(() => {
        Swal.fire('Login Started', '', 'success');
        loginTime = new Date().toTimeString().slice(0,8);
        isPaused = false;
        calculateElapsed();
        interval = setInterval(() => {
            if (!isPaused) { timer++; updateDisplay(); }
        }, 1000);
    });
}

function pauseTimer() {
    isPaused = true;
    fetch('?break=1');
    Swal.fire('Break Started', 'Have your break but don\'t get it too long!', 'info');
}

function resumeTimer() {
    isPaused = false;
    fetch('?continue=1');
    Swal.fire('Welcome Back!', '', 'success');
}

function handleLogout() {
    isPaused = true;
    fetch('?logout=1')
    .then(() => {
        Swal.fire('Thanks for working today!', `Working Hours: ${formatTime(timer)}`, 'success');
        clearInterval(interval);
    });
}

window.onload = function() {
    calculateElapsed();
    if (loginTime) {
        interval = setInterval(() => {
            if (!isPaused) { timer++; updateDisplay(); }
        }, 1000);
    }
};
function calculateTime() {
    if (!loginTime || isLoggedOut) return;

    const now = new Date();
    const login = new Date(now.toDateString() + ' ' + loginTime);
    timer = Math.floor((now - login) / 1000) - breakDuration;

    const lastLeft = localStorage.getItem('lastLeft');
    if (lastLeft && !isPaused) {
        const diff = Math.floor((Date.now() - parseInt(lastLeft)) / 1000);
        timer -= diff;
        localStorage.removeItem('lastLeft');
    }

    if (timer < 0) timer = 0;
}

</script>

</body>
</html>

<?php
// Handle actions
if (isset($_GET['login'])) {
    if (!$isLoggedIn && !$logoutDone) {
        mysqli_query($con, "INSERT INTO attendance (email, log_date, login_time) VALUES ('$email', '$log_date', '$now')");
    }
    exit();
}

if (isset($_GET['break'])) {
    mysqli_query($con, "UPDATE attendance SET break_started = 1, break_time = '$now' WHERE email='$email' AND log_date='$log_date'");
    exit();
}

if (isset($_GET['continue'])) {
    mysqli_query($con, "UPDATE attendance SET break_started = 0, continue_time = '$now' WHERE email='$email' AND log_date='$log_date'");
    exit();
}

if (isset($_GET['logout'])) {
    // Fetch old data
    $result = mysqli_query($con, "SELECT login_time, break_time, continue_time, break_duration FROM attendance WHERE email='$email' AND log_date='$log_date'");
    $record = mysqli_fetch_assoc($result);

    $login_time = $record['login_time'];
    $logout_time = $now;

    // Calculate working seconds
    $start = strtotime($login_time);
    $end = strtotime($logout_time);
    $working_seconds = $end - $start;

    // Subtract break time if any
    $break_seconds = $record['break_duration'] ?? 0;
    $net_seconds = max(0, $working_seconds - $break_seconds);

    $total_hours = gmdate('H:i:s', $net_seconds);

    mysqli_query($con, "UPDATE attendance SET logout_time = '$now', total_hours = '$total_hours' WHERE email='$email' AND log_date='$log_date'");
    exit();
}

?>
