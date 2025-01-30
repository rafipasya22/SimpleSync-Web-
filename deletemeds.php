<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="./assets/css/soft-design-system.css">

<?php
session_start();
@include './config.php';
if(!isset($_SESSION['NamaDepan'])){
    header('location:../Login_Signup/Login.php');
}
    if(isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email']; 
    } else {
        header("Location: ./pages/home.php?error=Email is not set in the session");
 
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id']; 
    } else {
        echo("ID tidak ditemukan di URL!");
    }

    
    $query = "DELETE from reminders where id = '$id'";
    mysqli_query($conn, $query);

    
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        swal({
            title: "Medicine Deleted!",
            text: "Directing to Home page",
            icon: "success",
            button: "Ok",
        }).then(() => {
            window.location.href = "./pages/home.php";
        });
    });
    </script><?php

?>





