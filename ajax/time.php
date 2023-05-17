<?php
include_once ('../bootstrap.php');

if (!empty($_POST['time'])) {
    $time = $_POST['time'];
    $moestuin_id = $_POST['moestuin_id'];
    $sensor_id = $_POST['sensor_id'];

    $newTime = Moestuin::getCurrentData($moestuin_id, $sensor_id);
    $newTime = $newTime['date_time'];

    if ($newTime != $time) {
        $result = [
            "status" => "update",
            "OldTime" => $time,
            "time" => $newTime
        ];
    } else {
        $result = [
            "status" => "none",
            "OldTime" => $time,
            "time" => $newTime
        ];
    }

    echo json_encode($result);
}