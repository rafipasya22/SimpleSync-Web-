<?php
@include "config.php";

    $lastTimestampQuery = "SELECT timestamp FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
    $lastTimestampResult = mysqli_query($conn, $lastTimestampQuery);

    if (mysqli_num_rows($lastTimestampResult) > 0) {
        $lastRow = mysqli_fetch_assoc($lastTimestampResult);
        $lastTimestamp = $lastRow['timestamp']; 
        $query = "SELECT 
                    DATE_FORMAT(FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp) / 600) * 600), '%H:%i') AS time_interval,
                    AVG(heart_rate) AS avg_heart_rate
                  FROM sensor_readings
                  WHERE timestamp BETWEEN DATE_SUB('$lastTimestamp', INTERVAL 120 MINUTE) AND '$lastTimestamp'
                  GROUP BY time_interval
                  ORDER BY time_interval ASC;";
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
    } else {
        echo json_encode(['error' => 'No data found in the table']);
    }

?>
