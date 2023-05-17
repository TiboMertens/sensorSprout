<?php
include_once ('../bootstrap.php');

if (!empty($_POST['time'])) {
    $time = $_POST['time'];
    $moestuin_id = $_POST['moestuin_id'];
    $sensor_id = $_POST['sensor_id'];
}