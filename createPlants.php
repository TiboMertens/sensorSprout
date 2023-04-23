<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $name = $_SESSION['name'];
    $plants = Plant::getAll();

    // initialize the selected sensors array if it doesn't exist in the session
    if (!isset($_SESSION['selectedPlants'])) {
        $_SESSION['selectedPlants'] = array();
    }

    // add the clicked button value to the selected sensors array
    if (isset($_POST['btn'])) {
        array_push($_SESSION['selectedPlants'], $_POST['btn']);
    }

    // get the current contents of the selected sensors array
    $selectedSensors = $_SESSION['selectedSensors'];
    $selectedPlants = $_SESSION['selectedPlants'];

    if (!empty($_POST['save'])) {
        $moestuin = new Moestuin();
        $moestuin->setName($_SESSION['name']);
        $moestuin->setSerre($_SESSION['serre']);
        $moestuin->setUserId($_SESSION['id']['id']);
        $moestuin->setSensors($selectedSensors);
        $moestuin->setPlants($selectedPlants);
        $moestuin->save();
        header('Location: home.php');
    }
} else {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creëer je moestuin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/create.css">
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <script src="js/overlay.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <div id="container" class="bg-[#F5F3F3]" style="height: 100%">
        <div id="container2" class="">
            <div>
                <h1 class="font-bold text-[26px] mb-2"><?php echo htmlspecialchars($name) ?></h1>
                <div>
                    <div class="w-[372px] h-[520px] bg-[#808080] flex flex-col justify-between">
                        <div class="flex-grow-1">
                            <h2 class="font-bold text-[14px] text-white ml-[24px] mt-[8px]">Geselecteerde sensoren</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($selectedSensors as $sensor) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div class="pt-[8px]">
                                                <div class="h-[32px] w-[32px] bg-black flex justify-center items-center"></div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <h2 class="font-bold text-[20px] text-white ml-[24px] mt-[8px]">Voeg je planten toe</h2>
                            <div class="flex flex-wrap justify-center">
                                <?php foreach ($selectedPlants as $plant) : ?>
                                    <div class="mr-[24px] mb-[24px]">
                                        <form action="" method="post">
                                            <div class="pt-[8px]">
                                                <div class="h-[72px] w-[72px] bg-black flex justify-center items-center"></div>
                                                <p class="pt-1 text-[12px] font-medium text-white max-w-[72px] break-all text-left"><?php echo wordwrap($plant, 10, '-') ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <div class="mt-[8px]">
                                    <div>
                                        <div class="h-[72px] w-[72px] bg-black flex justify-center items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #ffffff;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="SAVE" name="save" id="save" class="h-[48px] bg-[#81CCDE] w-[324px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
                        </form>
                    </div>
                    <p class="font-bold text-[16px] flex justify-center mt-2">Stap 4 van 4</p>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-50 w-[500px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 20%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px] overflow-y-auto" style="height: 80%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px] cursor-pointer" style="color: #ffffff;" id="close2"></i>
                    <form action="" method="get">
                        <input type="text" placeholder="Zoek plant" name="search" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px] mt-[12px]">
                    </form>
                    <div class="flex flex-wrap justify-center mt-[32px]">
                        <?php foreach ($plants as $plant) : ?>
                            <div class="mr-[24px] mb-[24px]">
                                <form action="" method="post">
                                    <button type="submit" name="btn" value="<?php echo $plant['name'] ?>">
                                        <div class="pt-[8px] cursor-pointer">
                                            <div class="h-[96px] w-[96px] bg-black flex justify-center items-center"></div>
                                            <p class="pt-1 text-[16px] font-medium text-white max-w-[96px] break-all text-left"><?php echo wordwrap($plant['name'], 10, '-') ?></p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach ?>
                    </div>
                </section>
            </section>
        </section>
    </div>
</body>
</body>

</html>