<?php
session_start();
require_once('database/connection.php');

// Check if user is logged in and has the necessary permissions
if ($_SESSION['role'] !== 'admin') {
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

// Retrieve subject data for deletion
$query = "SELECT subject_image FROM subjects WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$subject = $result->fetch_assoc();
if ($subject) {
  $subject_image = $subject['subject_image'];
  // Delete the subject image file from the server
  unlink('' . $subject_image);
}
$stmt->close();

// Perform deletion logic and database operations here
$query = "DELETE FROM subjects WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

// Redirect to a suitable page after deletion
header('Location: subjectsList.php');
exit();
