<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="./assets/css/soft-design-system.css">
<?php
session_start();
@include './config.php';

if (isset($_POST['updatePassword'])) {
    $oldPassword = md5($_POST['oldPassword']);
    $newPassword = md5($_POST['newPassword']); 
    $confirmNewPassword = md5($_POST['confirmNewPassword']); 
    $email = $_SESSION['Email'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);


    if ($oldPassword === $user['pass']) { 
        if ($newPassword === $confirmNewPassword) {
            $updateQuery = "UPDATE users SET pass = '$newPassword' WHERE email = '$email'";
            if (mysqli_query($conn, $updateQuery)) {
                ?>
                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    swal({
                        title: "Profile Changed",
                        text: "Directing to home page",
                        icon: "success",
                        button: "Ok",
                    }).then(() => {
                        window.location.href = "./pages/home.php";
                    });
                });
                </script><?php
            } else {
                ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    swal({
                        title: "Error Changing Profile",
                        text: "Directing to home page",
                        icon: "warning",
                        button: "Ok",
                    }).then(() => {
                        window.location.href = "./pages/home.php";
                    });
                });
                </script><?php
            }
        } else {
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    swal({
                        title: "Passwords Do Not Match",
                        text: "Try Again",
                        icon: "warning",
                        button: "Ok",
                    }).then(() => {
                        window.location.href = "./pages/editprofile.php";
                    });
                });
                </script><?php
        }
    } else {
        ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    swal({
                        title: "Old password is incorrect!",
                        text: "Try Again",
                        icon: "warning",
                        button: "Ok",
                    }).then(() => {
                        window.location.href = "./pages/editprofile.php";
                    });
                });
                </script><?php
    }
}
?>
