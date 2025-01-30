<?php
@include "config.php";

$name = $_POST['itemnama'];
$note = $_POST['itemcatatan'];
$time = $_POST['itemwaktu'];
$urgent = $_POST['itemurgent'];  
$email = $_POST['itememail'];
$query = "INSERT INTO reminders (nama_obat,catatan, waktu, urgent, meds_for, created_at) VALUES ('".$name."','".$note."','".$time."', '".$urgent."', '".$email."', NOW())";

// Execute the query
$masukin = mysqli_query($conn, $query);

?>