<?php
// Initialize the session
session_start();
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
                    <h1 class="text-3xl text-gray-800 font-semibol w-full">Classes Create</h1>
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
                    <form action="update_profile.php" method="POST" class="flex flex-col w-full space-x-2">
                        <!-- Class Name -->
                        <label for="class_name" class="block font-semibold text-gray-800 mt-2 mb-2">Class Name</label>
                        <input type="text" id="class_name" name="class_name" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border">
                        <!-- Error Class Name -->
                        <?php if (isset($errors['class_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_name']; ?>
                            </p>
                            <!-- End Error Class Name -->
                        <?php endif; ?>
                        <!-- Class Image -->
                        <label for="class_image" class="block font-semibold text-gray-800 mt-2 mb-2">Class Image</label>
                        <input type="file" id="class_image" name="class_image" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border">
                        <!-- Error Class Image -->
                        <?php if (isset($errors['class_image'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['class_image']; ?>
                            </p>
                            <!-- End Error Class Image -->
                        <?php endif; ?>

                        <!-- Description -->
                        <label for="description" class="block font-semibold text-gray-800 mt-2 mb-2">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 focus:outline-none px-2 py-2 border"></textarea>
                        <!-- Error Description -->
                        <?php if (isset($errors['description'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['description']; ?>
                            </p>
                            <!-- End Error Description -->
                        <?php endif; ?>
                        <!-- Create Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
                            Update Profile
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