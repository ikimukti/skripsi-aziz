        <footer class="bg-gray-800 text-gray-400 py-4 shadow-md mt-auto sticky bottom-0 border-t border-gray-700">
            <div class="container mx-auto text-center text-sm">
                <p>&copy; 2023 Your Company. All rights reserved.</p>
            </div>
        </footer>

        <script>
            function confirmLogout() {
                Swal.fire({
                    title: 'Apakah Anda yakin ingin logout?',
                    text: 'Anda akan keluar dari sesi ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the logout page or trigger your logout logic here
                        window.location.href = '../systems/logout.php';
                    }
                });
            }
        </script>
        <script>
            function confirmImageUpload() {
                Swal.fire({
                    title: 'Upload Image',
                    text: 'Anda yakin ingin mengunggah gambar profil baru?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna memilih "Ya," submit form untuk mengunggah gambar
                        document.getElementById('image-upload-form').submit();
                    }
                });
            }
        </script>
        <script>
            function confirmProfileUpdate() {
                Swal.fire({
                    title: 'Update Profile',
                    text: 'Anda yakin ingin menyimpan perubahan profil?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna memilih "Ya," submit form pembaruan profil
                        document.getElementById('profile-update-form').submit();
                    }
                });
            }
        </script>