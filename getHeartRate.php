<?php
@include "config.php";


    // Query to get the latest BPM value from sensor_readings table
    $query = "SELECT * FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

?>
