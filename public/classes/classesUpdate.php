<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$class_name = $class_image = $description = '';
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $class_name = $_POST['class_name'];
    $class_image = $_FILES['class_image']['name'];
    $description = $_POST['description'];

    // Perform basic validation
    if (empty($class_name)) {
        $errors['class_name'] = 'Class Name is required.';
    }
    // Add more validation rules if needed

    // If no errors, proceed with update
    if (empty($errors)) {
        // Perform update logic and database operations here
        // ...

        // Redirect to a suitable page after update
        header('Location: classesList.php');
        exit();
    }
}

// Fetch existing class data from the database (you will need to implement this)
// ...

// Fetched class data can be used to populate form fields
?>

<!-- Start HTML content for classesUpdate.php -->
<div class="h-screen flex flex-col">
    <!-- Top Navbar -->
    <?php include('../components/navbar.php'); ?>
    <!-- End Top Navbar -->

    <!-- Main Content -->
    <main class="bg-gray-50 text-white flex-1 overflow-y-scroll h-screen w-screen sc-hide">
        <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
            <!-- Header Content -->
            <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
                <h1 class="text-3xl text-gray-800 font-semibol w-full">Update Class</h1>
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
                <form action="classesUpdate.php" method="POST" class="flex flex-col w-full space-x-2">
                    <!-- Class Name -->
                    <label for="class_name" class="block font-semibold text-gray-800 mt-2 mb-2">Class Name</label>
                    <input type="text" id="class_name" name="class_name" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border" value="<?php echo $class_name; ?>">
                    <!-- Error Class Name -->
                    <?php if (isset($errors['class_name'])) : ?>
                        <p class="text-red-500 text-sm">
                            <?php echo $errors['class_name']; ?>
                        </p>
                        <!-- End Error Class Name -->
                    <?php endif; ?>

                    <!-- Class Image -->
                    <!-- Similar to the create form -->
                    <!-- ...

                    <!-- Description -->
                    <!-- Similar to the create form -->
                    <!-- ...

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
<!-- End HTML content for classesUpdate.php -->

<?php include('../components/footer.php'); ?>
