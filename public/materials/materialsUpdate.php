<?php
session_start();
require_once('database/connection.php');
include_once('components/header.php');

// Initialize errors array
$errors = array();
$material = array();
$subjects = array();

// Process get data
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $queryMaterial = "SELECT * FROM materials WHERE id = ?";
  $stmtMaterial = $conn->prepare($queryMaterial);
  $stmtMaterial->bind_param('i', $id);
  $stmtMaterial->execute();
  $resultMaterial = $stmtMaterial->get_result();
  $material = $resultMaterial->fetch_assoc();
  if (!$material) {
    // Redirect to an error page or suitable location
    header('Location: error.php');
    exit();
  }
} else {
  // Redirect to an error page or suitable location
  header('Location: error.php');
  exit();
}

// Fetch subjects from the database
$querySubjects = "SELECT id, subject_name FROM subjects";
$resultSubjects = $conn->query($querySubjects);

// Process form submission update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input data
  $subject_id = $_POST['subject_id'];
  $title = $_POST['title'];
  $type = $_POST['type'];
  $content = $_POST['content'];
  $sequence = $_POST['sequence'];

  // Check for errors
  if (empty($subject_id)) {
    $errors['subject_id'] = "Please select a subject.";
  }

  if (empty($title)) {
    $errors['title'] = "Title is required.";
  } // Add additional validation for title if needed.

  if (empty($type)) {
    $errors['type'] = "Type is required.";
  } // Add additional validation for type if needed.

  if (empty($content)) {
    $errors['content'] = "Content is required.";
  } // Add additional validation for content if needed.

  if (empty($sequence)) {
    $errors['sequence'] = "Sequence is required.";
  } elseif (!is_numeric($sequence)) {
    $errors['sequence'] = "Sequence must be a number.";
  }

  // If no errors, update data into the database
  if (empty($errors)) {
    // Prepare the UPDATE query
    $update_query = "UPDATE materials SET subject_id=?, title=?, type=?, content=?, sequence=? WHERE id=?";
    $stmt = $conn->prepare($update_query);

    // Bind the parameters
    $stmt->bind_param('issisi', $subject_id, $title, $type, $content, $sequence, $id);

    // Execute the query
    if ($stmt->execute()) {
      // Redirect to a success page or suitable location
      header('Location: materialsList.php');
      exit();
    } else {
      // Handle the update failure, perhaps show an error message
      $errors['update_error'] = "Failed to update data. Please try again.";
    }
  }
}

// Close database connection
$conn->close();
?>
<?php include_once('components/header.php'); ?>
<!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
<div class="h-screen flex flex-col">
  <!-- Top Navbar -->
  <?php include('components/navbar.php'); ?>
  <!-- End Top Navbar -->
  <!-- Main Content -->
  <div class="flex-grow bg-gray-50 flex flex-row shadow-md">
    <!-- Sidebar -->
    <?php include('components/sidebar.php'); ?>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <main class="bg-gray-50 text-white flex-1 overflow-y-scroll h-screen w-screen sc-hide">
      <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
        <!-- Header Content -->
        <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
          <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Material</h1>
          <a href="materialsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
          </a>
        </div>
        <!-- End Header Content -->
        <!-- Content -->
        <div class="flex flex-col w-full">
          <!-- Navigation -->
          <div class="flex flex-row justify-between items-center w-full pb-2">
            <div>
              <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
              <p class="text-gray-600 text-sm">Material information.</p>
            </div>
          </div>
          <!-- End Navigation -->
          <!-- Form Update -->
          <form action="" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
            <!-- Subject Dropdown -->
            <label for="subject_id" class="block font-semibold text-gray-800 mt-2 mb-2">Select Subject <span class="text-red-500">*</span></label>
            <select id="subject_id" name="subject_id" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600">
              <option value="" selected disabled>Select a subject</option>
              <?php
              while ($rowSubject = $resultSubjects->fetch_assoc()) {
                $subjectId = $rowSubject['id'];
                $subjectName = $rowSubject['subject_name'];
                $selected = ($subjectId == $material['subject_id']) ? 'selected' : '';
                echo "<option value='$subjectId' $selected>$subjectName</option>";
              }
              ?>
            </select>
            <!-- Error Subject ID -->
            <?php if (isset($errors['subject_id'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_id']; ?>
              </p>
            <?php endif; ?>

            <!-- Title -->
            <label for="title" class="block font-semibold text-gray-800 mt-2 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Title" value="<?php echo $material['title']; ?>">
            <!-- Error Title -->
            <?php if (isset($errors['title'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['title']; ?>
              </p>
            <?php endif; ?>

            <!-- Type -->
            <label for="type" class="block font-semibold text-gray-800 mt-2 mb-2">Type <span class="text-red-500">*</span></label>
            <input type="text" id="type" name="type" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Type" value="<?php echo $material['type']; ?>">
            <!-- Error Type -->
            <?php if (isset($errors['type'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['type']; ?>
              </p>
            <?php endif; ?>

            <!-- Content -->
            <label for="content" class="block font-semibold text-gray-800 mt-2 mb-2">Content <span class="text-red-500">*</span></label>
            <textarea id="content" name="content" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Content"><?php echo $material['content']; ?></textarea>
            <!-- Error Content -->
            <?php if (isset($errors['content'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['content']; ?>
              </p>
            <?php endif; ?>

            <!-- Sequence -->
            <label for="sequence" class="block font-semibold text-gray-800 mt-2 mb-2">Sequence <span class="text-red-500">*</span></label>
            <input type="text" id="sequence" name="sequence" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Sequence" value="<?php echo $material['sequence']; ?>">
            <!-- Error Sequence -->
            <?php if (isset($errors['sequence'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['sequence']; ?>
              </p>
            <?php endif; ?>

            <!-- Update Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
              <i class="fas fa-save mr-2"></i>
              <span>Update</span>
            </button>
          </form>
          <!-- End Form Update -->
        </div>
        <!-- End Content -->
      </div>
      <hr class=" w-full h-40 mt-40">
    </main>
    <!-- End Main Content -->
  </div>
  <!-- End Main Content -->
</div>
<!-- Footer -->
<?php include('components/footer.php'); ?>
<!-- End Footer -->
</div>
<!-- End Main Content -->
</body>

</html>