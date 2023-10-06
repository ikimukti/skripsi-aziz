<?php
// Initialize the session
session_start();

require_once('database/connection.php');

// Initialize errors array
// SELECT `id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `fullname`, `nisn`, `class_id`, `profile_url` FROM `users` WHERE 1
$errors = array();
$user = array();
// Process get data
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM users WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  if (!$user) {
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
  $username = $_POST['username'];
  $email = $_POST['email'];
  $role = 'student';
  $fullname = $_POST['fullname'];
  $nisn = $_POST['nisn'];
  $profile_url = 'static/image/profile/default.png';

  // Check for errors
  if (empty($username)) {
    $errors['username'] = "Username is required.";
  } else if (strlen($username) > 20) {
    $errors['username'] = "Username cannot be longer than 20 characters";
  } else if (strlen($username) < 5) {
    $errors['username'] = "Username cannot be shorter than 5 characters";
  }
  // check if username same with username before
  else if ($username != $user['username']) {
    $query = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $suser = $result->fetch_assoc();
    if ($suser) { // if username exists
      $errors['username'] = 'Username already exists';
    }
  }
  if (empty($email)) {
    $errors['email'] = "Email is required.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Email is not valid.";
  }  // check if email same with email before
  else if ($email != $user['email']) {
    $query = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $suser = $result->fetch_assoc();
    if ($suser) { // if email exists
      $errors['email'] = 'Email already exists';
    }
  }
  if (empty($fullname)) {
    $errors['fullname'] = "Fullname is required.";
  }
  if (empty($nisn)) {
    $errors['nisn'] = "NISN is required.";
  } else if (strlen($nisn) > 10) {
    $errors['nisn'] = "NISN cannot be longer than 10 characters";
  } else if (strlen($nisn) < 10) {
    $errors['nisn'] = "NISN cannot be shorter than 10 characters";
  }
  // check if nisn same with nisn before
  else if ($nisn != $user['nisn']) {
    $query = "SELECT * FROM users WHERE nisn=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $nisn);
    $stmt->execute();
    $result = $stmt->get_result();
    $suser = $result->fetch_assoc();
    if ($suser) { // if nisn exists
      $errors['nisn'] = 'NISN already exists';
    }
  }

  $file_name = '';
  $file_size = '';
  $file_tmp = '';
  $file_type = '';
  $file_ext = '';

  // Check for image errors
  if (isset($_FILES['profile_url']) && $_FILES['profile_url']['error'] === 0) {
    $file_name = $_FILES['profile_url']['name'];
    $file_size = $_FILES['profile_url']['size'];
    $file_tmp = $_FILES['profile_url']['tmp_name'];
    $file_type = $_FILES['profile_url']['type'];
    $file_parts = explode('.', $_FILES['profile_url']['name']);
    $file_ext = strtolower(end($file_parts));
    $time = time();
    $new_file_name = 'student_' . hash('sha256', $time . $file_name) . '.' . $file_ext;

    $extensions = array("jpeg", "jpg", "png");
    $profile_url = 'static/image/profile/' . $new_file_name;


    if (in_array($file_ext, $extensions) === false) {
      $errors['profile_url'] = "Extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
      $errors['profile_url'] = 'File size must be exactly 2 MB';
    }
  }
  // if no image uploaded and in database has image
  else if (empty($_FILES['profile_url']['name']) && !empty($user['profile_url'])) {
    $file_name = $user['profile_url'];
    $file_size = '';
    $file_tmp = '';
    $file_type = '';
    $file_ext = '';
  }

  // If no errors, update data into the database
  if (empty($errors)) {
    // You should perform the database update here

    // Prepare the UPDATE query
    $update_query = "UPDATE users SET username=?, email=?, role=?, fullname=?, nisn=?, profile_url=? WHERE id=?";
    $stmt = $conn->prepare($update_query);

    // Bind the parameters
    $stmt->bind_param('ssssssi', $username, $email, $role, $fullname, $nisn, $profile_url, $id);

    // Execute the query
    if ($stmt->execute()) {
      // Upload image file if not default and not same with before
      if (!empty($_FILES['profile_url']['name']) && $file_name != $user['profile_url']) {
        move_uploaded_file($file_tmp, '' . $profile_url);
        unlink('' . $user['profile_url']);
      }
      // Redirect to a success page or suitable location
      header('Location: students/studentsList.php');
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
          <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Student</h1>
          <a href="students/studentsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
              <p class="text-gray-600 text-sm">Student information.</p>
            </div>
          </div>
          <!-- End Navigation -->
          <!-- Form Create -->
          <form action="" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
            <!-- Username -->
            <label for="username" class="block font-semibold text-gray-800 mt-2 mb-2">Username<span class="text-red-500">*</span></label>
            <input type="text" id="username" name="username" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Class Name" maxlength="20" minlength="5" value="<?php echo $user['username']; ?>">
            <!-- Error Username-->
            <?php if (isset($errors['username'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['username']; ?>
              </p>
              <!-- End Error Username-->
            <?php endif; ?>

            <!-- Email -->
            <label for="email" class="block font-semibold text-gray-800 mt-2 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Email" value="<?php echo $user['email']; ?>">
            <!-- Error Email -->
            <?php if (isset($errors['email'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['email']; ?>
              </p>
              <!-- End Error Email -->
            <?php endif; ?>

            <!-- Fullname -->
            <label for="fullname" class="block font-semibold text-gray-800 mt-2 mb-2">Fullname <span class="text-red-500">*</span></label>
            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Fullname" value="<?php echo $user['fullname']; ?>">
            <!-- Error Fullname -->
            <?php if (isset($errors['fullname'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['fullname']; ?>
              </p>
              <!-- End Error Fullname -->
            <?php endif; ?>

            <!-- NISN -->
            <label for="nisn" class="block font-semibold text-gray-800 mt-2 mb-2">NISN <span class="text-red-500">*</span></label>
            <input type="text" id="nisn" name="nisn" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="NISN" maxlength="10" minlength="10" value="<?php echo $user['nisn']; ?>">
            <!-- Error NISN -->
            <?php if (isset($errors['nisn'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['nisn']; ?>
              </p>
              <!-- End Error NISN -->
            <?php else : ?>
              <p class="text-gray-500 text-sm">
                NISN must be exactly 10 characters
              </p>
            <?php endif; ?>

            <!-- Profile URL -->
            <label for="profile_url" class="block font-semibold text-gray-800 mt-2 mb-2">Profile URL <span class="text-red-500">*</span></label>
            <input type="file" id="profile_url" name="profile_url" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Profile URL">
            <!-- Error Profile URL -->
            <?php if (isset($errors['profile_url'])) : ?>
              <p class="text-red-500 text-sm">
                <?php echo $errors['profile_url']; ?>
              </p>
              <!-- End Error Profile URL -->
            <?php endif; ?>
            <!-- Update Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
              <i class="fas fa-plus mr-2"></i>
              <span>Update</span>
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
  </main>
</div>
<!-- Footer -->
<?php include('components/footer.php'); ?>
<!-- End Footer -->
</div>
<!-- End Main Content -->
</body>

</html>