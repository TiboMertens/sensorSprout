<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include_once("classes/Db.php");
    include_once("classes/Sensor.php");

    // get the JSON data from the webhook request
    $json = file_get_contents('php://input');
  
    // decode the JSON data into a PHP object
    $data = json_decode($json);
  
    // extract the temperature value from the decoded_payload data
    $temperature = $data->uplink_message->decoded_payload->temperature;

    Sensor::saveReading($temperature);

    //write the temperature value to a file
    $file = 'webhook_data.txt';
    file_put_contents($file, $temperature . PHP_EOL, FILE_APPEND | LOCK_EX);
  

