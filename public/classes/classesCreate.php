<?php
// Initialize the session
session_start();

require_once('../../database/connection.php');

// Initialize errors array
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $class_name = $_POST['class_name'];
    $description = $_POST['description'];

    // Check for errors
    if (empty($class_name)) {
        $errors['class_name'] = "Class name is required.";
    }

    if (empty($description)) {
        $errors['description'] = "Description is required.";
    }

    $file_name = '';
    $file_size = '';
    $file_tmp = '';
    $file_type = '';
    $file_ext = '';

    // Check for image errors
    if (isset($_FILES['class_image'])) {
        $file_name = $_FILES['class_image']['name'];
        $file_size = $_FILES['class_image']['size'];
        $file_tmp = $_FILES['class_image']['tmp_name'];
        $file_type = $_FILES['class_image']['type'];
        $file_parts = explode('.', $_FILES['class_image']['name']);
        $file_ext = strtolower(end($file_parts));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors['class_image'] = "Extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors['class_image'] = 'File size must be exactly 2 MB';
        }
    } else {
        $errors['class_image'] = "Class image is required.";
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO classes (classes_name, description) VALUES ('$class_name', '$description')";
        
        if ($conn->query($sql) === TRUE) {
            // Insertion successful
            $last_id = $conn->insert_id;
            $file_name = $last_id . '.' . $file_ext;
            $file_path = '../static/image/class/' . $file_name;
            $sql = "UPDATE classes SET classes_image = '$file_name' WHERE id = '$last_id'";
            if ($conn->query($sql) === TRUE) {
                move_uploaded_file($file_tmp, $file_path);
                header('Location: classesList.php' . '?status=success');
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Create Class</h1>
                    <a href="../classes/classesList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
                            <p class="text-gray-600 text-sm">Class information.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Form Create -->
                    <form action="" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
                        <!-- Class Name -->
                        <label for="class_name" class="block font-semibold text-gray-800 mt-2 mb-2">Class Name <span class="text-red-500">*</span></label>
                        <input type="text" id="class_name" name="class_name" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Class Name">
                        <!-- Error Class Name -->
                        <?php if (isset($errors['class_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_name']; ?>
                            </p>
                            <!-- End Error Class Name -->
                        <?php endif; ?>
                        <!-- Class Image -->
                        <label for="class_image" class="block font-semibold text-gray-800 mt-2 mb-2">Class Image <span class="text-red-500">*</span></label>
                        <input type="file" id="class_image" name="class_image" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Class Image">
                        <!-- Error Class Image -->
                        <?php if (isset($errors['class_image'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_image']; ?>
                            </p>
                            <!-- End Error Class Image -->
                        <?php endif; ?>

                        <!-- Description -->
                        <label for="description" class="block font-semibold text-gray-800 mt-2 mb-2">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" cols="30" rows="3" class="w-full rounded-md border-gray-300  px-2 py-2 border text-gray-600" placeholder="Description"></textarea>
                        <!-- Error Description -->
                        <?php if (isset($errors['description'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['description']; ?>
                            </p>
                            <!-- End Error Description -->
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