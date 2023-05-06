<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");
try {
    if (isset($_SESSION['loggedin'])) {
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

        if ($details['is_serre'] == 1) {
            $border = '#81CCDE';
        } else {
            $border = '#496149';
        }
    } else {
        header('Location: login.php');
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/create.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]">
    <div id="container" class="bg-[#F5F3F3] flex justify-center items-center">
        <?php if (isset($error)) : ?>
            <div class="error text-center">
                <p><?php echo $error ?></p>
                <a href="home.php">Ga terug</a>
            </div>
        <?php else : ?>
            <div class="">
                <div>
                    <div class="flex w-[372px] md:w-[452px] lg:w-[522px] justify-between items-center mb-[12px]">
                        <div>
                            <a href="home.php?id=<?php echo $moestuin_id - 1 ?>"><i class="fa-solid fa-arrow-left fa-xl mr-[8px]"></i></a>
                        </div>
                        <div>
                            <h1 class="font-bold text-[26px] mb-2 text-center"> <?php echo htmlspecialchars($name) ?> </h1>
                        </div>
                        <div>
                            <a href="home.php?id=<?php echo $moestuin_id + 1 ?>"><i class="fa-solid fa-arrow-right fa-xl ml-[0px]"></i></a>
                        </div>
                    </div>
                    <div>
                        <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px] rounded-lg bg-[#739B72] flex flex-col justify-between border-[8px] border-dashed" style="border-color: <?php echo $border ?>;">
                            <div class="flex-grow-1 ml-[20px] md:ml-[10px] lg:ml-[0px]">
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
                                    <a href="editPlants.php?id=<?php echo $moestuin_id ?>">
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
                                                    <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <a class="h-[48px] text-center bg-[#81CCDE] mt-[12px] w-[270px] md:w-[370px] lg:w-[458px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] pt-[10px]" href="dashboard.php?id=<?php echo $moestuin_id ?>&sensorID=<?php echo $sensor_id ?>">DASHBOARD</a>
                                <a class="text-white font-bold mt-[12px] mb-[20px]" href="createName.php">MOESTUIN TOEVOEGEN</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</body>

</html>