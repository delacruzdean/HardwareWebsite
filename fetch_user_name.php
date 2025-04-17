<?php
include "connection.php";

$username = $_POST['username'];

$stmt = $conn->prepare("SELECT name FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo $row['name'];
?>
