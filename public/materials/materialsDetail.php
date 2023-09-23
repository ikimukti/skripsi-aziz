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

$query = "SELECT * FROM materials WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the material exists
if ($result->num_rows !== 1) {
  // Redirect to an error page or suitable location
  header('Location: ../error.php');
  exit();
}

// Fetch the material details
$material = $result->fetch_assoc();
?>

<!-- Start HTML content for materialsDetail.php -->
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
        <h1 class="text-3xl text-gray-800 font-semibold w-full">Material Details - <?php echo $material['title']; ?></h1>
        <a href="../materials/materialsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <!-- Display material details -->
      <div class="bg-white shadow-md p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Material Details</h2>
        <p><strong>Subject ID:</strong> <?php echo $material['subject_id']; ?></p>
        <p><strong>Title:</strong> <?php echo $material['title']; ?></p>
        <p><strong>Type:</strong> <?php echo $material['type']; ?></p>
        <p><strong>Content:</strong> <?php echo $material['content']; ?></p>
        <p><strong>Sequence:</strong> <?php echo $material['sequence']; ?></p>
        <p><strong>Created At:</strong> <?php echo date('M j, Y H:i:s', strtotime($material['created_at'])); ?></p>
        <p><strong>Updated At:</strong> <?php echo date('M j, Y H:i:s', strtotime($material['updated_at'])); ?></p>
      </div>
      <!-- End Display material details -->
      <!-- Add more content related to material details if needed -->
    </main>
  </div>
  <!-- End Main Content -->

  <!-- Footer -->
  <?php include('../components/footer.php'); ?>
  <!-- End Footer -->
</div>
<!-- End HTML content for materialsDetail.php -->

<?php
$stmt->close();
include_once('../components/footer.php');
?>