<?php include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");
//get language from session
$language = $_SESSION['language'];

if (!empty($_POST)) {
    try {
        if (!empty($_POST['terms'])) {
            $user = new User();
            $user->setLanguage($language);
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->save();
        
            header("Location: home.php");
        } else {
            throw new Exception("Je moet de gebruikersvoorwaarden accepteren.");
        }
    } catch (Throwable $e) {
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
    <title>Register</title>
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
</style>

<body class="bg-[#F5F3F3] ml-auto mr-auto max-w-[500px]" style="height: 100%;">
    <section class="flex justify-center items-center" style="height:35%">
        <p>LOGO</p>
    </section>
    <main class="bg-[#A5CF93] rounded-t-[30px] pl-[24px] pr-[24px]" style="height: 65%">
        <form action="" method="post">
            <h1 class="text-[26px] text-white pt-[44px]">Registreer u</h1>
            <div class="text-white text-[20px]">
                <div class="mt-[16px]">
                    <input type="text" placeholder="Gebruikersnaam" name="username" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px]">
                </div>
                <div class="mt-[32px]">
                    <input type="text" placeholder="Email" name="email" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px]">
                </div>
                <div class="mt-[32px]">
                    <input type="password" placeholder="Wachtwoord" name="password" class="pl-[32px] font-bold w-full text-black h-[48px] rounded-[5px] text-[16px]">
                </div>
                <div>
                    <input type="checkbox" name="terms" value="terms" class="w-4 h-4 relative top-1">
                    <label for="terms" class="text-xs">Ik ga akkoord met de gebruikersvoorwaarden en privacy wetten</label>
                </div>
            </div>
            <!-- If there is an error, show it -->
            <?php if (isset($error)) : ?>
                <p class="text-red-500 text-xs italic"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="mt-[32px]">
                <input type="submit" value="REGISTREER" class="h-[48px] bg-[#81CCDE] w-full rounded-[5px] hover:bg-[#5EBCD4] font-bold text-[18px] text-white tracking-[2px]">
            </div>
            <div class="flex justify-center items-center text-xs mt-[32px]">
                <p class="text-center">Heeft u al een account? </br><a href="register.php" ><span class="underline font-bold hover:text-white">Log in</span></a></p>
            </div>
        </form>
    </main>
</body>

</html>