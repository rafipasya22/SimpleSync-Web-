<?php
@include "config.php";

$email = $_POST['email'];
date_default_timezone_set('Asia/Jakarta'); 

$query = "SELECT * FROM reminders WHERE meds_for = '$_SESSION[Email]'";
$result = mysqli_query($conn, $query);


$closestMedicationName = null;
$closestMedicationTime = null;
$closestMedicationTimeDiff = null;

if (mysqli_num_rows($result) > 0) {
    $smallestTimeDifference = PHP_INT_MAX; 
    while ($row = mysqli_fetch_assoc($result)) {
        $db_time = $row['waktu']; 
        $current_time = date("Y-m-d H:i:s"); 

        $time_difference = strtotime($db_time) - strtotime($current_time);

        $hours = floor(abs($time_difference) / 3600);
        $minutes = floor((abs($time_difference) % 3600) / 60);

        $time_difference_str = "";
        if ($time_difference > 0) {
            $time_difference_str = "$hours hours and $minutes minutes";
        } elseif ($time_difference < 0) {
            $time_difference_str = "$hours hours and $minutes minutes ago";
        } else {
            $time_difference_str = "Now";
        }

        if ($time_difference > 0 && $time_difference < $smallestTimeDifference) {
            $smallestTimeDifference = $time_difference;
            $closestMedicationName = $row['nama_obat']; 
            $closestMedicationTime = $row['waktu']; 
            $closestMedicationTimeDiff = $time_difference_str; 
        }
    }

    if ($closestMedicationName) {
        echo json_encode([
            'meds_name' => $closestMedicationName,
            'time' => $closestMedicationTime,
            'time_difference' => $closestMedicationTimeDiff
        ]);
    } else {
        echo json_encode(['error' => 'No upcoming medications found']);
    }
} else {
    echo json_encode(['error' => 'No data found']);
}
?>
