<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $sensors = Sensor::getAllSensors();
    $packets = Sensor::getAllPackets();
    $count = 1;
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
    <title>Winkel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F7F7F7]">
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
    <div class="flex items-center justify-center mt-[32px]">
        <a href="home.php?id=<?php echo $moestuin_id ?>"><i class="fa-solid fa-arrow-left fa-xl mr-2"></i></a>
        <h1 class="text-center my-[36px] text-[26px] lg:text-[28px] font-semibold">Winkel</h1>
    </div>
    <section class="mb-5 ml-[42px]">
        <h2 class="text-[20px] text-black mb-4">Individuele sensoren</h2>
        <div class="flex flex-shrink-0 gap-5 overflow-y-auto">
            <?php foreach ($sensors as $sensor) : ?>
                <div class="">
                    <a href="#">
                        <div class="bg-[#E9E9E9] h-[150px] w-[150px] flex justify-center items-center rounded-lg">
                            <img src="uploads/<?php echo htmlspecialchars($sensor['cover_url']); ?>" alt="prompt" class="flex justify-center items-center object-cover object-center rounded-lg">
                        </div>
                        <h3 class="text-black font-semibold text-[14px] mt-2"><?php echo htmlspecialchars($sensor['name']) ?></h3>
                        <p class="font-light text-[12px]"><?php echo "€" .  $sensor['price'] ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="mb-5 ml-[42px]">
        <h2 class="text-[20px] text-black mb-4">Paketten</h2>
        <div class="flex flex-shrink-0 gap-5">
            <?php foreach ($packets as $packet) : ?>
                <a href="sensorDetails.php?id=<?php echo htmlspecialchars($count++) ?>&packet=true">
                    <div class="bg-[#E9E9E9] h-[150px] w-[150px] flex justify-center items-center rounded-lg">
                        <img src="uploads/<?php echo htmlspecialchars($packet['cover_url']); ?>" alt="prompt" class="object-cover object-center rounded-lg">
                    </div>
                    <h3 class="text-black font-semibold text-[14px] mt-2"><?php echo htmlspecialchars($packet['name']) ?></h3>
                    <p class="font-light text-[12px]"><?php echo "€" .  $packet['price'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <form action="" method="post" class="flex flex-col items-center">
        <input type="submit" value="WINKELMAND" name="volgende" id="name" class="h-[48px] bg-[#81CCDE] w-[430px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
    </form>
    <script src="js/hamburger.js"></script>
</body>

</html>