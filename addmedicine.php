<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="./assets/css/soft-design-system.css">

<?php
session_start();
@include './config.php';
if(!isset($_SESSION['NamaDepan'])){
    header('location:../Login_Signup/Login.php');
}
if(isset($_POST['submit'])) {
    if(isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email']; 
    } else {
        header("Location: ./pages/home.php?error=Email is not set in the session");
 
    }
    $meds_name = mysqli_real_escape_string($conn, $_POST['meds_name']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $urgent = mysqli_real_escape_string($conn, $_POST['urgent']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    
    $query = "INSERT INTO reminders (nama_obat,catatan, waktu, urgent, meds_for, created_at) VALUES ('$meds_name','$note','$time', '$urgent', '$Email', NOW())";
    mysqli_query($conn, $query);

    
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        swal({
            title: "Medicine Added!",
            text: "Directing to Home page",
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
            title: "Error Adding Medicine",
            text: "Directing to Home page",
            icon: "warning",
            button: "Ok",
        }).then(() => {
            window.location.href = "./pages/home.php";
        });
    });
    </script><?php
}
?>




