<?php
session_start();
require_once('../../database/connection.php');

// Check if user is logged in and has the necessary permissions
if ($_SESSION['role'] !== 'admin') {
  // Redirect to a suitable page if not authorized
  header('Location: ../systems/login.php');
  exit();
}

// Check if the ID is provided in the query parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  // Redirect to an error page or suitable location
  header('Location: ../error.php');
  exit();
}

$id = $_GET['id'];

// Retrieve material data for deletion
$query = "SELECT id FROM materials WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$material = $result->fetch_assoc();
$stmt->close();

// Check if the material exists
if (!$material) {
  // Redirect to an error page or suitable location
  header('Location: ../error.php');
  exit();
}

// Perform deletion logic and database operations here
$query = "DELETE FROM materials WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

// Redirect to a suitable page after deletion
header('Location: materialsList.php');
exit();
