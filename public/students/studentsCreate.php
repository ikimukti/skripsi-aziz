<?php
// Initialize the session
session_start();

require_once('../../database/connection.php');

// Initialize errors array
// SELECT `id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `fullname`, `nisn`, `class_id`, `profile_url` FROM `users` WHERE 1
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = hash('sha256', '12345678');
    $role = 'student';
    $fullname = $_POST['fullname'];
    $nisn = $_POST['nisn'];

    // Check for errors
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    } 
    else if (strlen($username) > 20) {
        $errors['username'] = "Username cannot be longer than 20 characters";
    }
    else if (strlen($username) < 5) {
        $errors['username'] = "Username cannot be shorter than 5 characters";
    }
    else {
        $query = "SELECT * FROM users WHERE username=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) { // if user exists
            $errors['username'] = 'Username already exists';
        }
    }
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email is not valid.";
    }
    else {
        $query = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) { // if email exists
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
    } else {
        $query = "SELECT * FROM users WHERE nisn=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $nisn);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) { // if nisn exists
            $errors['nisn'] = 'NISN already exists';
        }
    }

    $file_name = '';
    $file_size = '';
    $file_tmp = '';
    $file_type = '';
    $file_ext = '';

    // Check for image errors
    if (isset($_FILES['profile_url'])) {
        $file_name = $_FILES['profile_url']['name'];
        $file_size = $_FILES['profile_url']['size'];
        $file_tmp = $_FILES['profile_url']['tmp_name'];
        $file_type = $_FILES['profile_url']['type'];
        $file_parts = explode('.', $_FILES['profile_url']['name']);
        $file_ext = strtolower(end($file_parts));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors['profile_url'] = "Extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors['profile_url'] = 'File size must be exactly 2 MB';
        }
    } else {
        $errors['profile_url'] = "Class image is required.";
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO users (username, email, password, role, fullname, nisn, profile_url) VALUES ('$username', '$email', '$password', '$role', '$fullname', '$nisn', '$profile_url')";
        
        if ($conn->query($sql) === TRUE) {
            // Insertion successful
            $last_id = $conn->insert_id;
            $file_name = $last_id . '.' . $file_ext;
            $file_path = '../static/image/users/' . $file_name;
            $sql = "UPDATE users SET profile_url = '$file_name' WHERE id = '$last_id'";
            if ($conn->query($sql) === TRUE) {
                move_uploaded_file($file_tmp, $file_path);
                header('Location: studentsList.php' . '?status=success');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Insertion failed
            echo "Error: " . $sql . "<br>" . $conn->error;
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Create Student</h1>
                    <a href="../students/studentsList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
                        <input type="text" id="username" name="username" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Class Name">
                        <!-- Error Username-->
                        <?php if (isset($errors['username'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['username']; ?>
                            </p>
                            <!-- End Error Username-->
                        <?php endif; ?>

                        <!-- Email -->
                        <label for="email" class="block font-semibold text-gray-800 mt-2 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Email">
                        <!-- Error Email -->
                        <?php if (isset($errors['email'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['email']; ?>
                            </p>
                            <!-- End Error Email -->
                        <?php endif; ?>

                        <!-- Fullname -->
                        <label for="fullname" class="block font-semibold text-gray-800 mt-2 mb-2">Fullname <span class="text-red-500">*</span></label>
                        <input type="text" id="fullname" name="fullname" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Fullname">
                        <!-- Error Fullname -->
                        <?php if (isset($errors['fullname'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['fullname']; ?>
                            </p>
                            <!-- End Error Fullname -->
                        <?php endif; ?>

                        <!-- NISN -->
                        <label for="nisn" class="block font-semibold text-gray-800 mt-2 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="text" id="nisn" name="nisn" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="NISN" maxlength="10" minlength="10">
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
    </main>
</div>
<!-- Footer -->
<?php include('../components/footer.php'); ?>
<!-- End Footer -->
</div>
<!-- End Main Content -->
</body>

</html>