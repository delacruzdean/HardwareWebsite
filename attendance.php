<?php




session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

// Ensure the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit();
}

// Handle Time In
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['time_in'])) {
    $user_id = $_POST['user_id'];
    $time_in = date('Y-m-d H:i:s');
    $sql = "INSERT INTO attendance (user_id, time_in) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $time_in);
    $stmt->execute();
    header("Location: attendance.php");
    exit();
}

// Handle Time Out
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['time_out'])) {
    $id = $_POST['id'];
    $time_out = date('Y-m-d H:i:s');
    $sql = "UPDATE attendance SET time_out=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $time_out, $id);
    $stmt->execute();
    header("Location: attendance.php");
    exit();
}

// Fetch attendance records
$sql = "SELECT a.id, u.username, a.time_in, a.time_out 
        FROM attendance a
        JOIN users u ON a.user_id = u.id
        ORDER BY a.time_in DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}

// Calculate total hours per user
$hours_summary = [];
while ($row = $result->fetch_assoc()) {
    if ($row['time_out'] !== null) {
        $hours = (strtotime($row['time_out']) - strtotime($row['time_in'])) / 3600;
        if (!isset($hours_summary[$row['username']])) {
            $hours_summary[$row['username']] = 0;
        }
        $hours_summary[$row['username']] += $hours;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Attendance</title>
    <link rel="stylesheet" href="css/attendance_styles.css">
</head>
<body>
    <div class="container">
        <header>Attendance</header>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['time_in'] ?></td>
                <td><?= $row['time_out'] ?></td>
                <td>
                    <?php if ($row['time_out'] === null): ?>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="time_out">Time Out</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <form method="post" action="">
            <select name="user_id">
                <?php
                $user_sql = "SELECT id, username FROM users";
                $user_result = $conn->query($user_sql);
                while ($user_row = $user_result->fetch_assoc()):
                ?>
                <option value="<?= $user_row['id'] ?>"><?= $user_row['username'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="time_in">Time In</button>
        </form>
        <h2>Hours Summary</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Total Hours</th>
            </tr>
            <?php foreach ($hours_summary as $username => $hours): ?>
            <tr>
                <td><?= $username ?></td>
                <td><?= round($hours, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="admin_home.html"><button>Back to Admin Home</button></a>
    </div>
</body>
</html>
