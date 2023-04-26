<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    $name = $_SESSION['name'];
    if (!empty($_POST)) {
        $serre = $_POST['btn'];
        if ($serre == "JA") {
            $serre = 1;
        } else {
            $serre = 0;
        }
        $_SESSION['serre'] = $serre;
        header("Location: createSensors.php");
    }
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
    <script src="js/create.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F3F3]">
    <div id="container" >
        <div id="container2" class="">
            <div>
                <h1 class="font-bold text-[26px] mb-2"><?php echo htmlspecialchars($name) ?></h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px]  flex flex-col justify-center items-center bg-[#808080]">
                        <h2 class="font-semibold text-[24px] mb-3 text-white">Gebruikt u een serre?</h2>
                        <form action="" method="post">
                            <input type="submit" value="JA" name="btn" class="h-[48px] bg-[#81CCDE] w-[100px] md:w-[125px] lg:w-[175px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mr-3">
                            <input type="submit" value="NEE" name="btn" class="h-[48px] bg-[#81CCDE] w-[100px] md:w-[125px] lg:w-[175px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px]">
                        </form>
                    </div>
                    <p class="font-bold text-[16px] flex justify-center mt-2">Stap 2 van 4</p>
                </div>
            </div>
        </div>
</body>

</html>