<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skripsi Aziz</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="/skripsi/dist/output.css">
    <link rel="stylesheet" href="/skripsi/node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
</head>

<body>
    <!-- Main Content Height Menyesuaikan Hasil Kurang dari Header dan Footer -->
    <div class="h-screen flex flex-col">
        <!-- Top Navbar -->
        <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <a href="/skripsi/public/index.php">
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
                    <a href="/skripsi/public/system/login.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-500 hover:bg-white mt-4 lg:mt-0">Login</a>
                </div>
            </div>
        </nav>
        <!-- End Top Navbar -->
        <!-- Main Content -->
        <main class="flex-grow bg-gray-50 flex flex-col">
            <!-- Registration Form -->
            <div class="flex-grow bg-gray-50">
                <div class="flex justify-center items-center h-full">
                    <div class="text-center px-40">
                        <h1 class="text-6xl font-bold text-gray-700 mb-10">Register</h1>
                        <form action="../public/system/register.php" method="POST" class="mb-6">
                            <label for="username" class="block text-left text-gray-600 mb-2">Username</label>
                            <input type="text" id="username" name="username" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="email" class="block text-left text-gray-600 mb-2">Email</label>
                            <input type="email" id="email" name="email" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="password" class="block text-left text-gray-600 mb-2">Password</label>
                            <input type="password" id="password" name="password" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-2" required>

                            <label for="confirm_password" class="block text-left text-gray-600 mb-2">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="border border-gray-300 rounded-full px-4 py-2 w-full mb-6" required>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full">
                                Register
                            </button>
                        </form>
                        <p class="text-gray-500 text-sm">Already have an account? <a href="../system/login.php" class="text-blue-500">Click here to login</a></p>
                    </div>
                </div>
            </div>
            <!-- End Registration Form -->
        </main>
        <!-- End Main Content -->
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