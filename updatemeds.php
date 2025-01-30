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
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $meds_name = mysqli_real_escape_string($conn, $_POST['meds_name']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $urgent = mysqli_real_escape_string($conn, $_POST['urgent']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    
    $query = "UPDATE reminders SET 
                nama_obat = '$meds_name',
                waktu = '$time',
                urgent = '$urgent',
                catatan = '$note'
              WHERE id = '$id'";
    mysqli_query($conn, $query);

    
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        swal({
            title: "Medicine Updated!",
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
            title: "Error Updating Medicine",
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





