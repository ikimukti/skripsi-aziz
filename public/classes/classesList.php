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
                <!-- Header Content -->
                <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
                    <h1 class="text-3xl text-gray-800 font-semibol w-full">Classes</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="../classes/classesCreate.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Create</span>
                        </a>
                    </div>
                </div>
                <!-- End Header Content -->
                <!-- Content -->
                <div class="flex flex-col w-full">
                    <!-- Navigation -->
                    <div class="flex flex-row justify-between items-center w-full mb-2 pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Class information.</p>
                        </div>
                        <!-- Search -->
                        <form class="flex items-center justify-end space-x-2 w-96">
                            <input type="text" name="search" class="bg-gray-200 focus:bg-white focus:outline-none border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" placeholder="Search">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded space-x-2 inline-flex items-center">
                                <i class="fas fa-search"></i>
                                <span>Search</span>
                            </button>
                        </form>
                        <!-- End Search -->
                    </div>
                    <!-- End Navigation -->
                    <!-- Table -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left py-2">No</th>
                                <th class="text-left py-2">Class Name</th>
                                <th class="text-left py-2">Description</th>
                                <th class="text-left py-2">Updated At</th>
                                <th class="text-left py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch class data from the database
                            $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                            $query = "SELECT id, classes_name, description, created_at, updated_at FROM classes WHERE classes_name LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";
                            $result = $conn->query($query);
                            $no = 1;

                            // Loop through the results and display data in rows
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="py-2"><?php echo $no++; ?></td>
                                    <td class="py-2"><?php echo $row['classes_name']; ?></td>
                                    <td class="py-2"><?php echo substr($row['description'], 0, 50) . '...'; ?></td>
                                    <td class="py-2"><?php echo date('M j, Y H:i:s', strtotime($row['updated_at'])); ?></td>
                                    <td class='py-2'>
                                        <a href="../classes/classesDetail.php?id=<?php echo $row['id']?>" class='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                                            <i class='fas fa-eye mr-2'></i>
                                            <span>Detail</span>
                                        </a>
                                        <a href="../classes/classesUpdate.php?id=<?php echo $row['id']?>" class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                                            <i class='fas fa-edit mr-2'></i>
                                            <span>Edit</span>
                                        </a>
                                        <a href="../classes/ClassesDelete.php?id=<?php echo $row['id']?>" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm'>
                                            <i class='fas fa-trash mr-2'></i>
                                            <span>Delete</span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <!-- End Table -->
                </div>
                <!-- End Content -->
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