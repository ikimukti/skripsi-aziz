<?php

// Initialize the session
session_start();

if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard
    header('Location: systems/dashboard.php');
    exit();
}

?>
<?php include_once('components/header.php'); ?>
<!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
<div class="h-screen flex flex-col">
    <!-- Top Navbar -->
    <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <a href="/public/index.php">
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
                <a href="/public/systems/login.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Login</a>
            </div>
        </div>
    </nav>
    <!-- End Top Navbar -->
    <!-- Main Content -->
    <main class="flex-grow bg-gray-50">
        <div class=" flex justify-center items-center h-full">
            <div class="text-center px-40">
                <h1 class="text-6xl font-bold text-gray-700 mb-10">Skripsi Aziz</h1>
                <p class="text-gray-500 mb-10 text-xl">Pengembangan Media Pembelajaran Berbasis Web Menggunakan Metode Multimedia Interaktif Untuk Meningkatkan Hasil Belajar Siswa Pada Mata Pelajaran Pemrograman Web</p>
                <a href="../public/systems/login.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                    Get Started
                </a>
            </div>
        </div>
    </main>
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