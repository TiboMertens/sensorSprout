<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    try {
        if ($_GET['id'] == null || $_GET['id'] == "" || !is_numeric($_GET['id']) || $_GET['id'] < 1 || $_GET['id'] >= 3) {
            throw new Exception("Onjuist packet id");
        } else {
            $packetDetails = Sensor::getPacketDetails();
            $sensorDetails = Sensor::getSensorDetailsFromPacket();

            $title = $packetDetails['name'];
            $description = $packetDetails['description'];
            $price = $packetDetails['price'];
            $cover_url = $packetDetails['cover_url'];

            if (isset(($_POST['sensors']))) {
                $currentFilter = 'sensors';
            } else {
                $currentFilter = 'description';
            }
        }
    } catch (\Throwable $th) {
        $error = $th->getMessage();
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
    <title>Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <?php if (isset($error)) : ?>
        <div class="flex flex-col items-center justify-center h-screen">
            <h1 class="text-center text-[26px] font-bold text-black"><?php echo $error ?></h1>
            <a class="mt-4 text-blue-500 hover:text-blue-700" href="index.php">Go to homepage</a>
        </div>
    <?php else : ?>
        <main class="ml-auto mr-auto max-w-[500px] md:flex md:max-w-[700px] lg:max-w-[900px] xl:max-w-[1100px]">
            <div class="m-5 md:mt-[60px] lg:mt-5 pt-[70px]">
                <div class=""><img src="<?php echo htmlspecialchars($cover_url); ?>" alt="prompt cover" class="rounded-md max-h-[600px] xl:max-h-[500px] xl:w-[700px]"></div>
                <div class="text-[#cccccc] text-[14px] lg:text-[16px]">
                    <h1 class="text-[32px] lg:text-[36px] text-black font-bold mt-2 mb-3"><?php echo htmlspecialchars($title); ?></h1>
                    <form action="#" method="post" class="flex gap-[24px]">
                        <input type="submit" value="BESCHRIJVING" name="description" id="desc" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
                        <input type="submit" value="SENSOREN" name="sensors" id="sensors" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
                    </form>
                    <?php if ($currentFilter == 'description') : ?>
                        <div class="relative">
                            <div class="mr-5 mb-5">
                                <h2 class="font-bold text-black text-[22px] mb-2">Description</h2>
                                <p><?php echo htmlspecialchars($description); ?></p>
                            </div>
                        </div>
                        <div>
                            <h3>Price: &nbsp; € <?php echo htmlspecialchars($price) ?></h3>
                        </div>
                    <?php else : ?>
                        <div class="relative">
                            <div class="mr-5 mb-5">
                                <h2 class="font-bold text-black text-[22px] mb-2">Sensors</h2>
                                <?php foreach ($sensorDetails as $sensor) : ?>
                                    <div class="flex">
                                        <img src="<?php echo htmlspecialchars($sensor['cover_url']); ?>" alt="prompt cover" class="rounded-md w-[150px] h-[150px]">
                                        <div class="max-w-[300px]">
                                            <p class="font-bold text-black"><?php echo htmlspecialchars($sensor['name']); ?></p>
                                            <div class="description">
                                                <p class="truncate line-clamp-2"><?php echo htmlspecialchars($sensor['description']); ?></p>
                                                <button onclick="toggleDescription(event)" class="mt-2 text-black font-bold rounded">Read more</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <h3>Price: &nbsp; € <?php echo htmlspecialchars($price) ?></h3>
                        </div>
                    <?php endif ?>
                    <div>
                        <form action="" method="post">
                            <input type="submit" value="TOEVOEGEN" name="add" id="add" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mb-[32px]">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    <?php endif ?>

    <script>
        function toggleDescription(event) {
            const button = event.target;
            const description = button.previousElementSibling;
            const isExpanded = description.classList.contains('truncate');
            if (isExpanded) {
                description.classList.remove('truncate', 'line-clamp-2');
                button.textContent = 'Read less';
            } else {
                description.classList.add('truncate', 'line-clamp-2');
                button.textContent = 'Read more';
            }
        }
    </script>
</body>

</html>