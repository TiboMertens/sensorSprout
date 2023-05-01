<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

//check if the current time is 23:59
if(date('H:i') == '23:59'){
    //get all moestuinen
    $moestuinen = Moestuin::getAllMoestuinen();

    foreach ($moestuinen as $moestuin) {
        //for each moestuin, get all sensors
        $sensors = Moestuin::getAvgSensors($moestuin['id']);
        foreach ($sensors as $sensor) {
            //get all readings of this day
            $moestuin_id = $moestuin['id'];
            $sensor_id = $sensor['sensor_id'];

            $readings = Moestuin::getReadings($moestuin_id, $sensor_id);

            //get the average of all readings
            $avg = 0;
            foreach ($readings as $reading) {
                $avg += $reading['data'];
            }
            $avg = $avg / count($readings);

            //insert the average into the database
            Moestuin::insertAvg($avg, $moestuin_id, $sensor_id);
        }
    }
}

