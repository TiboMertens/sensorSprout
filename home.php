<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $user_id = $_SESSION['id']['id'];

    $details = Moestuin::getDetails($user_id);

    if (isset($_GET['id']) && $_GET['id'] < count($details)) {
        $counter = intval($_GET['id']);
    } else {
        $counter = 0;
    }

    if ($counter < 0) {
        $counter = 0;
    }

    $name = $details[$counter]['name'];
    $moestuin_id = $details[$counter]['id'];

    $sensors = Moestuin::getAllSensors($user_id, $moestuin_id);
    $plants = Moestuin::getAllPlants($user_id, $moestuin_id);
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
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <script src="js/overlay.js" defer></script>
    <link rel="stylesheet" href="css/create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <div id="container" class="bg-[#F5F3F3]" style="height: 100%">
        <div id="container2" class="">
            <div>
                <div class="flex w-[372px] justify-between items-center">
                    <div>
                        <a href="home.php?id=<?php echo $counter - 1 ?>"><i class="fa-solid fa-arrow-left fa-xl mr-[8px] relative top-[2px]"></i></a>
                    </div>
                    <div>
                        <h1 class="font-bold text-[26px] mb-2 text-center"> <?php echo htmlspecialchars($name) ?> </h1>
                    </div>
                    <div>
                        <a href="home.php?id=<?php echo $counter + 1 ?>"><i class="fa-solid fa-arrow-right fa-xl ml-[0px] relative top-[2px]"></i></a>
                    </div>
                </div>

                <div>
                    <div class="w-[372px] h-[520px] bg-[#808080] flex flex-col justify-between">
                        <div class="flex-grow-1">
                            <h2 class="font-bold text-[14px] text-white ml-[24px] mt-[8px]">Sensoren</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($sensors as $sensor) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div class="pt-[8px]">
                                                <div class="h-[32px] w-[32px] bg-black flex justify-center items-center"></div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <h2 class="font-bold text-[20px] text-white ml-[24px] mt-[8px]">Planten</h2>
                            <div class="flex flex-wrap justify-center">
                                <?php foreach ($plants as $plant) : ?>
                                    <div class="mr-[24px] mb-[24px]">
                                        <form action="" method="post">
                                            <div class="pt-[8px]">
                                                <div class="h-[72px] w-[72px] bg-black flex justify-center items-center"></div>
                                                <p class="pt-1 text-[12px] font-medium text-white max-w-[72px] break-all text-left"><?php echo wordwrap($plant['name'], 10, '-') ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="DASHBOARD" name="dashboard" id="dashboard" class="h-[48px] bg-[#81CCDE] w-[324px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[12px]">
                            <a href="editMoestuin.php" class="mb-[12px]">Aanpassen</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>