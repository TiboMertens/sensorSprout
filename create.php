<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");
if (!isset($_SESSION['loggedin'])) {
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
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>
<style>
/* Hide horizontal scrollbar for WebKit-based browsers */
::-webkit-scrollbar {
    height: 0px;
    width: 0px;
}

::-webkit-scrollbar-track {
    background-color: transparent;
}

::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
    width: 0;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #aaa;
}
</style>

<body class="bg-[#F5F3F3]" style="height: 100vh;">
    <?php include_once(__DIR__ . "/inc/nav.inc.php"); ?>
        <div class="flex justify-center items-center" style="height: 100vh;">
            <a class="justify-center items-center" href="createName.php"><input type="submit" id="create" value="CREËER UW MOESTUIN" class="h-[48px] bg-[#81CCDE] w-[342px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px]"></a>
        </div>
    <script src="js/hamburger.js"></script>
</body>

</html>