<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="./assets/css/soft-design-system.css">
<?php
session_start();
@include './config.php';

if(isset($_POST['delete_photo'])) {
    if(isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email'];
    } else {
        header("Location: ./Login_Signup/Login.php");
        exit;
    }

    $query = "UPDATE users SET Foto_Profil = NULL WHERE email = '$Email'";
    $result = mysqli_query($conn, $query);

    if ($result) {

        $carifoto = "SELECT Foto_Profil FROM users WHERE email = '$Email'";
        $fotoprofil = mysqli_query($conn, $carifoto);
        $relawan = mysqli_fetch_assoc($fotoprofil);

        if ($relawan['Foto_Profil'] !== NULL) {
            $foto_path = './uploads/' . $relawan['Foto_Profil'];
            if (file_exists($foto_path)) {
                unlink($foto_path); 
            }
        }
        ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        swal({
            title: "Profile Picture Deleted!",
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
}
?>
