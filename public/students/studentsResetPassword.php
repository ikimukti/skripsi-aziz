<?php
session_start();
require_once('../../database/connection.php');

// Check if user is logged in and has the necessary permissions
if ($_SESSION['role'] === 'student') {
  // Redirect to a suitable page if not authorized
  header('Location: systems/login.php');
  exit();
}

// Check if the ID is provided in the query parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  // Redirect to an error page or suitable location
  header('Location: error.php');
  exit();
}

$id = $_GET['id'];

// Perform reset password logic and database operations here
$newPassword = hash('sha256', '12345678');
$query = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $newPassword, $id);
$stmt->execute();
$stmt->close();

// Redirect to a suitable page after deletion
header('Location: students/studentsList.php');
exit();
