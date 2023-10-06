<?php
session_start();
require_once('database/connection.php');

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
// delete the file from the server profile_url
$query = "SELECT profile_url FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($user) {
  $profile_url = $user['profile_url'];
  unlink('' . $profile_url);
}
$stmt->close();

// Perform deletion logic and database operations here
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();




// Redirect to a suitable page after deletion
header('Location: students/studentsList.php');
exit();
