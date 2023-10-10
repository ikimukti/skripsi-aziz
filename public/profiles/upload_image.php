<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Cek apakah ada file yang diunggah
if (isset($_FILES['profile_image'])) {
  $errors = array();

  // Direktori tempat menyimpan gambar
  $target_dir = '../static/image/profile/';
  $target_file = $target_dir . basename($_FILES['profile_image']['name']);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Cek apakah file adalah gambar
  $check = getimagesize($_FILES['profile_image']['tmp_name']);
  if ($check === false) {
    $errors[] = 'File yang diunggah bukan gambar.';
  }

  // Batasi ukuran file gambar (misalnya, maksimal 2MB)
  if ($_FILES['profile_image']['size'] > 2000000) {
    $errors[] = 'Ukuran gambar terlalu besar (maksimal 2MB).';
  }

  // Hapus gambar lama jika bukan default
  if ($_SESSION['profile_url'] !== 'static/image/profile/default.jpg') {
    $old_image_path = '../' . $_SESSION['profile_url'];
    if (file_exists($old_image_path)) {
      unlink($old_image_path);
    }
  }

  // Generate nama unik untuk file gambar baru
  $new_image_name = uniqid() . '.' . $imageFileType;
  $new_image_path = $target_dir . $new_image_name;

  // Simpan file gambar baru
  if (empty($errors)) {
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $new_image_path)) {
      // Perbarui URL gambar profil di database
      $user_id = $_SESSION['user_id'];
      $profile_url = 'static/image/profile/' . $new_image_name;

      $update_query = "UPDATE users SET profile_url = ? WHERE id = ?";
      $update_stmt = $conn->prepare($update_query);
      $update_stmt->bind_param('si', $profile_url, $user_id);

      if ($update_stmt->execute()) {
        $_SESSION['profile_url'] = $profile_url;
        // Tampilkan pesan sukses dengan SweetAlert2
        echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Gambar profil berhasil diunggah.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'profile.php'; // Redirect ke halaman profil
                    });
                 </script>";
        exit();
      } else {
        $errors[] = 'Gagal mengupdate URL gambar profil.';
      }
    } else {
      $errors[] = 'Gagal mengunggah gambar.';
    }
  }
}

// Jika ada kesalahan, tampilkan pesan error
if (!empty($errors)) {
  echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengunggah gambar.',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'profile.php'; // Redirect ke halaman profil
            });
         </script>";
}
include('../components/footer.php');
