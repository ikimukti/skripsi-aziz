<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$username = $password = '';
$errors = array();
$selectedSubject = ''; // Variable to store the selected subject

// Check if a subject is selected from the dropdown
if (isset($_GET['subject']) && $_GET['subject'] !== '') {
  $selectedSubject = $_GET['subject'];
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
    <main class=" bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen flex-shrink-0 sc-hide">
      <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
        <!-- Header Content -->
        <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
          <h1 class="text-3xl text-gray-800 font-semibol w-full">Materials List</h1>
          <div class="flex flex-row justify-end items-center">
            <a href="../materials/materialsCreate.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
              <i class="fas fa-plus mr-2"></i>
              <span>Create</span>
            </a>
          </div>
        </div>
        <!-- End Header Content -->
        <!-- Content -->
        <div class="flex flex-col w-full">
          <!-- Dropdown for Selecting Subjects -->
          <div class="mb-4">
            <label for="subjectDropdown" class="block text-gray-800 font-semibold">Select Subject:</label>
            <select id="subjectDropdown" name="subjectDropdown" class="bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
              <option value="" <?php if ($selectedSubject === '') echo 'selected'; ?>>All Subjects</option>
              <?php
              // Fetch subjects from the database
              $querySubjects = "SELECT id, subject_name FROM subjects ORDER BY subject_name ASC";
              $resultSubjects = $conn->query($querySubjects);

              while ($rowSubject = $resultSubjects->fetch_assoc()) {
                $subjectId = $rowSubject['id'];
                $subjectName = $rowSubject['subject_name'];
                $selected = ($subjectId == $selectedSubject) ? 'selected' : '';

                echo "<option value='$subjectId' $selected>$subjectName</option>";
              }
              ?>
            </select>
            <button onclick="applyFilter()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">
              Apply Filter
            </button>
          </div>
          <!-- End Dropdown -->

          <!-- Navigation -->
          <div class="flex flex-row justify-between items-center w-full mb-2 pb-2">
            <div>
              <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
              <p class="text-gray-600 text-sm">Here are the list of materials.</p>
            </div>
            <!-- Search -->
            <form class="flex items-center justify-end space-x-2 w-96">
              <input type="text" name="search" class="bg-gray-200 focus:bg-white focus:outline-none border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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
                <th class="text-left py-2">Title</th>
                <th class="text-left py-2">Type</th>
                <th class="text-left py-2">Content</th>
                <th class="text-left py-2">Subject</th>
                <th class="text-left py-2">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Build the SQL query based on selected subject (if any)
              $query = "SELECT m.id, m.title, m.type, m.content, m.sequence, s.subject_name 
                                      FROM materials m
                                      LEFT JOIN subjects s ON m.subject_id = s.id
                                      WHERE 1 ";

              if ($selectedSubject !== '') {
                $query .= "AND s.id = $selectedSubject ";
              }

              $query .= "ORDER BY m.id ASC";

              // Fetch material data from the database limit by 15 data per page
              $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $query .= " LIMIT " . ($page - 1) * 15 . ", 15";
              $result = $conn->query($query);

              // Count total rows in the table
              $queryCount = "SELECT COUNT(*) AS count FROM materials m
                                            LEFT JOIN subjects s ON m.subject_id = s.id
                                            WHERE 1 ";

              if ($selectedSubject !== '') {
                $queryCount .= "AND s.id = $selectedSubject ";
              }

              $queryCount .= "AND (m.title LIKE '%" . $searchTerm . "%' OR
                                            m.type LIKE '%" . $searchTerm . "%' OR
                                            m.content LIKE '%" . $searchTerm . "%')";

              $resultCount = $conn->query($queryCount);
              $rowCount = $resultCount->fetch_assoc()['count'];
              $totalPage = ceil($rowCount / 15);

              $no = 1;

              // Loop through the results and display data in rows
              while ($row = $result->fetch_assoc()) {
              ?>
                <tr>
                  <td class="py-2"><?php echo $no++; ?></td>
                  <td class="py-2"><?php echo $row['title']; ?></td>
                  <td class="py-2"><?php echo $row['type']; ?></td>
                  <td class="py-2"><?php echo substr($row['content'], 0, 50) . '...'; ?></td>
                  <td class="py-2"><?php echo $row['subject_name']; ?></td>
                  <td class='py-2'>
                    <!-- Detail Button -->
                    <a href="../materials/materialsDetail.php?id=<?php echo $row['id'] ?>" class='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                      <i class='fas fa-eye mr-2'></i>
                      <span>Detail</span>
                    </a>
                    <!-- Edit Button -->
                    <a href="../materials/materialsUpdate.php?id=<?php echo $row['id'] ?>" class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                      <i class='fas fa-edit mr-2'></i>
                      <span>Edit</span>
                    </a>
                    <!-- Delete Button -->
                    <a href="../materials/materialsDelete.php?id=<?php echo $row['id'] ?>" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm'>
                      <i class='fas fa-trash mr-2'></i>
                      <span>Delete</span>
                    </a>
                  </td>
                </tr>
              <?php
              }
              if ($result->num_rows === 0) {
              ?>
                <tr>
                  <td colspan="6" class="py-2 text-center">No data found.</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <!-- End Table -->
          <?php
          // Pagination
          ?>
          <div class="flex flex-row justify-between items-center w-full mt-4">
            <div class="flex flex-row justify-start items-center">
              <span class="text-gray-600">Total <?php echo $rowCount; ?> rows</span>
            </div>
            <div class="flex flex-row justify-end items-center space-x-2">
              <a href="?page=1&search=<?php echo $searchTerm; ?>&subject=<?php echo $selectedSubject; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-angle-double-left"></i>
              </a>
              <a href="?page=<?php if ($page == 1) {
                                echo $page;
                              } else {
                                echo $page - 1;
                              } ?>&search=<?php echo $searchTerm; ?>&subject=<?php echo $selectedSubject; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-angle-left"></i>
              </a>
              <!-- Page number -->
              <?php
              $startPage = $page - 2;
              $endPage = $page + 2;
              if ($startPage < 1) {
                $endPage += abs($startPage) + 1;
                $startPage = 1;
              }
              if ($endPage > $totalPage) {
                $startPage -= $endPage - $totalPage;
                $endPage = $totalPage;
              }
              if ($startPage < 1) {
                $startPage = 1;
              }
              for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $page) {
                  echo "<a href='?page=$i&search=$searchTerm&subject=$selectedSubject' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center'>$i</a>";
                } else {
                  echo "<a href='?page=$i&search=$searchTerm&subject=$selectedSubject' class='bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center'>$i</a>";
                }
              }
              ?>
              <a href="?page=<?php if ($page == $totalPage) {
                                echo $page;
                              } else {
                                echo $page + 1;
                              } ?>&search=<?php echo $searchTerm; ?>&subject=<?php echo $selectedSubject; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-angle-right"></i>
              </a>
              <a href="?page=<?php echo $totalPage; ?>&search=<?php echo $searchTerm; ?>&subject=<?php echo $selectedSubject; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-angle-double-right"></i>
              </a>
            </div>
            <div class="flex flex-row justify-end items-center ml-2">
              <span class="text-gray-600">Page <?php echo $page; ?> of <?php echo $totalPage; ?></span>
            </div>
          </div>
        </div>
        <!-- End Content -->
      </div>
      <hr class="mt-60">
    </main>
    <!-- End Main Content -->
  </div>
  <!-- End Main Content -->
  <!-- Footer -->
  <?php include('../components/footer.php'); ?>
  <!-- End Footer -->
</div>
<!-- End Main Content -->

<script>
  // JavaScript function to apply the filter when a subject is selected from the dropdown
  function applyFilter() {
    const selectedSubject = document.getElementById('subjectDropdown').value;
    // Redirect to the same page with the selected subject as a query parameter
    window.location.href = `materialsList.php?subject=${selectedSubject}`;
  }
</script>

</body>

</html>