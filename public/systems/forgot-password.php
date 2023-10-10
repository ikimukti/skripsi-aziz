<?php
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$email = '';
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the user input
  $email = $_POST['email'];

  // Validate input
  if (empty($email)) {
    array_push($errors, 'Email is required');
  }

  // Check if the email exists in the database
  $query = "SELECT * FROM users WHERE email=? LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user) {
    // Reset the password to "12345678"
    $new_password = hash('sha256', '12345678');
    $update_query = "UPDATE users SET password=? WHERE email=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ss', $new_password, $email);

    if ($update_stmt->execute()) {
      // Password reset successful
      $_SESSION['success'] = 'Password reset successful. Your new password is "12345678".';
      header('Location: ../systems/login.php');
      exit();
    } else {
      $errors['reset_failed'] = 'Failed to reset password.';
    }

    // Close the update statement
    $update_stmt->close();
  } else {
    array_push($errors, 'Email not found in the database');
  }

  // Close the statement
  $stmt->close();
}
?>
<?php include_once('../components/header.php'); ?>
<!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
<div class="h-screen flex flex-col">
  <!-- Top Navbar -->
  <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
      <a href="../index.php">
        <span class="font-semibold text-xl tracking-tight">Skripsi Aziz</span>
      </a>
    </div>
    <div class="block lg:hidden">
      <i class="fas fa-bars text-white"></i>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
      <div class="text-sm lg:flex-grow">
        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-gray-400 hover:text-white mr-4">
          Docs
        </a>
        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-gray-400 hover:text-white mr-4">
          Examples
        </a>
        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-gray-400 hover:text-white">
          Blog
        </a>
      </div>
      <div>
        <a href="../systems/login.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Login</a>
      </div>
    </div>
  </nav>
  <!-- End Top Navbar -->
  <!-- Main Content -->
  <main class="flex-grow bg-gray-50 flex flex-col">
    <!-- Forgot Password Form -->
    <div class="flex-grow bg-gray-50">
      <div class="flex justify-center items-center h-full">
        <div class="text-center px-40">
          <h1 class="text-6xl font-bold text-gray-700 mb-10">Forgot Password</h1>
          <?php if (isset($errors['reset_failed'])) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
              <strong class="font-bold">Password reset failed!</strong>
              <span class="block sm:inline"><?php echo $errors['reset_failed']; ?></span>
            </div>
          <?php endif; ?>
          <?php if (count($errors) > 0) {
            foreach ($errors as $error) : ?>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo $error; ?></span>
              </div>
          <?php endforeach;
          }
          ?>
          <form action="forgot-password.php" method="POST" class="mb-6">
            <label for="email" class="block text-left text-gray-600 mb-2">Email</label>
            <input type="email" id="email" name="email" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full">
              Reset Password
            </button>
          </form>
          <p class="text-gray-500 text-sm">Remember your password? <a href="../systems/login.php" class="text-blue-500">Click here to login</a></p>
        </div>
      </div>
    </div>
    <!-- End Forgot Password Form -->
  </main>
  <!-- End Main Content -->
  <!-- Footer -->
  <footer class="bg-gray-800 text-gray-400 py-4">
    <div class="container mx-auto text-center text-sm">
      <p>&copy; 2023 Your Company. All rights reserved.</p>
    </div>
  </footer>
  <!-- End Footer -->
</div>
<!-- End Main Content -->
</body>

</html>