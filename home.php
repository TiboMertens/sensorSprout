<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");
try {
    if (isset($_SESSION['loggedin'])) {
        if (isset($_POST['refresh'])) {
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $user_id = $_SESSION['id']['id'];
        $moestuin_id = $_GET['id'] ?? null;

        if ($moestuin_id == null) {
            $moestuin_id = Moestuin::getMoestuinId($user_id);
        }

        $details = Moestuin::getDetailsById($moestuin_id);

        if (!$details) {
            throw new Exception('Moestuin niet gevonden');
        }

        $name = $details['name'];
        $moestuin_id = $details['id'];

        $sensors = Moestuin::getAllSensors($user_id, $moestuin_id);
        $plants = Moestuin::getAllPlants($user_id, $moestuin_id);

        $sensor_id = $sensors[0]['name'];

        if (isset($_GET['sensorID'])) {
            $currentSensor = $_GET['sensorID'];
        } else {
            $currentSensor = 'Temperatuursensor';
        }

        if ($details['is_serre'] == 1) {
            $border = '#81CCDE';
        } else {
            $border = '#496149';
        }

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
        $minHours = 6;

        if ($currentSensor == 'Lichtsensor') {
            $lichtUrenData = Moestuin::getLichtUren($moestuin_id, date('Y-m-d'));
            //count the amount of hours the average_data was above the $minLight
            $count = 0;
            foreach ($lichtUrenData as $lichtUren) {
                if ($lichtUren['average_data'] > $minLight) {
                    $count++;
                }
            }
            $lichtUren = $count;
            if ($lichtUren >= $minHours) {
                $LichtUrenStatus = 'Goed!';
                $divColorLicht = '#A5CF93';
            } else {
                $LichtUrenStatus = 'Niet genoeg!';
                $divColorLicht = '#FF0000';
            }
        }

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

        if ($currentSensor == 'Temperatuursensor') {
            $sensorTime = $timeArray[0];
            $chartID = 2;
        } elseif ($currentSensor == 'Bodemvochtsensor') {
            $sensorTime = $timeArray[1];
            $chartID = 1;
        } elseif ($currentSensor == 'Lichtsensor') {
            $sensorTime = $timeArray[0];
            $chartID = 3;
        }

        $dates = array();
        $avg = array(); // Assuming $avg is already defined elsewhere

        if ($currentSensor != 'Lichtsensor') {
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
            // Loop through the past seven days
            for ($i = 0; $i < 7; $i++) {
                $date = date('m-d', strtotime("-$i days"));

                $dateAvg = date('Y-m-d', strtotime("-$i days"));

                $lichtUrenData = Moestuin::getLichtUren($moestuin_id, $dateAvg);
                //count the amount of hours the average_data was above the $minLight
                $count = 0;
                foreach ($lichtUrenData as $lichtUrenGraph) {
                    if ($lichtUrenGraph['average_data'] > $minLight) {
                        $count++;
                    }
                }
                $lichtUrenGraph = $count;

                // Push the date and average into the arrays
                array_push($dates, $date);
                array_push($avg, $lichtUrenGraph);
            }
        }
    } else {
        header('Location: index.php');
    }
} catch (\Throwable $th) {
    $error = $th->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/normalize.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    .rotate {
        transform: rotate(90deg);
        position: relative;
        top: 10px;
        right: 6px;
    }

    @keyframes rotation {
        from {
            transform-origin: center;
            transform: rotate(0deg);
        }

        to {
            transform-origin: center;
            transform: rotate(360deg);
        }
    }

    .rotateIcon {
        animation: rotation 1s infinite linear;
        transform-origin: 50% 50%;
        /* Adjust the values as needed */
    }

    .rotatepos {
        position: relative;
        top: 0;
        left: 0;
    }
</style>

<body class="bg-[#F7F7F7]">
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
    <section id="refresh" class="hidden fixed top-0 w-full justify-center mt-[86px]">
        <div>
            <form method="post">
                <div class="flex">
                    <button type="submit" name="refresh" class="px-5 py-2 bg-[#F59B1A] rounded-full text-white font-bold" onclick="rotateIcon()"><i id="my_icon" class="fa-solid fa-arrows-rotate mr-2"></i>Refresh for new data<button>
                </div>
            </form>
        </div>
    </section>
    <div class="xl:flex xl:justify-center">
        <div id="container" class="bg-[#23232] flex justify-center items-center mt-[32px] xl:mt-[4px] xl:w-1/2">
            <?php if (isset($error)) : ?>
                <div class="error text-center">
                    <p><?php echo $error ?></p>
                    <a href="home.php">Ga terug</a>
                </div>
            <?php else : ?>
                <div class="p xl:h-[610px]">
                    <div>
                        <div class="flex w-[372px] md:w-[452px] xl:w-[580px] justify-between items-center mb-[12px] xl:mb-[32px] xl:mt-[12px]">
                            <div>
                                <a href="home.php?id=<?php echo $moestuin_id - 1 ?>"><i class="fa-solid fa-arrow-left fa-xl mr-[8px]"></i></a>
                            </div>
                            <div>
                                <h1 class="font-bold text-[26px] mb-2 text-center"><?php echo htmlspecialchars($name) ?></h1>
                            </div>
                            <div>
                                <a href="home.php?id=<?php echo $moestuin_id + 1 ?>"><i class="fa-solid fa-arrow-right fa-xl ml-[0px]"></i></a>
                            </div>
                        </div>
                        <div>
                            <div class="w-[372px] md:w-[452px] xl:w-[580px] h-[520px] rounded-xl bg-[#739B72] flex flex-col justify-between border-[8px] border-dashed" style="border-color: <?php echo $border ?>;">
                                <div class="flex-grow-1 ml-[20px] md:ml-[10px] xl:ml-[30px]">
                                    <div class="flex">
                                        <h2 class="font-regular text-[18px] text-white ml-[24px] mt-[20px]">Sensoren</h2>
                                        <a href="editSensors.php?id=<?php echo $moestuin_id ?>">
                                            <div class="flex relative top-[35px] ml-[8px]">
                                                <p class="text-[10px] text-white font-semibold relative bottom-2 ml-[4px]">Aanpassen</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap ml-[24px]">
                                        <?php foreach ($sensors as $sensor) : ?>
                                            <div class="mr-[12px]">
                                                <form action="" method="post">
                                                    <div class="pt-[8px]">
                                                        <div class="h-[32px] w-[32px] bg-[#5C7C5B] rounded-md border-2 border-[#496048] flex justify-center items-center">
                                                            <p class="text-[14px]" style="font-family: Yeseva One;"><?php echo $sensor['short_name'] ?></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="flex">
                                        <h2 class="font-regular text-[18px] text-white ml-[24px] mt-[24px] ">Planten</h2>
                                        <a href="editPlants.php?id=<?php echo $moestuin_id ?>&q=">
                                            <div class="flex relative top-[40px] ml-[8px]">
                                                <p class="text-[10px] text-white font-semibold relative bottom-2 ml-[4px]">Aanpassen</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap ml-[24px] max-h-[260px] overflow-y-auto">
                                        <?php foreach ($plants as $plant) : ?>
                                            <a href="todo.php?id=<?php echo $plant['id'] ?>&moestuin_id=<?php echo $moestuin_id ?>">
                                                <div class="mr-[12px] mb-[3px]">
                                                    <div class="pt-[8px]">
                                                        <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-xl border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <a class="text-white font-semibold mt-[12px] mb-[20px] text-[12px]" href="createName.php">MOESTUIN TOEVOEGEN</a>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#data" class="xl:hidden">
                    <div class="fixed bottom-7 right-3 w-10 h-10 bg-[#F59B1A] rounded-full flex justify-center items-center xl:hidden">
                        <i class="fa-solid fa-arrow-down xl:hidden"></i>
                    </div>
                </a>
            <?php endif ?>
        </div>
        <?php if (!isset($error)) : ?>
            <!-- dashboard -->
            <section class="max-w-[1024px] sm:mt-[70px] mt-[32px] xl:mt-0">
                <h2 id="data" class="text-center my-[42px] text-[26px] xl:text-[28px] font-semibold xl:hidden">Data</h2>
                <div class="xl:flex gap-3">
                    <h2 class="text-[22px] xl:text-[26px] text-black ml-5 mt-[16px] sm:text-center mb-5 xl:mb-0"><?php echo $currentSensor ?></h2>
                    <div class="flex sm:justify-center">
                        <?php foreach ($sensors as $sensor) : ?>
                            <a href="home.php?id=<?php echo $moestuin_id ?>&sensorID=<?php echo $sensor['name'] ?>">
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
                                <div class="bg-[#E9E9E9] h-[25px] w-[25px] ml-[25px] rounded-sm xl:mt-[24px]" title="<?php echo $sensor['name'] ?>">
                                    <div class="relative left-[22px] bottom-[3px] h-[8px] w-[8px] bg-[<?php echo $color ?>] rounded flex justify-center">
                                        <p class="text-[12px] font-semibold relative right-[12px] top-[5px]"><?php echo $sensor['short_name'] ?></p>
                                    </div>
                                </div>

                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <section class="sm:flex xl:block">
                    <div class="sm:w-1/2">
                        <h3 data-update="<?php echo $lastUpdate ?>" data-sensor="<?php echo $sensor_id ?>" data-moestuin="<?php echo $moestuin_id ?>" id="time" class="text-[20px] xl:text-[24px] text-black ml-5 mt-[24px] mb-[16px]">Live data <span class="text-[12px]" style="font-family: Lato;">Laatste update: &nbsp;<?php echo $sensorTime; ?></span></h3>
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
                        <?php if ($currentSensor == "Lichtsensor") {
                            $height = "h-[110px] ";
                            $height2 = "h-[80px]";
                        } else {
                            $height = "h-[230px] ";
                            $height2 = "h-[160px]";
                        } ?>
                        <div class="ml-5 mr-5 h-[100px] sm:<?php echo $height ?>xl:<?php echo $height2 ?> mb-[10px] bg-[<?php echo $divColor ?>] rounded-md flex justify-between items-center max-w-[640px] xl:w-[495px]">
                            <div class="text-center w-1/2">
                                <p class="font-bold text-2xl font-serif" style="font-family: 'Yeseva One';">
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
                                <p class="font-bold text-2xl font-serif" style="font-family: 'Yeseva One';">
                                    <?php if ($currentSensor == "Temperatuursensor") {
                                        echo $tempData . " °C";
                                    } elseif ($currentSensor == "Bodemvochtsensor") {
                                        echo $vochtData . "%";
                                    } elseif ($currentSensor == "Lichtsensor") {
                                        echo $lichtData . "%";
                                    } ?></p>
                            </div>
                        </div>
                        <?php if ($currentSensor == "Lichtsensor") : ?>
                            <div class="ml-5 mr-5 h-[100px] sm:<?php echo $height ?>xl:<?php echo $height2 ?> bg-[<?php echo $divColorLicht ?>] rounded-md flex justify-between items-center max-w-[640px] xl:w-[495px]">
                                <div class="text-center w-1/2">
                                    <p class="font-bold text-2xl font-serif" style="font-family: 'Yeseva One';"><?php echo $LichtUrenStatus ?>
                                </div>
                                <div class="text-center w-1/2">
                                    <p class="font-bold text-2xl font-serif" style="font-family: 'Yeseva One';"><?php echo $lichtUren ?> uren licht</p>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="sm:w-1/2">
                        <h3 class="text-[20px] xl:text-[24px] text-black p-0 mb-[16px] mt-[36px] sm:mt-[24px] ml-5">Weekoverzicht</h3>
                        <div class="mx-5 sm:mx-0 h-[350px] w-[460px] sm:max-w-[640px] xl:w-[550px] xl:h-[250px] xl:ml-[16px]">
                            <canvas class="px-5 py-2 rounded-md bg-[#E9E9E9]" id="myChart" data-dates="<?php echo htmlspecialchars(json_encode($dates)) ?>" data-avg="<?php echo htmlspecialchars(json_encode($avg)) ?>" data-sensor="<?php echo $currentSensor ?>"></canvas>
                        </div>
                    </div>
                </section>
            </section>
        <?php endif ?>
    </div>
    <script>
        const ctx = document.getElementById('myChart');
        // get data from canvas
        const dates = JSON.parse(ctx.dataset.dates);
        const avg = JSON.parse(ctx.dataset.avg);
        const sensor = ctx.dataset.sensor;
        (sensor);

        let dataToday = '';
        let dataYesterday = '';
        let dataTwoDaysAgo = '';
        let dataThreeDaysAgo = '';
        let dataFourDaysAgo = '';
        let dataFiveDaysAgo = '';
        let dataSixDaysAgo = '';

        if (sensor == 'Temperatuursensor') {
            let dataToday = avg[0]['AVG(data)'];
            let dataYesterday = avg[1]['AVG(data)'];
            let dataTwoDaysAgo = avg[2]['AVG(data)'];
            let dataThreeDaysAgo = avg[3]['AVG(data)'];
            let dataFourDaysAgo = avg[4]['AVG(data)'];
            let dataFiveDaysAgo = avg[5]['AVG(data)'];
            let dataSixDaysAgo = avg[6]['AVG(data)'];

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
                        label: 'Gemiddelde',
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
        } else {
            let dataToday = avg[0];
            let dataYesterday = avg[1];
            let dataTwoDaysAgo = avg[2];
            let dataThreeDaysAgo = avg[3];
            let dataFourDaysAgo = avg[4];
            let dataFiveDaysAgo = avg[5];
            let dataSixDaysAgo = avg[6];

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
                        label: 'Aantal uren per dag',
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
        }
    </script>
    <script>
        // select the element with the id time 
        const time = document.querySelector('#time');
        //select the element with id refresh
        const refresh = document.querySelector('#refresh');
        //select the element with id my_icon
        const icon = document.querySelector('#my_icon');

        //every 5 seconds, call an anonymous function
        setInterval(function() {
            const update = time.getAttribute('data-update');
            const moestuin_id = time.getAttribute('data-moestuin');
            const sensor_id = time.getAttribute('data-sensor');

            let formData = new FormData();
            formData.append("time", update);
            formData.append("moestuin_id", moestuin_id);
            formData.append("sensor_id", sensor_id);
            fetch("ajax/time.php", {
                    method: "POST",
                    body: formData,
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(json) {
                    if (json.status == 'update') {
                        refresh.classList.remove('hidden');
                        refresh.classList.add('flex');
                    }
                });
        }, 5000);

        function rotateIcon() {
            var icon = document.getElementById('my_icon');
            icon.classList.add('rotateIcon');
            icon.classList.add('rotatepos');
            setTimeout(function() {
                icon.classList.remove('rotateIcon');
                icon.classList.remove('rotatepos');
            }, 2000); // Adjust the duration of rotation as needed (in milliseconds)
        }
    </script>
    <script src="js/hamburger.js"></script>
</body>

</html>