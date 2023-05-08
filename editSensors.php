<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $user_id = $_SESSION['id']['id'];
    $moestuin_id = $_GET['id'];

    $details = Moestuin::getDetailsById($moestuin_id);

    //get the name from the details where the id is equal to the counter
    $name = $details['name'];

    $sensors = Moestuin::getAllSensors($user_id, $moestuin_id);

    $user = new User();
    $user->setId($user_id);
    $ownedSensors = $user->getSensors();

    //if deleteSensor is clicked, delete the sensor from the $sensors variable
    if (isset($_POST['deleteSensor'])) {
        $key = array_search($_POST['deleteSensor'], $sensors);
        unset($sensors[$key]);
        //delete the sensor from the database
        $moestuin = new Moestuin();
        var_dump($moestuin->deleteSensor($_POST['deleteSensor'], $moestuin_id));
    }

    $newSensors = array();

    // initialize the selected sensors array if it doesn't exist in the session
    if (!isset($_SESSION['selectedSensors'])) {
        $_SESSION['selectedSensors'] = array();
    }

    // add the clicked button value to the selected sensors array
    if (isset($_POST['btn'])) {
        array_push($_SESSION['selectedSensors'], $_POST['btn']);
    }

    //if deleteNewSensor button is clicked, delete the sensor from the newSensors array
    if (isset($_POST['deleteNewSensor'])) {
        $key = array_search($_POST['deleteNewSensor'], $_SESSION['selectedSensors']);
        unset($_SESSION['selectedSensors'][$key]);
    }

    $newSensors = $_SESSION['selectedSensors'];

    if (isset($_POST['save'])) {
        $moestuin = new Moestuin();
        $moestuin->setSensors($newSensors);
        $moestuin->addSensors($moestuin_id);
        //set the selected sensors array to empty
        $_SESSION['selectedSensors'] = array();
        header('Location: home.php?id=' . $moestuin_id);
    }

    //if the delete button is clicked, delete the moestuin
    if (isset($_POST['delete'])) {
        $moestuin = new Moestuin();
        $moestuin->delete($moestuin_id);
        header('Location: home.php');
    }

    if ($details['is_serre'] == 1) {
        $border = '#81CCDE';
    } else {
        $border = '#496149';
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
    <link rel="stylesheet" href="css/create.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]">
    <div id="container" style="height: 100%">
        <div id="container2" class="">
            <div>
                <h1 class="font-regular text-[26px] mb-2 text-center"> <?php echo htmlspecialchars($name) ?> </h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px] bg-[#739B72] flex flex-col justify-between border-[8px] rounded-lg border-dashed" style="border-color: <?php echo $border ?>;">
                        <div class="flex-grow-1 max-h-[400px] overflow-y-auto ml-[18px] md:ml-[18px] lg:ml-[8px]">
                            <h2 class="font-regular text-[20px] text-white ml-[24px] mt-[12px] mb-[12px]">Sensoren</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($sensors as $sensor) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deleteSensor" value="<?php echo $sensor['name'] ?>">
                                                    <div class="relative bottom-[7px] left-[73px] z-10"><i class="fa-solid fa-circle-minus text-white"></i></div>
                                                </button>
                                                <div class="h-[82px] w-[82px] relative bottom-[20px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]">
                                                    <p class="text-[20px]" style="font-family: Yeseva One;"><?php echo $sensor['short_name'] ?></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($newSensors as $sensor) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deleteNewSensor" value="<?php echo $sensor ?>">
                                                    <div class="relative bottom-[7px] left-[73px] z-10"><i class="fa-solid fa-circle-minus text-white"></i></div>
                                                </button>
                                                <div class="h-[82px] w-[82px] relative bottom-[20px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]">
                                                    <p class="text-[20px]" style="font-family: Yeseva One;"><?php echo $sensor ?></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <div class="mt-[4px]">
                                    <div>
                                        <div class="h-[82px] w-[82px] bg-white flex justify-center border-2 rounded-lg border-[#496048] items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #000000;"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <button name="save" class="h-[48px] text-center bg-[#81CCDE] mt-[20px] w-[270px] md:w-[365px] lg:w-[458px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] pt-[10px]" href="home.php?id=<?php echo $moestuin_id ?>">GEREED</button>
                            <button name="delete" class="text-white font-semibold mt-[12px] mb-[20px] text-[12px]">Verwijder moestuin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-50 w-[372px] md:w-[452px] lg:w-[522px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 20%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px]" style="height: 80%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px] cursor-pointer" style="color: #ffffff;" id="close2"></i>
                    <h3 class="font-bold text-[24px] text-white pt-[8px]">Jouw sensoren</h3>
                    <div class="flex flex-wrap">
                        <?php foreach ($ownedSensors as $sensor) : ?>
                            <div class="mr-[12px] mb-[6px] mt-[24px]">
                                <form action="" method="post">
                                    <button type="submit" name="btn" value="<?php echo $sensor['short_name'] ?>">
                                        <div class="pt-[8px] cursor-pointer">
                                            <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]">
                                                <p><?php echo $sensor['short_name'] ?></p>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach ?>
                        <a href="winkel.php" class="mr-[12px] mb-[24px] mt-[24px]">
                            <div class="pt-[8px]">
                                <div class="h-[82px] w-[82px] bg-white flex justify-center border-2 rounded-lg border-[#496048] items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #000000;"></i></div>
                            </div>
                        </a>
                    </div>
                    <form action="" method="post">
                        <input type="submit" value="KOOP SENSOR" name="koop" id="koop" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px] mt-[24px]">
                    </form>
                </section>
            </section>
        </section>
    </div>
    <script>
        const addButton = document.getElementById("add");
        const closeButton = document.getElementById("close");
        const closeButton2 = document.getElementById("close2");
        const form = document.getElementById("search-form");

        addButton.addEventListener("click", () => {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        closeButton.addEventListener("click", () => {
            console.log("clicked");
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        closeButton2.addEventListener("click", () => {
            console.log("clicked");
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        //get the form state
        const formState = form.getAttribute("data-id");
        console.log(formState);

        if (formState == "search") {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        }
    </script>
</body>

</html>