<?php
include_once('../components/header.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Logout the user by unsetting and destroying the session
session_unset();
session_destroy();
// Redirect to the login page with a success message
echo '<script>
    Swal.fire({
        icon: "success",
        title: "Logged Out Successfully!",
        showConfirmButton: false,
        timer: 2000
    }).then(function(){
        window.location.href = "login.php";
    });
</script>';
exit();
?>
</body>

</html>