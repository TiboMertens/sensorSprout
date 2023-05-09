<div style="width: 100vw;">
    <nav class="w-full h-[64px] flex justify-between items-center">
        <div class="flex justify-start ml-5 relative top-[2px]">
            <a href="home.php"><img src="uploads/logo.svg" alt="logo"></a>
        </div>
        <div class="flex justify-end mr-5 font-bold text-[#A5CF93] md:block hidden">
            <a href="home.php" class="mr-7 text-[20px]" style="font-family: Lato;">Moestuin</a>
            <a href="#" class="mr-7 text-[20px]" style="font-family: Lato;">Klimaat</a>
            <a href="shop.php" class="mr-7 text-[20px]" style="font-family: Lato;">Winkel</a>
            <a href="ToDo.php" class="mr-7 text-[20px]" style="font-family: Lato;">ToDo</a>
            <a href="#" class="text-[20px]" style="font-family: Lato;">Instellingen</a>
        </div>
        <div class="md:hidden block" id="hamburger">
            <button type="button" class="text-[20px] font-bold text-[#A5CF93] focus:outline-none mr-5">
                <i class="fa-solid fa-bars fa-xl"></i>
            </button>
        </div>
    </nav>
    <div class="hidden absolute w-full z-50 md:hidden" id="menu">
        <!-- menu items go here -->
        <a href="home.php" class="block py-2 px-4 bg-white text-black font-bold">Moestuin</a>
        <a href="#" class="block py-2 px-4 bg-white text-black font-bold">Klimaat</a>
        <a href="shop.php" class="block py-2 px-4 bg-white text-black font-bold">Winkel</a>
        <a href="ToDo.php" class="block py-2 px-4 bg-white text-black font-bold">ToDo</a>
        <a href="#" class="block pt-2 pb-4 px-4 bg-white text-black font-bold">Instellingen</a>
    </div>
</div>