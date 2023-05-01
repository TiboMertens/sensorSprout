<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2626c7e45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <section class="max-w-[1024px] mx-auto sm:mt-[70px]">
        <div class="flex items-center justify-center">
            <a href="home.php"><i class="fa-solid fa-arrow-left fa-xl mr-2"></i></a>
            <h1 class="text-center my-[42px] text-[26px] font-semibold">Dashboard</h1>
        </div>
        <div class="flex sm:justify-center">
            <div class="bg-[#E9E9E9] h-[25px] w-[25px] ml-[25px] rounded-sm">
                <div class="relative left-[22px] bottom-[2px] h-[7px] w-[7px] bg-[#FF0000] rounded"></div>
            </div>
        </div>
        <h2 class="text-[22px] text-black ml-5 mt-[16px] sm:text-center">Temperatuursensor</h2>
        <section class="sm:flex">
            <div class="sm:w-1/2">
                <h3 class="text-[20px] text-black ml-5 mt-[24px] mb-[16px]">Live data</h3>
                <div class="ml-5 mr-5 h-[100px] sm:h-[200px] bg-[#A5CF93] rounded-md flex justify-between items-center max-w-[640px]">
                    <div class="text-center w-1/2">
                        <p class="font-bold text-3xl font-serif" style="font-family: 'Yeseva One';">GOED!</p>
                    </div>
                    <div class="text-center w-1/2">
                        <p class="font-bold text-3xl font-serif" style="font-family: 'Yeseva One';">23 °C</p>
                    </div>
                </div>
            </div>
            <div class="sm:w-1/2">
                <h3 class="text-[20px] text-black p-0 ml-5 mb-[16px] mt-[36px] sm:mt-[24px]">Weekoverzicht</h3>
                <div class="mx-5 bg-[#E9E9E9] rounded-md h-[200px] max-w-[640px]"></div>
            </div>
        </section>
    </section>
</body>


</html>