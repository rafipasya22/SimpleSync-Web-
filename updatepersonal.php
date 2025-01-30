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
        header("Location: ./pages/editprofile.php?error=Email is not set in the session");
 
    }
    $Nama_Depan = mysqli_real_escape_string($conn, $_POST['namadepan']);
    $Nama_Belakang = mysqli_real_escape_string($conn, $_POST['namabelakang']);
    $Email_Baru = mysqli_real_escape_string($conn, $_POST['Email_Baru']);

    
    if(!empty($Nama_Depan) || !empty($Nama_Belakang)){
        if(empty($Nama_Depan)){
            $update = "UPDATE users SET last_name = '$Nama_Belakang' WHERE email = '$Email'";
            $_SESSION['NamaBelakang'] = $Nama_Belakang;
        } else if(empty($Nama_Belakang)){
            $update = "UPDATE users SET first_name = '$Nama_Depan' WHERE email = '$Email'";
            $_SESSION['NamaDepan'] = $Nama_Depan;
        } else {
            $update = "UPDATE users SET first_name = '$Nama_Depan', last_name = '$Nama_Belakang' WHERE email = '$Email'";
            $_SESSION['NamaDepan'] = $Nama_Depan;
            $_SESSION['NamaBelakang'] = $Nama_Belakang;
        }
        mysqli_query($conn, $update);
    }

   

    if(!empty($Email_Baru) && $Email_Baru != $Email) {
        $update_email = "UPDATE users SET email = '$Email_Baru' WHERE email = '$Email'";
        mysqli_query($conn, $update_email);

        $update_meds_for = "UPDATE reminders SET meds_for = '$Email_Baru' WHERE email = '$Email'";
        mysqli_query($conn, $update_meds_for);
        
        $_SESSION['Email'] = $Email_Baru;
        session_unset();
        session_destroy();

        header('location:Login_Signup/Login.php');
    }

    if(isset($_FILES['profile-photo']) && $_FILES['profile-photo']['error'] === 0) {
        $img_name = $_FILES['profile-photo']['name'];
        $size = $_FILES['profile-photo']['size'];
        $tmp_name = $_FILES['profile-photo']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_ex = array("jpg", "jpeg", "png");

        if(in_array($img_ex_lc, $allowed_ex)) {
            if($size <= 825000) {
                $new_img_name = uniqid("Profile-Picture-", true).'.'.$img_ex_lc;
                $img_upload_path = './uploads/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $foto = "UPDATE relawan SET Foto_Profil = '$new_img_name' WHERE Email = '$Email'";
                mysqli_query($conn, $foto);
            } else {
                $em = "Terlalu Besar Mase!";
                header("Location: ./pages/editprofile.php?error=$em");
            }
        } else {
            $em = "Ganti Tipe File Bos!";
            header("Location: ./pages/editprofile.php?error=$em");
        }
    }
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
?>




