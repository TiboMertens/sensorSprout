<?php
// https://betterstack.com/community/guides/scaling-php/php-scheduled-tasks/

include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

//do 7 times
for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $avg[$date] = Moestuin::getAvg($date);
}

var_dump($avg[date('Y-m-d', strtotime("-1 days"))]);

// // Get the current time and the target time (11:59 PM)
// $target_time = strtotime('today 23:59:00');
// $current_time = time();

// // Calculate the delay in seconds
// $delay = $target_time - $current_time;

// // Output the JavaScript code to reload the page after the delay
// echo '<script>setTimeout(function(){location.reload();}, ' . $delay * 1000 . ');</script>';

// Check if the current time is after the target time
// if ($current_time == $target_time) {
//     //get all moestuinen
//     $moestuinen = Moestuin::getAllMoestuinen();

//     foreach ($moestuinen as $moestuin) {
//         //for each moestuin, get all sensors
//         $sensors = Moestuin::getAvgSensors($moestuin['id']);
//         foreach ($sensors as $sensor) {
//             //get all readings of this day
//             $moestuin_id = $moestuin['id'];
//             $sensor_id = $sensor['sensor_id'];

//             $readings = Moestuin::getReadings($moestuin_id, $sensor_id);

//             //get the average of all readings
//             $avg = 0;
//             foreach ($readings as $reading) {
//                 $avg += $reading['data'];
//             }
//             $avg = $avg / count($readings);

//             //insert the average into the database
//             Moestuin::insertAvg($avg, $moestuin_id, $sensor_id);
//         }
//     }
// }
