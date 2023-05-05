<?php
require_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    if (isset($_GET['id'])) {
        $moestuin_id = $_GET['moestuin_id'];
        $plant_id = $_GET['id'];
        $user_id = $_SESSION['id']['id'];

        $currentPlant = Plant::getCurrentPlant($plant_id);
        $sensors = Moestuin::getAllSensors($user_id, $moestuin_id);

        $minTemp = $currentPlant['min_temp'];
        $maxTemp = $currentPlant['max_temp'];

        $minMoisture = $currentPlant['min_moisture'];
        $maxMoisture = $currentPlant['max_moisture'];

        $minLight = 70;
        $maxLight = 100;

        $sensorNames = array();
        foreach ($sensors as $sensor) {
            array_push($sensorNames, $sensor['name']);
        }

        //get the current data for every sensor
        $currentData = array(); // initialize empty array
        $timeArray = array();
        foreach ($sensorNames as $sensorName) {
            //get the sensor id from the sensor corresponding to the sensor name
            $sensor_id = Sensor::getSensorId($sensorName);
            $sensor_id = $sensor_id['id'];
            $currentTemp = Moestuin::getCurrentData($sensor_id, $moestuin_id);
            //add the current data to the array with the sensor name as key
            $currentData[$sensorName] = $currentTemp;
            $$sensorName = $currentData[$sensorName]['data'];
            $lastUpdate = $currentData[$sensorName]['date_time'];
            $time = strtotime($lastUpdate);
            $timeString = date('H:i:s', $time);
            array_push($timeArray, $timeString);
        }

        $todos = array();

        if (isset($Temperatuursensor)) {
            $tempData = $Temperatuursensor;
            //if the current temperature is lower than the highest minimum temperature of all the plants, echo 'hey'.
            if ($Temperatuursensor < $minTemp) {
                $message = 'Temperatuur verhogen';
                $tip = 'De optimale temperatuur is tussen ' . $minTemp . '°C en ' . $maxTemp . '°C.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            } elseif ($Temperatuursensor > $maxTemp) {
                $message = 'Temperatuur verlagen';
                $tip = 'De optimale temperatuur is tussen ' . $minTemp . '°C en ' . $maxTemp . '°C.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            }
        }

        if (isset($Bodemvochtsensor)) {
            $vochtData = $Bodemvochtsensor;
            //if the current moisture is lower than the highest minimum moisture of all the plants, echo 'hey'.
            if ($Bodemvochtsensor < $minMoisture) {
                $message = 'Vochtigheid verhogen';
                $tip = 'De optimale vochtigheid is tussen ' . $minMoisture . '% en ' . $maxMoisture . '%.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            } elseif ($Bodemvochtsensor > $maxMoisture) {
                $message = 'Vochtigheid verlagen';
                $tip = 'De optimale vochtigheid is tussen ' . $minMoisture . '% en ' . $maxMoisture . '%.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            }
        }

        //do the same for Lichtsensor
        if (isset($Lichtsensor)) {
            $lichtData = $Lichtsensor;
            //if the current light is lower than the highest minimum light of all the plants, echo 'hey'.
            if ($Lichtsensor < $minLight) {
                $message = 'Lichtsterkte verhogen';
                $tip = 'De optimale lichtsterkte is tussen ' . $minLight . '% en ' . $maxLight . '%.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            } elseif ($Lichtsensor > $maxLight) {
                $message = 'Lichtsterkte verlagen';
                $tip = 'De optimale lichtsterkte is tussen ' . $minLight . '% en ' . $maxLight . '%.';
                // Push the message and tip into the todo array
                array_push($todos, array(
                    'message' => $message,
                    'tip' => $tip
                ));
            }
        }

        $amount = count($todos);
    } else {
        header('Location: home.php');
    }
} else {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <section class="max-w-[1024px] mx-auto sm:mt-[70px]">
        <div class="flex items-center justify-center">
            <a href="home.php?id=<?php echo $moestuin_id ?>"><i class="fa-solid fa-arrow-left fa-xl mr-2"></i></a>
            <h1 class="text-center my-[42px] text-[26px] lg:text-[28px] font-semibold"><?php echo $currentPlant['name'] ?></h1>
        </div>
        <h2 class="text-center text-[22px] lg:text-[26px]">Dagen tot oogst: &nbsp;<?php echo $currentPlant['days_to_harvest'] ?> </h2>
        <div>
            <h3 class="text-[20px] lg:text-[24px] text-black ml-5 mt-[24px] mb-[16px]">Jouw taken</h3>
            <section class="sm:flex sm:gap-5 mx-5">
                <?php foreach ($todos as $todo) : ?>
                    <div class="<?php echo $amount == 1 ? 'w-full' : 'w-full sm:w-1/2'; ?> mb-5 h-[100px] sm:h-[130px] bg-[#E9E9E9] rounded-md">
                        <div class="border-b-2 border-black mx-5 flex items-center" style="height:60%">
                            <h3 class="font-bold text-[16px] sm:text-[18px]" style="font-family: lato;"><?php echo $todo['message'] ?></h3>
                        </div>
                        <div class="mx-5 flex items-center text-[14px]" style="height:40%">
                            <p class="font-light"><?php echo $todo['tip'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </section>
</body>

</html>