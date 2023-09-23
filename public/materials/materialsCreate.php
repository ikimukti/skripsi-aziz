<?php
// Initialize the session
session_start();

require_once('../../database/connection.php');

// Initialize errors array
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input data
  $subject_id = $_POST['subject_id'];
  $title = $_POST['title'];
  $type = $_POST['type'];
  $content = $_POST['content'];
  $sequence = $_POST['sequence'];

  // Validate Sequence
  $sequence = $_POST['sequence'];

  if (empty($sequence)) {
    $errors['sequence'] = "Sequence is required.";
  } elseif (!is_numeric($sequence)) {
    $errors['sequence'] = "Sequence must be a number.";
  } else {
    // Check if the sequence already exists in the database
    $queryCheckSequence = "SELECT id FROM materials WHERE sequence = ?";
    $stmtCheckSequence = $conn->prepare($queryCheckSequence);
    $stmtCheckSequence->bind_param('i', $sequence);
    $stmtCheckSequence->execute();
    $resultCheckSequence = $stmtCheckSequence->get_result();

    if (
      $resultCheckSequence->num_rows > 0
    ) {
      $errors['sequence'] = "Sequence already exists.";
    }

    $stmtCheckSequence->close();
  }


  // Check for errors
  if (empty($subject_id)) {
    $errors['subject_id'] = "Please select a subject.";
  }

  if (empty($title)) {
    $errors['title'] = "Title is required.";
  }

  if (empty($type)) {
    $errors['type'] = "Type is required.";
  }

  if (empty($content)) {
    $errors['content'] = "Content is required.";
  }

  if (empty($sequence)) {
    $errors['sequence'] = "Sequence is required.";
  }

  // If no errors, insert data into the database
  if (empty($errors)) {
    // Insert data into the materials table
    $sql = "INSERT INTO materials (subject_id, title, type, content, sequence) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssi', $subject_id, $title, $type, $content, $sequence);

    if ($stmt->execute()) {
      // Redirect to materialsList page or any other destination
      header('location: materialsList.php');
    } else {
      // Insertion failed
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Fetch subjects from the database
$querySubjects = "SELECT id, subject_name FROM subjects";
$resultSubjects = $conn->query($querySubjects);

// Close the database connection
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
          <h1 class="text-3xl text-gray-800 font-semibold w-full">Create Material</h1>
          <a href="../materials/materialsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
          <!-- Form Create -->
          <form action="" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
            <!-- Subject Dropdown -->
            <label for="subject_id" class="block font-semibold text-gray-800 mt-2 mb-2">Select Subject <span class="text-red-500">*</span></label>
            <select id="subject_id" name="subject_id" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600">
              <option value="" disabled>Select a subject</option>
              <?php
              while ($rowSubject = $resultSubjects->fetch_assoc()) {
                $subjectId = $rowSubject['id'];
                $subjectName = $rowSubject['subject_name'];
                $selected = ($_POST['subject_id'] == $subjectId) ? 'selected' : ''; // Check if the option should be selected
                echo "<option value='$subjectId' $selected>$subjectName</option>";
              }
              ?>
            </select>
            <!-- Error Subject -->
            <?php if (isset($errors['subject_id'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['subject_id']; ?>
              </p>
            <?php endif; ?>


            <!-- Title -->
            <label for="title" class="block font-semibold text-gray-800 mt-2 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">
            <!-- Error Title -->
            <?php if (isset($errors['title'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['title']; ?>
              </p>
            <?php endif; ?>

            <!-- Type -->
            <label for="type" class="block font-semibold text-gray-800 mt-2 mb-2">Type <span class="text-red-500">*</span></label>
            <input type="text" id="type" name="type" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Type" value="<?php echo isset($_POST['type']) ? $_POST['type'] : ''; ?>">
            <!-- Error Type -->
            <?php if (isset($errors['type'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['type']; ?>
              </p>
            <?php endif; ?>

            <!-- Content -->
            <label for="content" class="block font-semibold text-gray-800 mt-2 mb-2">Content <span class="text-red-500">*</span></label>
            <textarea id="content" name="content" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Content"><?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?></textarea>
            <!-- Error Content -->
            <?php if (isset($errors['content'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['content']; ?>
              </p>
            <?php endif; ?>

            <!-- Sequence -->
            <label for="sequence" class="block font-semibold text-gray-800 mt-2 mb-2">Sequence <span class="text-red-500">*</span></label>
            <input type="text" id="sequence" name="sequence" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Sequence" value="<?php echo isset($_POST['sequence']) ? $_POST['sequence'] : ''; ?>">
            <!-- Error Sequence -->
            <?php if (isset($errors['sequence'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['sequence']; ?>
              </p>
            <?php endif; ?>

            <!-- Create Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
              <i class="fas fa-plus mr-2"></i>
              <span>Create</span>
            </button>
          </form>
          <!-- End Form Create -->
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