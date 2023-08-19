<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

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
    <title>Skripsi Aziz - Profile</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="/skripsi-aziz/dist/output.css">
    <link rel="stylesheet" href="/skripsi-aziz/node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
</head>

<body class="overflow-hidden">
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
            <main class=" bg-gray-50 flex flex-col flex-1 overflow-y-auto max-h-screen sc-hide">
                <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                    <h1 class="text-3xl text-gray-800 font-semibold border-b border-gray-200 w-full">Profile</h1>
                    <h2 class="text-xl text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
                    <p class="text-gray-600">Profile information.</p>
                    <!-- Form -->
                    <div class="flex flex-row w-full space-x-2 mt-4 mb-4">
                        <!-- Image Profile -->
                        <div class="flex flex-col w-96 h-96 items-center justify-center">
                            <img src="/skripsi-aziz/dist/images/aziz.jpg" alt="Aziz" class="rounded-full w-64 h-64">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                                Change Image
                            </button>
                        </div>
                        <!-- End Image -->
                        <!-- Form Profile -->
                        <form action="update_profile.php" method="POST" class="flex flex-col w-full space-x-2 mt-4 mb-4">
                            <!-- Full Name -->
                            <label for="fullname" class="block font-semibold text-gray-800 mt-2">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['fullname']; ?>" required>
                            <!-- Full Name -->
                            <label for="fullname" class="block font-semibold text-gray-800 mt-2">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['fullname']; ?>" required><!-- Full Name -->
                            <label for="fullname" class="block font-semibold text-gray-800 mt-2">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['fullname']; ?>" required><!-- Full Name -->
                            <label for="fullname" class="block font-semibold text-gray-800 mt-2">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['fullname']; ?>" required><!-- Full Name -->
                            <label for="fullname" class="block font-semibold text-gray-800 mt-2">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['fullname']; ?>" required>

                            <!-- NISN -->
                            <label for="nisn" class="block font-semibold text-gray-800 mt-2">NISN:</label>
                            <input type="text" id="nisn" name="nisn" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['nisn']; ?>" required>

                            <!-- Class ID -->
                            <label for="class_id" class="block font-semibold text-gray-800 mt-2">Class ID:</label>
                            <input type="text" id="class_id" name="class_id" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['class_id']; ?>" required>

                            <!-- Profile URL -->
                            <label for="profile_url" class="block font-semibold text-gray-800 mt-2">Profile URL:</label>
                            <input type="text" id="profile_url" name="profile_url" class="w-full rounded-md border-gray-300 p-2" value="<?php echo $_SESSION['profile_url']; ?>" required>

                            <!-- Update Button -->
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
                                Update Profile
                            </button>
                        </form>
                        <!--  End Form Profile -->
                    </div>
                </div>
            </main>
            <!-- End Main Content -->
        </div>
        <!-- End Main Content -->
        <!-- Footer -->
        <?php include('../components/footer.php'); ?>
        <!-- End Footer -->
    </div>
    <!-- End Main Content -->
</body>

</html>