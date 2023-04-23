<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $name = $_SESSION['name'];
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
                            <h2 class="font-bold text-[20px] text-white ml-[24px] mt-[8px]">Voeg je sensoren toe</h2>
                            <div class="mt-[12px] mx-[24px]">
                                <div>
                                    <div class="h-[60px] w-[60px] bg-black flex justify-center items-center" id="add"><i class="fa-solid fa-plus fa-xl" style="color: #ffffff;"></i></div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" class="flex flex-col items-center">
                            <input type="submit" value="VOLGENDE" id="name" class="h-[48px] bg-[#81CCDE] w-[265px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
                        </form>
                    </div>
                    <p class="font-bold text-[16px] flex justify-center mt-2">Stap 3 van 4</p>
                </div>
            </div>
        </div>
        <section class="flex justify-center items-center" style="height: 100%;">
            <section id="add-section" class="hidden z-50 w-[500px]" style="height: 100%;">
                <section class="flex justify-center items-center" style="height: 20%;" id="close"></section>
                <section class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px]" style="height: 80%">
                    <i class="fa-solid fa-arrow-left fa-lg pt-[32px]" style="color: #ffffff;" id="close2"></i>
                    <h3 class="font-bold text-[24px] text-white pt-[px]">Jouw sensoren</h3>
                    <div>
                        <a href="winkel.php">
                            <div class="pt-[8px]">
                                <div class="h-[88px] w-[88px] bg-black flex justify-center items-center"><i class="fa-solid fa-plus fa-2xl" style="color: #ffffff;"></i></div>
                                <p class="pt-1 text-[16px] font-medium text-white">Voeg toe</p>
                            </div>
                        </a>
                    </div>
                </section>
            </section>
        </section>
    </div>
</body>

</html>