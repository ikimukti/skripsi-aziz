<?php
// Initialize the session
session_start();

require_once('../../database/connection.php');

// Initialize errors array
$errors = array();
$subject = array();

// Process get data
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM subjects WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $subject = $result->fetch_assoc();
  if (!$subject) {
    // Redirect to an error page or suitable location
    header('Location: error.php');
    exit();
  }
} else {
  // Redirect to an error page or suitable location
  header('Location: error.php');
  exit();
}

// Process form submission update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input data
  $subject_name = $_POST['subject_name'];
  $subject_description = $_POST['subject_description'];
  $subject_code = $_POST['subject_code'];
  $subject_image = $subject['subject_image']; // Preserve the existing image unless updated

  // Check for errors
  if (empty($subject_name)) {
    $errors['subject_name'] = "Subject name is required.";
  } // Add additional validation for subject_name if needed.

  if (empty($subject_description)) {
    $errors['subject_description'] = "Subject description is required.";
  } // Add additional validation for subject_description if needed.

  if (empty($subject_code)) {
    $errors['subject_code'] = "Subject code is required.";
  } // Add additional validation for subject_code if needed.

  $file_name = '';
  $file_size = '';
  $file_tmp = '';
  $file_type = '';
  $file_ext = '';

  // Check for image errors
  if (isset($_FILES['subject_image']) && $_FILES['subject_image']['error'] === 0) {
    $file_name = $_FILES['subject_image']['name'];
    $file_size = $_FILES['subject_image']['size'];
    $file_tmp = $_FILES['subject_image']['tmp_name'];
    $file_type = $_FILES['subject_image']['type'];
    $file_parts = explode('.', $_FILES['subject_image']['name']);
    $file_ext = strtolower(end($file_parts));
    $time = time();
    $new_file_name = 'subject_' . hash('sha256', $time . $file_name) . '.' . $file_ext;

    $allowed_extensions = array("jpeg", "jpg", "png");
    $subject_image = 'static/image/subjects/' . $new_file_name;

    if (!in_array($file_ext, $allowed_extensions)) {
      $errors['subject_image'] = "Image extension not allowed. Please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
      $errors['subject_image'] = 'Image size must be exactly 2 MB';
    }
  }

  // If no errors, update data into the database
  if (empty($errors)) {
    // Prepare the UPDATE query
    $update_query = "UPDATE subjects SET subject_name=?, subject_description=?, subject_code=?, subject_image=? WHERE id=?";
    $stmt = $conn->prepare($update_query);

    // Bind the parameters
    $stmt->bind_param('ssssi', $subject_name, $subject_description, $subject_code, $subject_image, $id);

    // Execute the query
    if ($stmt->execute()) {
      // Upload image file if not default and not same with before
      if (!empty($_FILES['subject_image']['name']) && $subject_image != $subject['subject_image']) {
        move_uploaded_file($file_tmp, '' . $subject_image);
        unlink('' . $subject['subject_image']);
      }
      // Redirect to a success page or suitable location
      header('Location: subjectsList.php');
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
<?php include_once('../components/header.php'); ?>
<!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
<div class="h-screen flex flex-col">
  <!-- Top Navbar -->
  <?php include('../components/navbar.php'); ?>
  <!-- End Top Navbar -->
  <!-- Main Content -->
  <div class="flex-grow bg-gray-50 flex flex-row shadow-md">
    <!-- Sidebar -->
    <?php include('../components/sidebar.php'); ?>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <main class="bg-gray-50 text-white flex-1 overflow-y-scroll h-screen w-screen sc-hide">
      <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
        <!-- Header Content -->
        <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
          <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Subject</h1>
          <a href="subjectsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
              <p class="text-gray-600 text-sm">Subject information.</p>
            </div>
          </div>
          <!-- End Navigation -->
          <!-- Form Update -->
          <form action="" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
            <!-- Subject Name -->
            <label for="subject_name" class="block font-semibold text-gray-800 mt-2 mb-2">Subject Name<span class="text-red-500">*</span></label>
            <input type="text" id="subject_name" name="subject_name" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Subject Name" value="<?php echo $subject['subject_name']; ?>">
            <!-- Error Subject Name -->
            <?php if (isset($errors['subject_name'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_name']; ?>
              </p>
              <!-- End Error Subject Name -->
            <?php endif; ?>

            <!-- Subject Description -->
            <label for="subject_description" class="block font-semibold text-gray-800 mt-2 mb-2">Subject Description<span class="text-red-500">*</span></label>
            <textarea id="subject_description" name="subject_description" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Subject Description"><?php echo $subject['subject_description']; ?></textarea>
            <!-- Error Subject Description -->
            <?php if (isset($errors['subject_description'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_description']; ?>
              </p>
              <!-- End Error Subject Description -->
            <?php endif; ?>

            <!-- Subject Code -->
            <label for="subject_code" class="block font-semibold text-gray-800 mt-2 mb-2">Subject Code<span class="text-red-500">*</span></label>
            <input type="text" id="subject_code" name="subject_code" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Subject Code" value="<?php echo $subject['subject_code']; ?>">
            <!-- Error Subject Code -->
            <?php if (isset($errors['subject_code'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_code']; ?>
              </p>
              <!-- End Error Subject Code -->
            <?php endif; ?>

            <!-- Subject Image -->
            <label for="subject_image" class="block font-semibold text-gray-800 mt-2 mb-2">Subject Image</label>
            <input type="file" id="subject_image" name="subject_image" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Subject Image">
            <!-- Error Subject Image -->
            <?php if (isset($errors['subject_image'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_image']; ?>
              </p>
              <!-- End Error Subject Image -->
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
<?php include('../components/footer.php'); ?>
<!-- End Footer -->
</div>
<!-- End Main Content -->
</body>

</html>