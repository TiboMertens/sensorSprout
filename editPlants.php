<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $user_id = $_SESSION['id']['id'];

    $details = Moestuin::getDetails($user_id);

    if (isset($_GET['id'])) {
        $counter = intval($_GET['id']);
    } else {
        $counter = 0;
    }

    if ($counter < 0) {
        $counter = 0;
    }

    $name = $details[$counter]['name'];
    $moestuin_id = $details[$counter]['id'];

    $plants = Moestuin::getAllPlants($user_id, $moestuin_id);

    $user = new User();
    $user->setId($user_id);

    $allPlants = Plant::getAll();

    //if deletePlant is clicked, delete the plant from the $plants variable
    if (isset($_POST['deletePlant'])) {
        $key = array_search($_POST['deletePlant'], $plants);
        unset($plants[$key]);
        //delete the plant from the database
        $moestuin = new Moestuin();
        $moestuin->deletePlant($_POST['deletePlant'], $moestuin_id);
    }

    $newPlants = array();

    // initialize the selected plants array if it doesn't exist in the session
    if (!isset($_SESSION['selectedPlants'])) {
        $_SESSION['selectedPlants'] = array();
    }

    // add the clicked button value to the selected plants array
    if (isset($_POST['btn'])) {
        array_push($_SESSION['selectedPlants'], $_POST['btn']);
    }

    //if deleteNewPlant button is clicked, delete the plants from the newPlants array
    if (isset($_POST['deleteNewPlant'])) {
        $key = array_search($_POST['deleteNewPlant'], $_SESSION['selectedPlants']);
        unset($_SESSION['selectedPlants'][$key]);
    }

    $newPlants = $_SESSION['selectedPlants'];

    if (!empty($_POST['save'])) {
        $moestuin = new Moestuin();
        $moestuin->setPlants($newPlants);
        $moestuin->addPlants($moestuin_id);
        //set the selected plants array to empty
        $_SESSION['selectedPlants'] = array();
        header('Location: home.php?id=' . $counter);
    }

    //if the delete button is clicked, delete the moestuin
    if (isset($_POST['delete'])) {
        $moestuin = new Moestuin();
        $moestuin->delete($moestuin_id);
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
    <title>pas je moestuin aan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <script src="js/overlay.js" defer></script>
    <link rel="stylesheet" href="css/create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]" >
    <div id="container" style="height: 100%">
        <div id="container2" class="">
            <div>
                <h1 class="font-bold text-[26px] mb-2 text-center"> <?php echo htmlspecialchars($name) ?> </h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px] bg-[#808080] flex flex-col justify-between">
                        <div class="flex-grow-1">
                            <h2 class="font-bold text-[20px] text-white ml-[24px] mt-[8px]">Planten</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($plants as $plant) : ?>
                                    <div class="mr-[24px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deletePlant" value="<?php echo $plant['name'] ?>">
                                                    <div class="relative top-[12px] left-[88px]"><i class="fa-solid fa-circle-minus text-red-600"></i></div>
                                                </button>
                                                <div class="h-[96px] w-[96px] bg-black flex justify-center items-center"></div>
                                                <p class="pt-1 text-[16px] font-medium text-white max-w-[96px] break-all text-left"><?php echo wordwrap($plant['name'], 10, '-') ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($newPlants as $plant) : ?>
                                    <div class="mr-[24px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deleteNewPlant" value="<?php echo $plant ?>">
                                                    <div class="relative top-[12px] left-[88px]"><i class="fa-solid fa-circle-minus text-red-600"></i></div>
                                                </button>
                                                <div class="h-[96px] w-[96px] bg-black flex justify-center items-center"></div>
                                                <p class="pt-1 text-[16px] font-medium text-white max-w-[96px] break-all text-left"><?php echo wordwrap($plant, 10, '-') ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <div class="mt-[24px]">
                                    <div>
                                        <div class="h-[96px] w-[96px] bg-black flex justify-center items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #ffffff;"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="GEREED" name="save" id="gereed" class="h-[48px] bg-[#81CCDE] w-[324px] md:w-[404px] lg:w-[472px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[12px]">
                            <input type="submit" value="verwijder moestuin" name="delete" id="verwijderen" class="mb-[14px] text-red-600 font-semibold hover:text-red-800 cursor-pointer">
                        </form>
                    </div>
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
                        <?php foreach ($allPlants as $plant) : ?>
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
</body>

</html>