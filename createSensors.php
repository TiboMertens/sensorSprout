<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $name = $_SESSION['name'];
    $user_id = $_SESSION['id']['id'];
    $user = new User();
    $user->setId($user_id);
    $sensors = $user->getSensors();
    $empty = false;

    // initialize the selected sensors array if it doesn't exist in the session
    if (!isset($_SESSION['selectedSensors'])) {
        $_SESSION['selectedSensors'] = array();
    }

    // add the clicked button value to the selected sensors array
    if (isset($_POST['btn'])) {
        array_push($_SESSION['selectedSensors'], $_POST['btn']);
    }

    // get the current contents of the selected sensors array
    $selectedSensors = $_SESSION['selectedSensors'];

    if (!empty($_POST['volgende'])) {
        if (empty($selectedSensors)) {
            $empty = true;
        } else {
            header('Location: createPlants.php');
            exit;
        }
    }

    if (!empty($_POST['closePopup'])) {
        //empty the $_POST volgende
        $_POST['volgende'] = '';
        $empty = false;
    } 

    if (isset($_POST['koop'])) {
        header('Location: winkel.php');
        exit;
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]">
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
    <div id="container" class="mt-[32px]" style="height: 100%">
        <div id="container2" class="">
            <div>
                <h1 class="font-regular text-[26px] mb-2 mt-[100px]"><?php echo htmlspecialchars($name) ?></h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[822px] h-[520px] bg-[#739B72] flex flex-col justify-between border-[8px] rounded-lg border-dashed" style="border-color: <?php echo $border ?>;">
                        <div class="flex-grow-1 max-h-[400px] overflow-y-auto ml-[18px] md:ml-[18px] lg:ml-[8px]">
                            <h2 class="font-regular text-[20px] text-white ml-[24px] mt-[12px] mb-[12px]">Voeg je sensoren toe</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($selectedSensors as $sensor) : ?>
                                    <div class="mr-[12px] mt-[12px]">
                                        <form action="" method="post">
                                            <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]">
                                                <p class="text-[20px]" style="font-family: Yeseva One;"><?php echo $sensor ?></p>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>

                                <div class="mt-[12px]">
                                    <div id="addProduct">
                                        <div class="h-[82px] w-[82px] bg-white flex justify-center border-2 rounded-lg border-[#496048] items-center cursor-pointer" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #000000;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="VOLGENDE" name="volgende" id="name" class="h-[48px] text-center bg-[#81CCDE] my-[20px] w-[270px] md:w-[365px] lg:w-[458px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] pt-[4px]">
                        </form>
                    </div>
                    <p class="font-regular text-[16px] flex justify-center mt-2">3 van 4</p>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-30 w-[372px] md:w-[452px] lg:w-[822px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 20%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px]" style="height: 80%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px] cursor-pointer" style="color: #ffffff;" id="close2"></i>
                    <h3 class="font-bold text-[24px] text-white pt-[8px]">Jouw sensoren</h3>
                    <div class="flex flex-wrap">
                        <?php foreach ($sensors as $sensor) : ?>
                            <div class="mr-[12px] mb-[6px] mt-[24px]">
                                <form action="" method="post" data-id="<?php echo $state ?>">
                                    <button type="submit" name="btn" value="<?php echo $sensor['short_name'] ?>">
                                        <div class="pt-[8px] cursor-pointer">
                                            <div id="addProduct" data-id="<?php echo $clicked ?>" class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]">
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
                    <form action="" method="post" class="pt-[300px]">
                        <input type="submit" value="KOOP SENSOR" name="koop" id="koop" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px] mt-[24px]">
                    </form>
                </section>
            </section>
        </section>
        <?php if ($empty == true): ?>
            <div id="emptyPopup" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-[#E9E9E9] p-8 rounded shadow-md text-center w-[20%]">
                <form action="" method="post" class="">
                    <h2 class="text-lg font-bold mb-4 text-black">Zonder sensoren kunt u de app niet gebruiken.</h2>
                    <!-- add close button -->
                    <div class="flex gap-5">
                        <button name="closePopup" class="closePopup bg-[#81CCDE] hover:bg-[#75c4d8] text-white font-bold py-2 w-full rounded mb-2">Oke</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif ?>
    </div>
    <script>
        //get element w id addProduct
        const addButton = document.getElementById("addProduct");
        const closeButton = document.getElementById("close");
        const closeButton2 = document.getElementById("close2");

        addButton.addEventListener("click", () => {
            console.log("clicked");
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

        // get the hamburger id
        const hamburger = document.getElementById("hamburger");
        //get the menu id
        const menu = document.getElementById("menu");

        //add event listener to the hamburger
        hamburger.addEventListener("click", () => {
            //toggle the active class to the menu
            //rotate the hamburger 90 degrees
            hamburger.classList.toggle("rotate");
            menu.classList.toggle("hidden");
        });
    </script>
</body>

</html>