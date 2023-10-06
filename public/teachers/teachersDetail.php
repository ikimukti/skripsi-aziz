<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Check if the ID is provided in the query parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  // Redirect to an error page or suitable location
  header('Location: error.php');
  exit();
}

$id = $_GET['id'];

// Fetch users role student data from the database based on the provided ID
$query = "SELECT * FROM users WHERE id = ? AND role = 'teacher'";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the class exists
if ($result->num_rows !== 1) {
  // Redirect to an error page or suitable location
  header('Location: error.php');
  exit();
}

// Fetch the class details
$teacher = $result->fetch_assoc();
?>

<!-- Start HTML content for classesDetail.php -->
<div class="h-screen flex flex-col">
  <!-- Top Navbar -->
  <?php include('../components/navbar.php'); ?>
  <!-- End Top Navbar -->

  <!-- Main Content -->
  <div class="flex-grow bg-gray-50 flex flex-row shadow-md">
    <!-- Sidebar -->
    <?php include('../components/sidebar.php'); ?>
    <!-- End Sidebar -->
    <main class="bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen w-screen sc-hide scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-200 p-6">
      <div class="flex items-start justify-beetween mb-6 flex-row">
        <h1 class="text-3xl text-gray-800 font-semibold w-full">Teacher Details - <?php echo $teacher['fullname']; ?></h1>
        <a href="teachers/teachersList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <!-- Display class details -->
      <div class="bg-white shadow-md p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Teacher Details</h2>
        <!-- SELECT `id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `fullname`, `nisn`, `class_id`, `profile_url` FROM `users` WHERE 1 -->
        <p><strong>Full Name:</strong> <?php echo $teacher['fullname']; ?></p>
        <p><strong>Class:</strong> <?php echo $teacher['class_id']; ?></p>
        <p><strong>Username:</strong> <?php echo $teacher['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $teacher['email']; ?></p>
        <p><strong>Role:</strong> <?php echo $teacher['role']; ?></p>
        <p><strong>Profile URL:</strong> <?php echo $teacher['profile_url']; ?></p>
        <p><strong>Created At:</strong> <?php echo date('M j, Y H:i:s', strtotime($teacher['created_at'])); ?></p>
        <p><strong>Updated At:</strong> <?php echo date('M j, Y H:i:s', strtotime($teacher['updated_at'])); ?></p>
      </div>
      <!-- End Display class details -->
      <!-- Add more content related to class details if needed -->
    </main>
  </div>
  <!-- End Main Content -->

  <!-- Footer -->
  <?php include('../components/footer.php'); ?>
  <!-- End Footer -->
</div>
<!-- End HTML content for classesDetail.php -->

<?php
$stmt->close();
include_once('../components/footer.php');
?>