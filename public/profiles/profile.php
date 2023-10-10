<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $username = $_POST['username'];

    // Perform basic validation
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }

    // If no errors, proceed with updating profile
    if (empty($errors)) {
        // Prepare and execute a query to update user profile
        $user_id = $_SESSION['user_id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $nisn = $_POST['nisn'];
        $role = $_POST['role'];

        $update_query = "UPDATE users SET fullname = ?, email = ?, username = ?, nisn = ?, role = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('sssssi', $fullname, $email, $username, $nisn, $role, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['fullname'] = $fullname;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['nisn'] = $nisn;
            $_SESSION['role'] = $role;

            // Redirect to a dashboard or homepage
            // header('Location: ../systems/dashboard.php');
            exit();
        } else {
            $errors['update_failed'] = 'Failed to update profile.';
        }
    }
}

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
        <main class=" bg-gray-50 flex flex-col flex-1 overflow-y-auto">
            <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                <h1 class="text-3xl text-gray-800 font-semibold border-b border-gray-200 w-full">Profile</h1>
                <h2 class="text-xl text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
                <p class="text-gray-600">Profile information.</p>
                <!-- Form -->
                <div class="flex flex-row w-full space-x-2 space-y-2 mt-4 mb-4">
                    <!-- Image Profile -->
                    <div class="flex flex-col w-96 items-center justify-center pt-4">
                        <img src="../<?php echo $_SESSION['profile_url']; ?>" alt="Profile Image" class="rounded-md object-cover">
                        <!-- Form untuk mengunggah gambar profil baru -->
                        <form id="image-upload-form" action="upload_image.php" method="POST" enctype="multipart/form-data" class="w-full">
                            <input type="file" name="profile_image" accept="image/*">
                            <button type="button" onclick="confirmImageUpload()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 w-full">
                                Upload Image
                            </button>
                        </form>

                    </div>
                    <!-- End Image -->
                    <!-- Form Profile -->
                    <form action="profile.php" method="POST" class="flex flex-col w-full space-x-2 mt-4 mb-4" id="profile-update-form">
                        <!-- Full Name -->
                        <label for="fullname" class="block font-semibold text-gray-800 mt-2 mb-2">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $_SESSION['fullname']; ?>">
                        <!-- Error Full Name -->
                        <?php if (isset($errors['fullname'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['fullname']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Email -->
                        <label for="email" class="block font-semibold text-gray-800 mt-2 mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $_SESSION['email']; ?>">
                        <!-- Error Email -->
                        <?php if (isset($errors['email'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['email']; ?>
                            </p>
                        <?php endif; ?>


                        <!-- Username -->
                        <label for="username" class="block font-semibold text-gray-800 mt-2 mb-2">Username</label>
                        <input type="text" id="username" name="username" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $_SESSION['username']; ?>">
                        <!-- Error Username -->
                        <?php if (isset($errors['username'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['username']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- NISN -->
                        <label for="nisn" class="block font-semibold text-gray-800 mt-2 mb-2">NISN</label>
                        <input type="text" id="nisn" name="nisn" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $_SESSION['nisn']; ?>">
                        <!-- Error NISN -->
                        <?php if (isset($errors['nisn'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['nisn']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Role -->
                        <label for="role" class="block font-semibold text-gray-800 mt-2 mb-2">Role</label>
                        <input type="text" id="role" name="role" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $_SESSION['role']; ?>" readonly="readonly" required="required">
                        <!-- Error Role -->
                        <?php if (isset($errors['role'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['role']; ?>
                            </p>
                            <!-- End Error Role -->

                        <?php endif; ?>



                        <!-- Update Button -->
                        <button type="button" onclick="confirmProfileUpdate()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
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