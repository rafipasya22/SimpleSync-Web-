<?php

@include '../config.php';

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/HandinHandLogo.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./login.css">
    <title>Sign In</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post" class="signup">
                <h1>Buat Akun</h1>
                <input type = "Nama Awal" id= "namaawal" placeholder="Nama Depan" name="namadepan" required>
                <input type = "Nama Belakang" id= "namaBelakang" placeholder="Nama Belakang" name="namabelakang" required>
                <input type = "email" id= "email" placeholder="Email" name="Email" required>
                <input type = "password" id= "password" placeholder="Password" name="PW" required>
                <button class="button" type="submit" name= "submit_signup" value="register">Sign Up</button>
            </form>
            <?php
                        if(isset($_POST['submit_signup'])){
                            $Nama_Depan = mysqli_real_escape_string($conn, $_POST['namadepan']);
                            $Nama_Belakang = mysqli_real_escape_string($conn, $_POST['namabelakang']);
                            $Email = mysqli_real_escape_string($conn,$_POST['Email']);
                            $PW = md5($_POST['PW']);
                        
                            $select = " SELECT * FROM users WHERE email = '$Email' && pass = '$PW'";
                            $result = mysqli_query($conn, $select);
                            $already_exist = "SELECT email FROM users WHERE email = '$Email'";
                            $already_exist_hasil = mysqli_query($conn, $already_exist);
                        
                            if(mysqli_num_rows($result)>0){
                                ?>
                                <script>
                                    swal({
                                    title: "User already Exist!",
                                    text: "Please use a different email",
                                    icon: "warning",
                                    buttons: {
                                    cancel: "Cancel",
                                    Login: {
                                    text: "Login",
                                    value: "Login",
                                    },
                                },
                                }).then((value) => {
                                    switch (value) {
                                        case "Login":
                                        then(function() {
                                        window.location.href = './Login.php';
                                        });
                                        break;
                                    
                                        default:
                                        then(function() {
                                        window.location.href = './Login.php';
                                        });
                                    }
                                });
                                </script>
                                <?php
                                
                            }else{
                                if(mysqli_num_rows($already_exist_hasil)>0){
                                    ?>
                                <script>
                                    swal({
                                    title: "User already Exist!",
                                    text: "Please use a different email",
                                    icon: "warning",
                                    buttons: {
                                    cancel: "Cancel",
                                    Login: {
                                    text: "Login",
                                    value: "Login",
                                    },
                                },
                                }).then((value) => {
                                    switch (value) {
                                        case "Login":
                                        then(function() {
                                        window.location.href = './Login.php';
                                        });
                                        break;
                                    
                                        default:
                                        then(function() {
                                        window.location.href = './Login.php';
                                        });
                                    }
                                });
                                </script>
                                <?php
                                    
                                }else{
                                    $insert = "INSERT INTO users(first_name, last_name, email, pass) VALUES ('$Nama_Depan', '$Nama_Belakang', '$Email', '$PW')";
                                    mysqli_query($conn, $insert);
                                    ?>
                                    <script>
                                        swal({
                                        title: "Register Successful!",
                                        text: "Please Sign In",
                                        icon: "success",
                                        button: "Ok",
                                        }).then(function() {
                                        window.location.href = './Login.php';
                                        });;
                                    </script>
                                    <?php
                                }
                                
                            }
                        
                        };
                    ?>
        </div>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>
                <?php
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<span class = "error_msg">'.$error.'</span>';
                            };
                        };
                ?>
                <input type = "email" id= "email" placeholder="Email" name="Email" required>
                <input input type = "password" id= "password" placeholder="Password" name="PW" required>
                <button href="../pages/events.php" class="button" type="submit" value="register" name="submit_login">Sign In</button>
            </form>
            <?php
                    if(isset($_POST['submit_login'])){
                        $Email = mysqli_real_escape_string($conn,$_POST['Email']);
                        $PW = md5($_POST['PW']);
                    
                    
                        $select = "SELECT * FROM users WHERE email = '$Email' && pass = '$PW'";
                        $result = mysqli_query($conn, $select);
                        
                        if(mysqli_num_rows($result)>0){
                            
                            $row = mysqli_fetch_array($result);
                            $Email = $_SESSION['Email'] = $row['email'];
                            $_SESSION['NamaDepan'] = $row['first_name'];
                            $_SESSION['NamaBelakang'] = $row['last_name'];
                            ?>
                            <script>
                                    swal({
                                    title: "Welcome, <?php echo $_SESSION['NamaDepan'];?>",
                                    text: "Sign In Successful!",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function() {
                                window.location.href = '../pages/home.php';
                                });;
                            </script>
                            <?php
                        }else{
                            ?>
                            <script>
                                    swal({
                                    title: "Wrong Email or Password!",
                                    text: "Please Sign in Again",
                                    icon: "warning",
                                    button: "Ok",
                                }).then(function() {
                                window.location.href = './Login.php';
                                });;
                            </script>
                            <?php 
                        }
                    };
                ?>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Selamat Datang!</h1>
                    <p>Silahkan Melakukan Registrasi Untuk Mengakses Fitur-Fitur Website Kami!</p>
                    <p>Sudah Punya Akun?</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Selamat Datang!</h1>
                    <p>Tempat di mana kebaikan dimulai dan perubahan terjadi. Bergabunglah dengan kami untuk membuat perbedaan!
                    </p>
                    <p class="belum">Belum Punya Akun?</p>
                    <button class="hidden" id="register">Daftar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./login_signup.js"></script>
</body>

</html>