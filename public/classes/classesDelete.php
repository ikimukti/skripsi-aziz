<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Cek apakah ID kelas disediakan dalam parameter query
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect ke halaman error atau lokasi yang sesuai
    header('Location: error.php');
    exit();
}

$id = $_GET['id'];

// Inisialisasi pesan sukses dan pesan error
$success_message = '';
$error_message = '';

// Ambil nama file gambar kelas sebelum menghapus
$query = "SELECT classes_image FROM classes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($class_image);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    // Hapus gambar kelas jika bukan default
    if ($class_image !== 'static/image/class/default.jpg') {
        $class_image_path = '../' . $class_image;
        if (file_exists($class_image_path)) {
            unlink($class_image_path);
        }
    }
    $stmt->close();
} else {
    // Kelas tidak ditemukan
    $stmt->close();
    $error_message = "Kelas tidak ditemukan.";
}

// Lakukan penghapusan kelas dari database
$query = "DELETE FROM classes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Penghapusan berhasil
    $stmt->close();
    $success_message = "Kelas berhasil dihapus!";
} else {
    // Penghapusan gagal
    $stmt->close();
    $error_message = "Gagal menghapus kelas.";
}

// Tampilkan pesan sukses atau pesan error dengan SweetAlert2
if (!empty($success_message)) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '$success_message',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = '../classes/classesList.php'; // Redirect ke halaman daftar kelas
        });
    </script>";
} elseif (!empty($error_message)) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '$error_message',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = '../classes/classesList.php'; // Redirect ke halaman daftar kelas
        });
    </script>";
}

include('../components/footer.php');
