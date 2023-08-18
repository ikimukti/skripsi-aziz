<?php
// Initialize the session
session_start();
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
                    <a href="/skripsi-aziz/public/system/logout.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Logout</a>
                </div>
            </div>
        </nav>
        <!-- End Top Navbar -->
        <!-- Main Content -->
        <div class="flex-grow bg-gray-50 flex flex-row shadow-md">
            <!-- Sidebar -->
            <aside class="bg-gray-800 text-white w-64 overflow-y-auto max-h-screen sc-hide">
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
                        <a href="#">Classes</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Students</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Teachers</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Subjects</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Materials</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Tests</a>
                    </li>
                    <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer">
                        <a href="#">Settings</a>
                    </li>
                </ul>
            </aside>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <main class=" bg-gray-50 flex flex-col flex-1">
                <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                    <h1 class="text-3xl text-gray-800 font-semibold border-b border-gray-200 w-full">Dashboard</h1>
                    <h2 class="text-xl text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
                    <p class="text-gray-600">Here's what's happening with your projects today.</p>
                    <!-- Grafik -->
                    <div class="flex flex-row flex-wrap w-full space-x-2 mt-4 mb-4">
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-green-600"><i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">Total Revenue</h5>
                                        <h3 class="font-bold text-3xl">$3249 <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-orange-600"><i class="fas fa-users fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">Total Users</h5>
                                        <h3 class="font-bold text-3xl">249 <span class="text-orange-500"><i class="fas fa-exchange-alt"></i></span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">New Users</h5>
                                        <h3 class="font-bold text-3xl">2 <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row flex-wrap w-full space-x-2">
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-blue-600"><i class="fas fa-server fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">Server Uptime</h5>
                                        <h3 class="font-bold text-3xl">152 days</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-indigo-600"><i class="fas fa-tasks fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">To Do List</h5>
                                        <h3 class="font-bold text-3xl">7 tasks</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-1">
                            <div class="bg-white border rounded shadow p-2 w-full">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded p-3 bg-red-600"><i class="fas fa-inbox fa-2x fa-fw fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h5 class="font-bold uppercase text-gray-500">Issues</h5>
                                        <h3 class="font-bold text-3xl">3 <span class="text-red-500"><i class="fas fa-caret-up"></i></span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- End Main Content -->
        </div>
        <!-- End Main Content -->
        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-400 py-4 shadow-md mt-auto sticky bottom-0 border-t border-gray-700">
            <div class="container mx-auto text-center text-sm">
                <p>&copy; 2023 Your Company. All rights reserved.</p>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
    <!-- End Main Content -->
</body>

</html>