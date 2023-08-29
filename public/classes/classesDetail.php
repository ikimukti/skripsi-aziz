<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Check if the ID is provided in the query parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to an error page or suitable location
    header('Location: ../error.php');
    exit();
}

$id = $_GET['id'];

// Fetch class data from the database based on the provided ID
$query = "SELECT * FROM classes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the class exists
if ($result->num_rows !== 1) {
    // Redirect to an error page or suitable location
    header('Location: ../error.php');
    exit();
}

// Fetch the class details
$class = $result->fetch_assoc();
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
              <h1 class="text-3xl text-gray-800 font-semibold w-full"><?php echo $class['classes_name']; ?> Details</h1>
              <a href="../classes/classesList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
              </a>
          </div>
          <!-- Display class details -->
          <div class="bg-white shadow-md p-6 rounded-lg">
              <h2 class="text-xl font-semibold mb-4">Class Information</h2>
              <p><strong>Class Name:</strong> <?php echo $class['classes_name']; ?></p>
              <p><strong>Description:</strong> <?php echo $class['description']; ?></p>
              <p><strong>Created At:</strong> <?php echo date('M j, Y H:i:s', strtotime($class['created_at'])); ?></p>
              <p><strong>Updated At:</strong> <?php echo date('M j, Y H:i:s', strtotime($class['updated_at'])); ?></p>
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
