<?php
include '../src/functies.php';

// echo $_SESSION['rol'];
// Check if the user is already logged in, if no then redirect him to back to login page

if (!isset($_SESSION["inlog"])) {
    session_destroy();
    header("location: ../index.php");
}
if ($_SESSION["inlog"] != 'true') {
    session_destroy();
    header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantkaart</title>
    <link rel="icon" type="image/x-icon" href="../images/web_logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <style>
        @font-face {
            font-family: Poppins;
            src: url('https://fonts.googleapis.com/css?family=Poppins');
        }

        body {
            font-family: Poppins;
            color: #3d3d3d;
        }
    </style>
    <style>
        .knop {
            background-color: #39b93c;
        }

        .knop:hover {
            background-color: #ed1c24;
        }
    </style>
</head>

<body class="text-gray-700">
    <header class="z-50 bg-white flex flex-col sticky top-0">
        <div class="w-full flex justify-center">
            <a href="../pages/index.php"><img src="../images/header_logo.png" class="h-20 w-96 pl-5"></a>
        </div>
        <div class="w-full border-y border-gray-200">
            <!-- component -->
            <div class="">
                <div class="">
                    <nav class="flex items-center justify-between flex-wrap">
                        <div class="block lg:hidden">
                            <button class="navbar-burger flex items-center px-3 py-2 border-2 rounded text-white border-white hover:text-white hover:border-white flex-col">
                                <svg class="fill-current h-6 w-6 text-gray-700" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <title>Menu</title>
                                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                                </svg>
                            </button>
                        </div>
                        <?php $url = $_SERVER['REQUEST_URI']; ?>
                        <div id="main-nav" class="lg:ml-16 w-full flex-grow flex-col lg:flex items-center lg:w-auto hidden">
                            <ul class="flex justify-center flex-col  lg:flex-row lg:pl-60">
                                <?php if ($_SESSION['rol'] == 1) { ?>

                                    <li class="p-2">
                                        <?php if (strpos($url, 'klanten.php') == true) {  ?>
                                            <a href="../data/klanten.php?page=1" class="text-base text-red-500 font-bold">Gebruikers</a>
                                        <?php } else { ?>
                                            <a href="../data/klanten.php?page=1" class="text-base text-gray-600 font-bold hover:text-red-500 ">Gebruikers</a>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                                <li class="p-2">
                                    <?php if (strpos($url, 'aanbiedingen.php') == true) { ?>
                                        <a href="../data/aanbiedingen.php?page=1" class="text-base text-red-500 font-bold">Aanbiedingen</a>
                                    <?php } else { ?>
                                        <a href="../data/aanbiedingen.php?page=1" class="text-base text-gray-600 font-bold hover:text-red-500 ">Aanbiedingen</a>
                                    <?php } ?>
                                </li>
                                <li class="p-2">
                                    <?php if (strpos($url, 'bestellingen.php') == true) { ?>
                                        <a href="../data/bestellingen.php?page=1" class="text-base text-red-500 font-bold">Bestellingen</a>
                                    <?php } else { ?>
                                        <a href="../data/bestellingen.php?page=1" class="text-base text-gray-600 font-bold hover:text-red-500">Bestellingen</a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <ul id="profiel" class="flex items-center">
                            <?php $id = $_SESSION['id'];
                            $sql = "SELECT * FROM gebruikers WHERE id = $id";
                            $result = db()->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($z = $result->fetch_assoc()) { ?>
                                    <li class="flex justify-center items-center flex-col">
                                        <p class="text-blue-800 font-bold"><?php echo $z['punten'] ?></p>
                                        <p class="text-blue-800 font-bold">megabytes</p>
                                    </li>
                                    <li class="lg:p-2">
                                        <?php if (strpos($url, 'profiel.php') == true || strpos($url, 'profieladmin.php') == true) { ?>
                                            <?php if ($_SESSION['rol'] == 0) { ?>
                                                <a href="../detail/profiel.php" class="text-base text-red-500 font-bold"><?php echo $z['bedrijf'] . "<br>(" . $z['voornaam'] . " " . $z['achternaam'] . ")" ?></a>
                                            <?php } elseif ($_SESSION['rol'] == 1) { ?>
                                                <a href="../detail/profieladmin.php" class="text-base text-red-500 font-bold"><?php echo $z['bedrijf'] . "<br>(" . $z['voornaam'] . " " . $z['achternaam'] . ")" ?></a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($_SESSION['rol'] == 0) { ?>
                                                <a href="../detail/profiel.php" class="text-base text-gray-600 font-bold hover:text-red-500"><?php echo $z['bedrijf'] . "<br>(" . $z['voornaam'] . " " . $z['achternaam'] . ")" ?></a>
                                            <?php } elseif ($_SESSION['rol'] == 1) { ?>
                                                <a href="../detail/profieladmin.php" class="text-base text-gray-600 font-bold hover:text-red-500"><?php echo $z['bedrijf'] . "<br>(" . $z['voornaam'] . " " . $z['achternaam'] . ")" ?></a>
                                            <?php } ?>
                                        <?php } ?>
                                    </li>
                            <?php }
                            } ?>
                            <!-- Modal toggle -->
                            <li data-modal-toggle="uitlog-modal" class="lg:p-2  justify-end flex">
                                <button class="text-base text-gray-600 font-bold hover:text-red-500">Uitloggen</button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </header>
    <!-- Main modal zodat je niet per ongeluk uitlogd -->
    <div id="uitlog-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" data-modal-toggle="uitlog-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center " data-modal-hide="uitlog-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black">weet je zeker dat je wilt uitloggen</h3>
                    <a href="../src/loguit.php"><button type="button" class=" bg-green-400 text-black hover:text-white hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Ja, ik wil uitloggen
                        </button></a>
                    <button data-modal-toggle="uitlog-modal" type="button" class=" bg-blue-300 text-black hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-base font-medium px-5 py-2.5 focus:z-10">
                        Annuleren
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- script voor mobiel menu -->
    <script>
        // Navbar Toggle
        document.addEventListener('DOMContentLoaded', function() {

            // Get all "navbar-burger" elements
            var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(function($el) {
                    $el.addEventListener('click', function() {

                        // Get the "main-nav" element
                        var $target = document.getElementById('main-nav');
                        var $rechts = document.getElementById('profiel');

                        // Toggle the class on "main-nav"
                        $target.classList.toggle('hidden');

                        $rechts.classList.toggle('flex-col');

                    });
                });
            }

        });
    </script>
    <img src="../images/banner2.jpg" class="h-60 w-full hidden lg:block">
    <img src="../images/banner_mobile.jpg" class="h-36 w-full  lg:hidden">