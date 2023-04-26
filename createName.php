<?php
include_once("bootstrap.php");

if (isset($_SESSION['loggedin'])) {
    if (!empty($_POST)) {
        try {
            if (!empty($_POST['name'])) {
                $name = $_POST['name'];
                $_SESSION['name'] = $name;
                header("Location: createSerre.php");
            } else {
                throw new Exception("Name can't be empty");
            }
        } catch (throwable $e) {
            $error = $e->getMessage();
        }
    }
} else {
    header("Location: login.php");
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
    <div id="container" class="bg-[#F5F3F3]">
        <div id="container2" class="">
            <div>
                <h1 class="font-bold text-[26px] mb-2">Naamgeving</h1>
                <div>
                    <div class="w-[372px] md:w-[452px] lg:w-[522px] h-[520px] flex flex-col justify-center items-center bg-[#808080]">
                        <form action="" method="post">
                            <label for="name" class="text-white flex text-left ">
                                Naam van uw moestuin:
                            </label>
                            <input type="text" name="name" class="pl-[32px] font-bold w-[265px] md:w-[325px] lg:w-[385px] text-black h-[48px] rounded-[5px] text-[16px] block mx-auto mt-2">
                            <!-- If there is an error, show it -->
                            <?php if (isset($error)) : ?>
                                <p class="text-red-500 text-xs italic"><?php echo $error; ?></p>
                            <?php endif; ?>
                            <input type="submit" value="VOLGENDE" id="name" class="h-[48px] bg-[#81CCDE] w-[265px] md:w-[325px] lg:w-[385px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px] mt-3">
                        </form>
                    </div>
                    <p class="font-bold text-[16px] flex justify-center mt-2">Stap 1 van 4</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>