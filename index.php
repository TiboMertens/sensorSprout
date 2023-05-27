<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

if (!empty($_GET['qr_code'])) {
    $qr_code = $_GET['qr_code'];
    $sensor = Sensor::getSensorByQrCode($qr_code);

    $sensor = $sensor['id'];
    
}

if (!empty($_POST)) {
    //get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //create a new user object
    $user = new User();
    if (!empty($sensor)) {
        $user->setSensor($sensor);
    }

    //check if the user can login
    try {
        $result = $user->canLogin($username, $password);
        //if the user can login, redirect to the index page
        if ($result === true) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user->getId($username);

            header("Location: home.php");
            return;
        }
    } catch (throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hamburger.css">
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
</style>

<body class="bg-[#F5F3F3]" style="height: 100%;">
    <div class="absolute inset-0 flex items-center justify-center ">
        <div class="max-w-[500px]">
            <main class="bg-[#A5CF93] rounded-t-[5px] pl-[24px] pr-[24px] w-[400px]" style="height: 70%">
                <form action="" method="post">
                    <h1 class="text-[26px] text-white pt-[44px]">Log in</h1>
                    <div class="text-white text-[20px]">
                        <div class="mt-[16px]">
                            <input type="text" placeholder="Gebruikersnaam" name="username" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px]">
                        </div>
                        <div class="mt-[32px]">
                            <input type="password" placeholder="Wachtwoord" name="password" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px]">
                            <a href="forgotPassword.php" class="block italic text-xs mt-1 underline text-black text-right hover:text-[#ffffff]">Forgot password?</a>
                        </div>
                    </div>
                    <!-- If there is an error, show it -->
                    <?php if (isset($error)) : ?>
                        <p class="text-red-500 text-xs italic"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <div class="mt-[32px]">
                        <input type="submit" value="LOG IN" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px]">
                    </div>
                    <div class="flex justify-center items-center text-xs mt-[32px] pb-10">
                        <p class="text-center">Heeft u nog geen account? </br><a href="register.php"><span class="underline font-bold hover:text-white">Registreer u</span></a></p>
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>

</html>