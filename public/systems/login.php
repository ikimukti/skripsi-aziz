<?php
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$username = $password = '';
$errors = array();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // If user is already logged in, redirect to dashboard
    header('Location: ../systems/dashboard.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform basic validation
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        // Hash the password for comparison
        $hashed_password = hash('sha256', $password);

        // Prepare and execute a query to check user credentials
        $query = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            // Perform login actions (e.g., set sessions, redirect, etc.)

            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['fullname'] = $row['fullname'];
            if ($row['nisn'] != null) {
                $_SESSION['nisn'] = $row['nisn'];
            } else {
                $_SESSION['nisn'] = null;
            }

            // Redirect to a dashboard or homepage
            header('Location: ../systems/dashboard.php');
            exit();
        } else {
            $errors['login_failed'] = 'Invalid username or password.';
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
<?php include_once('../components/header.php'); ?>
<!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
<div class="h-screen flex flex-col">
    <!-- Top Navbar -->
    <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <a href="/public/index.php">
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
                <a href="/public/systems/register.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Register</a>
            </div>
        </div>
    </nav>
    <!-- End Top Navbar -->
    <!-- Main Content -->
    <main class="flex-grow bg-gray-50 flex flex-col">
        <!-- Login Form -->
        <div class="flex-grow bg-gray-50">
            <div class="flex justify-center items-center h-full">
                <div class="text-center px-40">
                    <h1 class="text-6xl font-bold text-gray-700 mb-10">Login</h1>
                    <?php if (isset($errors['login_failed'])) : ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Login failed!</strong>
                            <span class="block sm:inline"><?php echo $errors['login_failed']; ?></span>
                        </div>
                    <?php endif; ?>
                    <!-- success -->
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                        </div>
                    <?php endif; ?>
                    <form action="login.php" method="POST" class="mb-6">
                        <label for="username" class="block text-left text-gray-600 mb-2">Username</label>
                        <input type="text" id="username" name="username" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>
                        <?php if (isset($errors['username'])) : ?>
                            <span class="text-red-500 text-sm"><?php echo $errors['username']; ?></span>
                        <?php endif; ?>
                        <label for="password" class="block text-left text-gray-600 mb-2">Password</label>
                        <input type="password" id="password" name="password" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-6" required>
                        <?php if (isset($errors['password'])) : ?>
                            <span class="text-red-500 text-sm"><?php echo $errors['password']; ?></span>
                        <?php endif; ?>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full">
                            Log In
                        </button>
                    </form>
                    <p class="text-gray-500 text-sm">Forgot your password? <a href="../systems/forgot-password.php" class="text-blue-500">Click here</a></p>
                    <p class="text-gray-500 text-sm">Don't have an account? <a href="../systems/register.php" class="text-blue-500">Register here</a></p>
                </div>
            </div>
        </div>
        <!-- End Login Form -->

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