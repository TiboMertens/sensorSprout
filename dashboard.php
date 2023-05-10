<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $user = new User();
    $user_id = $_SESSION['id']['id'];
    $moestuin_id = $_GET['id'];

    if ($moestuin_id == null) {
        header('Location: home.php');
    }
    $sensors = Moestuin::getAllSensors($user_id, $moestuin_id);
    $plants = Moestuin::getAllPlants($user_id, $moestuin_id);

    //foreach plant, push the min temp to the array
    $minTemp = array();
    foreach ($plants as $plant) {
        array_push($minTemp, $plant['min_temp']);
    }

    //foreach plant, push the max temp to the maxTemp array
    $maxTemp = array();
    foreach ($plants as $plant) {
        array_push($maxTemp, $plant['max_temp']);
    }

    //foreach plant, push the min humidity to the minHumidity array
    $minMoisture = array();
    foreach ($plants as $plant) {
        array_push($minMoisture, $plant['min_moisture']);
    }

    //foreach plant, push the max humidity to the maxHumidity array
    $maxMoisture = array();
    foreach ($plants as $plant) {
        array_push($maxMoisture, $plant['max_moisture']);
    }

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

    if (isset($Temperatuursensor)) {
        $tempData = $Temperatuursensor;
        //if the current temperature is lower than the highest minimum temperature of all the plants, echo 'hey'.
        if ($Temperatuursensor < max($minTemp)) {
            $TemperatuursensorStatus = 'bad';
            $tempStatus = 'Te laag!';
        } elseif ($Temperatuursensor > min($maxTemp)) {
            $TemperatuursensorStatus = 'bad';
            $tempStatus = 'Te hoog!';
        } elseif ($Temperatuursensor > min($minTemp) && $Temperatuursensor < max($maxTemp)) {
            $TemperatuursensorStatus = 'good';
            $tempStatus = 'Goed!';
        } elseif ($Temperatuursensor = min($maxTemp) || $Temperatuursensor = max($minTemp)) {
            $TemperatuursensorStatus = 'warning';
            $tempStatus = 'Opgelet!';
        }
    }

    if (isset($Bodemvochtsensor)) {
        $vochtData = $Bodemvochtsensor;
        //if the current moisture is lower than the highest minimum moisture of all the plants, echo 'hey'.
        if ($Bodemvochtsensor < max($minMoisture)) {
            $BodemvochtsensorStatus = 'bad';
            $vochtStatus = 'Te laag!';
        } elseif ($Bodemvochtsensor > min($maxMoisture)) {
            $BodemvochtsensorStatus = 'bad';
            $vochtStatus = 'Te hoog!';
        } elseif ($Bodemvochtsensor > min($minMoisture) && $Bodemvochtsensor < max($maxMoisture)) {
            $BodemvochtsensorStatus = 'good';
            $vochtStatus = 'Goed!';
        } elseif ($Bodemvochtsensor = min($maxMoisture) || $Bodemvochtsensor = max($minMoisture)) {
            $BodemvochtsensorStatus = 'warning';
            $vochtStatus = 'Opgelet!';
        }
    }

    //do the same for Lichtsensor
    if (isset($Lichtsensor)) {
        $lichtData = $Lichtsensor;
        //if the current light is lower than the highest minimum light of all the plants, echo 'hey'.
        if ($Lichtsensor < $minLight) {
            $LichtsensorStatus = 'bad';
            $lichtStatus = 'Te laag!';
        } elseif ($Lichtsensor > $maxLight) {
            $LichtsensorStatus = 'bad';
            $lichtStatus = 'Te hoog!';
        } elseif ($Lichtsensor > $minLight && $Lichtsensor < $maxLight) {
            $LichtsensorStatus = 'good';
            $lichtStatus = 'Goed!';
        } elseif ($Lichtsensor = $maxLight || $Lichtsensor = $minLight) {
            $LichtsensorStatus = 'warning';
            $lichtStatus = 'Opgelet!';
        }
    }

    $currentSensor = $_GET['sensorID'];
    if ($currentSensor == 'Temperatuursensor') {
        $sensorTime = $timeArray[0];
        $chartID = 2;
    } elseif ($currentSensor == 'Bodemvochtsensor') {
        $sensorTime = $timeArray[1];
        $chartID = 1;
    } elseif ($currentSensor == 'Lichtsensor') {
        $sensorTime = $timeArray[2];
        $chartID = 3;
    }

    $dates = array();
    $avg = array(); // Assuming $avg is already defined elsewhere

    // Loop through the past seven days
    for ($i = 0; $i < 7; $i++) {
        // Get the date for the current iteration
        $date = date('m-d', strtotime("-$i days"));

        // Get the average for the current date
        $dateAvg = date('Y-m-d', strtotime("-$i days"));

        $average = Moestuin::getAvg($dateAvg, $chartID);

        // Push the date and average into the arrays
        array_push($dates, $date);
        array_push($avg, $average);
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
    <title>Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
    <section class="max-w-[1024px] mx-auto sm:mt-[70px] mt-[32px]">
        <div class="flex items-center justify-center">
            <a href="home.php?id=<?php echo $moestuin_id ?>"><i class="fa-solid fa-arrow-left fa-xl mr-2"></i></a>
            <h1 class="text-center my-[42px] text-[26px] lg:text-[28px] font-semibold">Data</h1>
        </div>
        <div class="flex sm:justify-center">
            <?php foreach ($sensors as $sensor) : ?>
                <a href="dashboard.php?id=<?php echo $moestuin_id ?>&sensorID=<?php echo $sensor['name'] ?>">
                    <?php
                    if ($sensor['name'] == "Temperatuursensor") {
                        if ($TemperatuursensorStatus === 'bad') {
                            $color = '#FF0000';
                        } elseif ($TemperatuursensorStatus === 'warning') {
                            $color = '#FFB800';
                        } else {
                            $color = '#A5CF93';
                        }
                    } elseif ($sensor['name'] == "Bodemvochtsensor") {
                        if ($BodemvochtsensorStatus === 'bad') {
                            $color = '#FF0000';
                        } elseif ($BodemvochtsensorStatus === 'warning') {
                            $color = '#FFB800';
                        } else {
                            $color = '#A5CF93';
                        }
                    } elseif ($sensor['name'] == "Lichtsensor") {
                        if ($LichtsensorStatus === 'bad') {
                            $color = '#FF0000';
                        } elseif ($LichtsensorStatus === 'warning') {
                            $color = '#FFB800';
                        } else {
                            $color = '#A5CF93';
                        }
                    }
                    ?>
                    <div class="bg-[#E9E9E9] h-[25px] w-[25px] ml-[25px] rounded-sm" title="<?php echo $sensor['name'] ?>">
                        <div class="relative left-[22px] bottom-[3px] h-[8px] w-[8px] bg-[<?php echo $color ?>] rounded"></div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>
        <h2 class="text-[22px] lg:text-[26px] text-black ml-5 mt-[16px] sm:text-center"><?php echo $currentSensor ?></h2>
        <section class="sm:flex">
            <div class="sm:w-1/2">
                <h3 class="text-[20px] lg:text-[24px] text-black ml-5 mt-[24px] mb-[16px]">Live data <span class="text-[12px]" style="font-family: Lato;">Laatste update: &nbsp;<?php echo $sensorTime; ?></span></h3>
                <?php if ($currentSensor == "Temperatuursensor") {
                    if ($TemperatuursensorStatus === 'bad') {
                        $divColor = '#FF0000';
                    } elseif ($TemperatuursensorStatus === 'warning') {
                        $divColor = '#FFB800';
                    } else {
                        $divColor = '#A5CF93';
                    }
                } elseif ($currentSensor == "Bodemvochtsensor") {
                    if ($BodemvochtsensorStatus === 'bad') {
                        $divColor = '#FF0000';
                    } elseif ($BodemvochtsensorStatus === 'warning') {
                        $divColor = '#FFB800';
                    } else {
                        $divColor = '#A5CF93';
                    }
                } elseif ($currentSensor == "Lichtsensor") {
                    if ($LichtsensorStatus === 'bad') {
                        $divColor = '#FF0000';
                    } elseif ($LichtsensorStatus === 'warning') {
                        $divColor = '#FFB800';
                    } else {
                        $divColor = '#A5CF93';
                    }
                }
                ?>
                <div class="ml-5 mr-5 h-[100px] sm:h-[230px] bg-[<?php echo $divColor ?>] rounded-md flex justify-between items-center max-w-[640px]">
                    <div class="text-center w-1/2">
                        <p class="font-bold text-3xl font-serif" style="font-family: 'Yeseva One';">
                            <?php if ($currentSensor == "Temperatuursensor") {
                                echo $tempStatus;
                            } elseif ($currentSensor == "Bodemvochtsensor") {
                                echo $vochtStatus;
                            } elseif ($currentSensor == "Lichtsensor") {
                                echo $lichtStatus;
                            }
                            ?></p>
                    </div>
                    <div class="text-center w-1/2">
                        <p class="font-bold text-3xl font-serif" style="font-family: 'Yeseva One';">
                            <?php if ($currentSensor == "Temperatuursensor") {
                                echo $tempData . " °C";
                            } elseif ($currentSensor == "Bodemvochtsensor") {
                                echo $vochtData . "%";
                            } elseif ($currentSensor == "Lichtsensor") {
                                echo $lichtData . "%";
                            } ?></p>
                    </div>
                </div>
            </div>
            <div class="sm:w-1/2">
                <h3 class="text-[20px] lg:text-[24px] text-black p-0 mb-[16px] mt-[36px] sm:mt-[24px] ml-0">Weekoverzicht</h3>
                <div class="mx-5 sm:mx-0 h-[350px] w-[460px] sm:max-w-[640px]">
                    <canvas class="px-5 py-2 rounded-md bg-[#E9E9E9]" id="myChart" data-dates="<?php echo htmlspecialchars(json_encode($dates)) ?>" data-avg="<?php echo htmlspecialchars(json_encode($avg)) ?>"></canvas>
                </div>
            </div>
        </section>
    </section>
    <script src="js/hamburger.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        // get data from canvas
        const dates = JSON.parse(ctx.dataset.dates);
        const avg = JSON.parse(ctx.dataset.avg);

        let dataToday = avg[0]['AVG(data)'];
        let dataYesterday = avg[1]['AVG(data)'];
        let dataTwoDaysAgo = avg[2]['AVG(data)'];
        let dataThreeDaysAgo = avg[3]['AVG(data)'];
        let dataFourDaysAgo = avg[4]['AVG(data)'];
        let dataFiveDaysAgo = avg[5]['AVG(data)'];
        let dataSixDaysAgo = avg[6]['AVG(data)'];

        console.log(dataToday, dataYesterday, dataTwoDaysAgo, dataThreeDaysAgo, dataFourDaysAgo, dataFiveDaysAgo, dataSixDaysAgo);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    dates[6],
                    dates[5],
                    dates[4],
                    dates[3],
                    dates[2],
                    dates[1],
                    dates[0]
                ],
                datasets: [{
                    label: 'Average',
                    data: [
                        dataSixDaysAgo, dataFiveDaysAgo, dataFourDaysAgo, dataThreeDaysAgo, dataTwoDaysAgo, dataYesterday, dataToday
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>
</body>


</html>