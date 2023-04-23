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
    <link rel="stylesheet" href="css/create.css">
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <script src="js/create.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>
<style>

</style>

<body>
    <div id="container" class="bg-[#F5F3F3]">
        <div id="container2">
            <a href="createName.php"><input type="submit" id="create" value="CREËER UW MOESTUIN" class="h-[48px] bg-[#81CCDE] w-[342px] rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px]"></a>
        </div>
    </div>
</body>

</html>