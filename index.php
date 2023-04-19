<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");
if (!empty($_POST)) {
    $user = new User();
    $user->setLanguage($_POST['taal']);
    header("Location: register.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kies taal</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>
<style>
    html {
        height: 100%;
        /* Fallback CSS for IE 4-6 and older browsers. Note: Without this setting, body below cannot achieve 100% height. */
        height: 100vh;
        /* Overrides 100% height in modern HTML5 browsers and uses the viewport's height. Only works in modern HTML5 browsers */
    }

    body {
        height: auto;
        /* Allows content to grow beyond the page without overflow */
        width: auto;
        /* Allows content to grow beyond the page without overflow */
        min-height: 100%;
        /* Starts web page with 100% height. Fallback for IE 4-6 and older browsers */
        min-height: 100vh;
        /* Starts web page with 100% height. Uses the viewport's height. Only works in modern HTML5 browsers */
        overflow-y: scroll;
        /* Optional: Adds an empty scrollbar to the right margin in case content grows vertically, creating a scrollbar.  Allows for better width calculations, as the browser pre-calculates width before scrollbar appears, avoiding page content shifting.*/
        margin: 0;
        padding: 0;
    }

    input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        border-radius: 50%;
        border: 0px solid #FFF;
        background: #F5F3F3;
        /* The outline will be the outer circle */
        outline: 1px solid #81CCDE;
    }

    input[type="radio"]:checked {
        border: 3px solid #FFF;
        background: #81CCDE;
    }
</style>

<body class="bg-[#F5F3F3] ml-auto mr-auto max-w-[500px]" style="height: 100%;">
    <section class="flex justify-center items-center" style="height:35%">
        <p>LOGO</p>
    </section>
    <main class="bg-[#A5CF93] rounded-t-[30px] pl-[24px]" style="height: 65%">
        <h1 class="text-[26px] text-white pt-[44px]">Selecteer uw taal</h1>
        <div class="text-white text-[20px]">
            <form action="#" method="post">
                <!-- 3 radio buttons with the values 'nederlands' 'français' 'deutsch' -->
                <div class="flex items-center mt-[14px]">
                    <input type="radio" id="nederlands" name="taal" class="h-4 w-4">
                    <label for="nederlands" class="ml-2">Nederlands</label>
                </div>
                <div class="flex items-center mt-[14px]">
                    <input type="radio" name="taal" value="français" id="français" class="h-4 w-4">
                    <label for="français" class="ml-2">Français</label>
                </div>
                <div class="flex items-center mt-[14px]">
                    <input type="radio" name="taal" value="deutsch" id="deutsch" class="h-4 w-4">
                    <label for="deutsch" class="ml-2">Deutsch</label>
                </div>
                <div class="mr-[24px] mt-[32px]">
                    <input type="submit" value="GA VERDER" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] tracking-[2px]">
                </div>
            </form>
        </div>
    </main>
</body>


</html>