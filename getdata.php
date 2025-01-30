<?php
@include "config.php";


    // Query to get the latest BPM value from sensor_readings table
    $query = "SELECT TIME(timestamp) AS time_only, heart_rate, spo2 FROM sensor_readings";
    $result = mysqli_query($conn, $query);

    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data); 
    } else {
        echo json_encode(['error' => 'No data found in the specified range']);
    }

?>
