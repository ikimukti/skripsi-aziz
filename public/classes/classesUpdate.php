<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$class_name = $class_image = $description = '';
$errors = array();


// Check if classesUpdate.php?id=1
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Get the user inputs
    $id = $_GET['id'];

    // Perform basic validation
    if (empty($id)) {
        $errors['id'] = 'ID is required';
    }
    // Add more validation rules if needed
    if (!is_numeric($id)) {
        $errors['id'] = 'ID must be a number';
    }


    // If no errors, proceed with update
    if (empty($errors)) {
        // Perform update logic and database operations here
        $sql = "SELECT * FROM classes WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch the class data
            $row = $result->fetch_assoc();
            $class_name = $row['classes_name'];
            $class_image = $row['image_url'];
            $description = $row['description'];
        } else {
            // Redirect to classes.php
            header('Location: classesList.php');
        }
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $id = $_POST['id'];
    $class_name = $_POST['class_name'];
    $description = $_POST['description'];

    // Perform basic validation
    if (empty($id)) {
        $errors['id'] = 'ID is required';
    }
    // Add more validation rules if needed
    if (!is_numeric($id)) {
        $errors['id'] = 'ID must be a number';
    }

    if (empty($class_name)) {
        $errors['class_name'] = 'Class name is required';
    }

    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }

    // If no errors, proceed with update
    if (empty($errors)) {
        // Perform update logic and database operations here
        $sql = "UPDATE classes SET classes_name = '$class_name', description = '$description' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            // Update successful
            header('Location: classesList.php');
        } else {
            $errors['db_error'] = $conn->error;
        }
    }
}

?>

<!-- Start HTML content for classesUpdate.php -->
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Class</h1>
                    <a href="classes/classesList.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
                            <p class="text-gray-600 text-sm">Update class information.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Form Update -->
                    <form action="classesUpdate.php" method="POST" class="flex flex-col w-full space-x-2" enctype="multipart/form-data">
                        <!-- ID Hidden -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <!-- Class Name -->
                        <label for="class_name" class="block font-semibold text-gray-800 mt-2 mb-2">Class Name</label>
                        <input type="text" id="class_name" name="class_name" class="w-full rounded-md border-gray-300 text-gray-800 px-2 py-2 border" value="<?php echo $class_name; ?>">
                        <!-- Error Class Name -->
                        <?php if (isset($errors['class_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_name']; ?>
                            </p>
                            <!-- End Error Class Name -->
                        <?php endif; ?>

                        <!-- Class Image -->
                        <label for="class_image" class="block font-semibold text-gray-800 mt-2 mb-2">Class Image</label>
                        <input type="file" id="class_image" name="class_image" class="w-full rounded-md border-gray-300 text-gray-800 px-2 py-2 border" value="<?php echo $class_image; ?>">
                        <!-- Error Class Image -->
                        <?php if (isset($errors['class_image'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_image']; ?>
                            </p>
                            <!-- End Error Class Image -->
                        <?php endif; ?>
                        <!-- Description -->
                        <label for="description" class="block font-semibold text-gray-800 mt-2 mb-2">Description</label>
                        <textarea id="description" name="description" rows="5" class="w-full rounded-md border-gray-300 text-gray-800 px-2 py-2 border"><?php echo $description; ?></textarea>
                        <!-- Error Description -->
                        <?php if (isset($errors['description'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['description']; ?>
                            </p>
                            <!-- End Error Description -->
                        <?php endif; ?>


                        <!-- Update Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
                            Update Class
                        </button>
                    </form>
                    <!-- End Form Update -->
                </div>
                <!-- End Content -->
            </div>
            <hr class="w-full h-40 mt-40">
        </main>
        <!-- End Main Content -->
    </div>
</div>
<!-- End HTML content for classesUpdate.php -->

<?php include('../components/footer.php'); ?>