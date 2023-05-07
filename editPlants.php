<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $user_id = $_SESSION['id']['id'];
    $moestuin_id = $_GET['id'];

    $details = Moestuin::getDetailsById($moestuin_id);

    $name = $details['name'];
    $moestuin_id = $details['id'];

    $plants = Moestuin::getAllPlants($user_id, $moestuin_id);

    $user = new User();
    $user->setId($user_id);

    $searchTerm = $_GET['q'] ?? null;

    if ($searchTerm != null) {
        $state = 'search';
    } else {
        $state = 'all';
    }

    $allPlants = Plant::getAll($searchTerm);

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
    <script src="js/overlay.js" defer></script>
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
                <h1 class="font-bold text-[26px] text-center mb-[12px]"> <?php echo htmlspecialchars($name) ?> </h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px] bg-[#739B72] flex flex-col justify-between border-[8px] border-dashed" style="border-color: <?php echo $border ?>;"">
                        <div class="flex-grow-1 max-h-[400px] overflow-y-auto ml-[26px] md:ml-[18px] lg:ml-[8px]">
                            <h2 class="font-regular text-[18px] text-white ml-[24px] mt-[24px]">Planten</h2>
                            <div class="flex flex-wrap ml-[24px]">
                                <?php foreach ($plants as $plant) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deletePlant" value="<?php echo $plant['name'] ?>">
                                                    <div class="relative bottom-[7px] left-[73px] z-10"><i class="fa-solid fa-circle-minus text-white"></i></div>
                                                </button>
                                                <div class="h-[82px] w-[82px] relative bottom-[20px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($newPlants as $plant) : ?>
                                    <div class="mr-[12px]">
                                        <form action="" method="post">
                                            <div>
                                                <button class="text-right" name="deleteNewPlant" value="<?php echo $plant ?>">
                                                    <div class="relative top-[12px] left-[88px]"><i class="fa-solid fa-circle-minus text-red-600"></i></div>
                                                </button>
                                                <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
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
                            <a class="h-[48px] text-center bg-[#81CCDE] mt-[20px] w-[270px] md:w-[365px] lg:w-[458px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] pt-[10px]" href="home.php?id=<?php echo $moestuin_id ?>">GEREED</a>
                            <button class="text-white font-semibold mt-[12px] mb-[20px] text-[12px]">Verwijder moestuin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-50 w-[372px] md:w-[452px] lg:w-[522px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 30%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px] overflow-y-auto" style="height: 70%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px] cursor-pointer" style="color: #ffffff;" id="close2"></i>
                    <form action="" method="get" id="search-form" data-id="<?php echo $state ?>">
                        <input type="hidden" name="id" value="<?php echo $moestuin_id ?>">
                        <input type="text" placeholder="Zoek plant" name="q" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px] mt-[12px]">
                    </form>
                    <div class="flex flex-wrap justify-center mt-[32px]">
                        <?php if (empty($allPlants)) : ?>
                            <p class="text-white font-bold text-[18px]">Geen planten gevonden.</p>
                        <?php endif ?>
                        <?php foreach ($allPlants as $plant) : ?>
                            <div class="mr-[12px] mb-[12px]">
                                <form action="" method="post">
                                    <button type="submit" name="btn" value="<?php echo $plant['name'] ?>">
                                        <div class="pt-[8px] cursor-pointer">
                                            <div class="h-[82px] w-[82px] bg-[#5C7C5B] flex justify-center items-center border-2 rounded-lg border-[#496048]"><img class="w-[55px]" src="uploads/<?php echo $plant['cover_url'] ?>" alt="<?php echo $plant['name'] ?>"></div>
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