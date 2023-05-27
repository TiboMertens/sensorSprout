<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $name = $_SESSION['name'];

    $searchTerm = $_GET['q'] ?? null;
    $notSerre = false;

    if ($searchTerm != null) {
        $state = 'search';
    } else {
        $state = 'all';
    }

    $plants = Plant::getAll($searchTerm);

    // initialize the selected sensors array if it doesn't exist in the session
    if (!isset($_SESSION['selectedPlants'])) {
        $_SESSION['selectedPlants'] = array();
    }

    // add the clicked button value to the selected sensors array
    if (isset($_POST['btn'])) {
        if ($_SESSION['serre'] == 0) {
            array_push($_SESSION['selectedPlants'], $_POST['btn']);
            $clicked = 'clicked';
            //select the plant with the name from the btn post
            $plantCheck = Plant::getPlant($_POST['btn']);
            if ($plantCheck['serre'] == 1) {
                $notSerre = true;
            }
        } else {
            array_push($_SESSION['selectedPlants'], $_POST['btn']);
            $clicked = 'clicked';
        }
    }

    if (isset($_POST['dontPlant'])) {
        //delete the most recent item
        array_pop($_SESSION['selectedPlants']);
        $notSerre = false;
        //empty the $_POST dontPlant
        $_POST['dontPlant'] = '';
    }
    if (isset($_POST['doPlant'])) {
        $clicked = 'clicked';
        $notSerre = false;
        //empty the $_POST doPlant
        $_POST['doPlant'] = '';
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
    }

    if ($_SESSION['serre'] == 1) {
        $border = '#81CCDE';
    } else {
        $border = '#496149';
    }
} else {
    header('Location: index.php');
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
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <script src="js/overlay.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]">
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
    <div id="container" class="mt-[32px]" style="height: 100%">
        <div id="container2" class="">
            <div>
                <h1 class="font-bold text-[26px] mb-2 mt-[100px]"><?php echo htmlspecialchars($name) ?></h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[822px] h-[520px] bg-[#739B72] flex flex-col justify-between border-[8px] rounded-lg border-dashed" style="border-color: <?php echo $border ?>;">
                        <div class="flex-grow-1 max-h-[400px] overflow-y-auto ml-[20px] md:ml-[10px] lg:ml-[0px]">
                            <h2 class="font-regular text-[18px] text-white ml-[24px] mt-[8px]" style="font-family: Yeseva One;">Geselecteerde sensoren</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($selectedSensors as $sensor) : ?>
                                    <div class="mr-[12px] mt-[12px]">
                                        <form action="" method="post">
                                            <div class="h-[32px] w-[32px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-md border-[#496048]">
                                                <p class="text-[12px]" style="font-family: Yeseva One;"><?php echo $sensor ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <h2 class="font-regular text-[18px] text-white ml-[24px] my-[12px]" style="font-family: Yeseva One;">Voeg je planten toe</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($selectedPlants as $plant) : ?>
                                    <div class="mr-[12px] mt-[12px]">
                                        <form action="" method="post">
                                            <div class="pt-[8px]">
                                                <div class="h-[82px] w-[82px] relative bottom-[20px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant ?>.svg" alt="<?php echo $plant ?>"></div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <div class="">
                                    <div>
                                        <div class="h-[82px] w-[82px] bg-white flex justify-center border-2 rounded-lg border-[#496048] items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #000000;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="SAVE" name="save" id="save" class="h-[48px] text-center bg-[#81CCDE] mt-[20px] w-[270px] md:w-[370px] lg:w-[458px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] pt-[2px] mb-[32px]">
                        </form>
                    </div>
                    <p class="font-bold text-[16px] flex justify-center mt-2">4 van 4</p>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-30 w-[372px] md:w-[452px] lg:w-[822px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 30%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px] overflow-y-auto" style="height: 60%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px] cursor-pointer" style="color: #ffffff;" id="close2"></i>
                    <form action="" method="get" id="search-form" data-id="<?php echo $state ?>">
                        <input type="hidden" name="id" value="<?php echo $moestuin_id ?>">
                        <input type="text" placeholder="Zoek plant" name="q" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px] mt-[12px]">
                    </form>
                    <div class="flex flex-wrap justify-center mt-[32px] pb-[300px]">
                        <?php if (empty($plants)) : ?>
                            <p class="text-white font-bold text-[18px]">Geen planten gevonden.</p>
                        <?php endif ?>
                        <?php foreach ($plants as $plant) : ?>
                            <div class="mr-[12px] mb-[12px]">
                                <form action="" method="post">
                                    <button type="submit" name="btn" value="<?php echo $plant['name'] ?>">
                                        <div class="pt-[8px] cursor-pointer">
                                            <div id="addProduct" data-id="<?php echo $clicked ?>" class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach ?>
                    </div>
                </section>
            </section>
        </section>
        <?php if ($notSerre == true) : ?>
            <div id="emptyPopup" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-[#E9E9E9] p-8 rounded shadow-md text-center w-[30%]">
                    <form action="" method="post" class="">
                        <h2 class="text-lg font-bold mb-4 text-black">We raden aan een serre te gebruiken voor deze plant.</h2>
                        <!-- add close button -->
                        <div class="flex gap-5">
                            <button name="dontPlant" class="closePopup bg-[#81CCDE] hover:bg-[#75c4d8] text-white font-bold py-2 w-full rounded mb-2">Niet planten</button>
                            <button name="doPlant" class="closePopup bg-[#81CCDE] hover:bg-[#75c4d8] text-white font-bold py-2 w-full rounded mb-2">Toch planten</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif ?>
    </div>
    <script src="js/hamburger.js"></script>
    <script>
        const addButton = document.getElementById("add");
        const add = document.getElementById("addProduct");
        const closeButton = document.getElementById("close");
        const closeButton2 = document.getElementById("close2");
        const form = document.getElementById("search-form");

        let state = add.getAttribute("data-id");

        addButton.addEventListener("click", () => {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        closeButton.addEventListener("click", () => {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        closeButton2.addEventListener("click", () => {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        });

        //get the form state
        const formState = form.getAttribute("data-id");

        if (formState == "search") {
            const hiddenSection = document.querySelector("#add-section");
            hiddenSection.classList.toggle("hidden");
        }
    </script>
</body>
</body>

</html>