<?php
// Include the connection file
require_once('../database/connection.php');

// Initialize variables
$username = $password = '';
$errors = array();

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

            // Redirect to a dashboard or homepage
            header('Location: ../dashboard.php');
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skripsi Aziz</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="/skripsi-aziz/dist/output.css">
    <link rel="stylesheet" href="/skripsi-aziz/node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
</head>

<body class="overflow-hidden">
    <!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
    <div class="h-screen flex flex-col">
        <!-- Top Navbar -->
        <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6 shadow-md sticky top-0">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <a href="/skripsi-aziz/public/index.php">
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
                    <a href="/skripsi-aziz/public/system/profile.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Account</a>
                </div>
            </div>
        </nav>
        <!-- End Top Navbar -->
        <!-- Main Content -->
        <div class="flex-grow bg-gray-50 flex flex-col shadow-md">
            <!-- Sidebar -->
            <aside class="bg-gray-800 text-white w-72 overflow-y-auto max-h-screen sc-hide">
                <div class="flex items-center justify-center p-6">
                    <span class="text-2xl font-semibold">Dashboard</span>
                </div>
                <ul class="text-gray-400">
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Profile</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Profile</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                    <!-- Add more sidebar items as needed -->
                </ul>
            </aside>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <main class="flex-grow bg-gray-50 flex flex-col">
                <!-- Your login form and other content here -->
            </main>
            <!-- End Main Content -->
        </div>
        <!-- End Main Content -->
        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-400 py-4 shadow-md mt-auto sticky bottom-0">
            <div class="container mx-auto text-center text-sm">
                <p>&copy; 2023 Your Company. All rights reserved.</p>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
    <!-- End Main Content -->
</body>

</html>