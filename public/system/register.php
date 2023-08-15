<?php
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$username = $password = '';
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    // Validate inputs
    if (empty($username) || empty($password) || empty($email) || empty($fullname)) {
        array_push($errors, 'Username, email, password, and fullname are required');
    }

    if (strlen($username) > 20) {
        array_push($errors, 'Username cannot be longer than 20 characters');
    }

    if (strlen($password) < 8) {
        array_push($errors, 'Password must be at least 8 characters long');
    }

    if ($password !== $confirm_password) {
        array_push($errors, 'Password confirmation does not match');
    }
    
    // Hash the password for storage
    $hashed_password = hash('sha256', $password);
    
    // Set default values
    $default_role = 'user';
    $default_nisn = 'dafault'; // Change this to the actual default NISN value

    // Check if the username already exists
    $query = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) { // if user exists
        array_push($errors, 'Username already exists');
    }

    // Check if the email already exists
    $query = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); 

    if ($user) { // if email exists
        array_push($errors, 'Email already exists');
    }

    // If there are no errors, proceed with registration
    if (count($errors) === 0) {
        // Prepare and execute a query to insert new user record
        $query = "INSERT INTO users (username, email, password, role, fullname, nisn) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $username, $email, $hashed_password, $default_role, $fullname, $default_nisn);
        
        if ($stmt->execute()) {
            // Registration successful, you can redirect the user to the login page

            // Add session success message
            $_SESSION['success'] = 'Registration successful.';
            header('Location: ../system/login.php');
            exit();
        } else {
            $errors['registration_failed'] = 'Failed to register user.';
        }

        // Close the statement
        $stmt->close();
    }

    // If there are errors, proceed with the error handling
    if (count($errors) > 0) {
        $stmt->close();
    }
}
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

<body>
    <!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
    <div class="h-screen flex flex-col">
        <!-- Top Navbar -->
        <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
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
                    <a href="/skripsi-aziz/public/system/login.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Login</a>
                </div>
            </div>
        </nav>
        <!-- End Top Navbar -->
        <!-- Main Content -->
        <main class="flex-grow bg-gray-50 flex flex-col">
            <!-- Registration Form -->
            <div class="flex-grow bg-gray-50">
                <div class="flex justify-center items-center h-full">
                    <div class="text-center px-40">
                        <h1 class="text-6xl font-bold text-gray-700 mb-10">Register</h1>
                        <?php if (isset($errors['registration_failed'])) : ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                <strong class="font-bold">Registration failed!</strong>
                                <span class="block sm:inline"><?php echo $errors['registration_failed']; ?></span>
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
                        <form action="../system/register.php" method="POST" class="mb-6">
                            <label for="username" class="block text-left text-gray-600 mb-2">Username</label>
                            <input type="text" id="username" name="username" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="fullname" class="block text-left text-gray-600 mb-2">Fullname</label>
                            <input type="text" id="fullname" name="fullname" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="email" class="block text-left text-gray-600 mb-2">Email</label>
                            <input type="email" id="email" name="email" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="password" class="block text-left text-gray-600 mb-2">Password</label>
                            <input type="password" id="password" name="password" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="confirm_password" class="block text-left text-gray-600 mb-2">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-6" required>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full">
                                Register
                            </button>
                        </form>
                        <p class="text-gray-500 text-sm">Already have an account? <a href="../system/login.php" class="text-blue-500">Click here to login</a></p>
                    </div>
                </div>
            </div>
            <!-- End Registration Form -->
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