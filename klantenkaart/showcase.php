<?php
$_SESSION['inlog'] = false;
$_SESSION['id'] = NULL;
$_SESSION['rol'] = NULL;
include("src/functies.php");
// voorbeeld website
// https://www.recoll-loyalty.com/Catalog/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    <link rel="icon" type="image/x-icon" href="images/web_logo.png">
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
        @font-face {
            font-family: Poppins;
            src: url('https://fonts.googleapis.com/css?family=Poppins');
        }
        body
        {
            font-family: Poppins;
            color: #3d3d3d;
        }
    </style>
</head>

<body>
    <header class="z-50 bg-white flex flex-col sticky top-0">
        <div class="w-full flex justify-center">
            <a href="index.php"><img src="images/header_logo.png" class="h-20 w-96 pl-5"></a>
        </div>
        <div class="w-full border-y border-gray-200">
            <nav class="flex items-center justify-between flex-wrap">
                <div class=" w-full flex-grow flex flex-row justify-center items-center lg:w-auto ">
                    <ul class="flex justify-center flex-row">
                        <li class="p-2">
                            <a href="index.php" class="text-base text-gray-600 font-bold hover:text-red-500">Login</a>
                        </li>
                        <li class="p-2 ">
                            <a href="showcase.php?page=1" class="text-base text-red-500 font-semibold">Aanbiedingen</a>
                    </ul>
                </div>
            </nav>
        </div>
        <img src="images/banner2.jpg" class="h-48 w-full hidden lg:block">
        <img src="images/banner_mobile.jpg" class="h-36 w-full  lg:hidden">
        <style>
            input[type="range"] {
                -webkit-appearance: none;
            }

            input[type="range"]::-webkit-slider-runnable-track {
                -webkit-appearance: none;
                height: 3px;
            }

            input[type="range"]::-ms-track {
                appearance: none;
                height: 5px;
            }

            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 1.5em;
                width: 1.5em;
                background-color: #ed1c24;
                cursor: pointer;
                margin-top: -9px;
                pointer-events: auto;
            }

            input[type="range"]::-ms-thumb {
                appearance: none;
                height: 1.4em;
                width: 1.4em;
                border-radius: 50%;
                background-color: #ed1c24;
                pointer-events: auto;
            }

            input[type="range"]:active::-webkit-slider-thumb {
                background-color: #ffffff;
                border: 3px solid #ed1c24;
            }

            .slider-track,
            .slider-track2,
            .slider-track3 {
                opacity: 0.5;
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
        <div style="background-color: #f7f7f7;" class="w-full h-auto flex flex-col lg:flex-row mx-30 pt-5">

            <?php
            $exclusiefmin = NULL;
            $exclusiefmax = NULL;
            $puntenmin = NULL;
            $puntenmax = NULL;
            $categorie = NULL;
            $actief = NULL;
            if (isset($_POST['aanbiedingzoek'])) {
                // verstuurt data voor zoeken
                if (isset($_POST['exclusiefmin']) && isset($_POST['exclusiefmax'])) {
                    $exclusiefmin = $_POST['exclusiefmin'];
                    $exclusiefmax = $_POST['exclusiefmax'];
                }
                if (isset($_POST['puntenmin']) && isset($_POST['puntenmax'])) {
                    $puntenmin = $_POST['puntenmin'];
                    $puntenmax = $_POST['puntenmax'];
                }
                if (isset($_POST['categorie'])) {
                    $categorie = $_POST['categorie'];
                }
                if (isset($_POST['actief'])) {
                    $actief = $_POST['actief'];
                }
                $sql = zoekaanbieding($exclusiefmin, $exclusiefmax, $puntenmin, $puntenmax, $categorie, $actief);
                $start = 12 * ($_GET['page'] - 1);
                $result_totaal = db()->query($sql);
                if ($_GET['page'] == 1) {
                    $start = 0;
                }
                $sql = $sql . " LIMIT $start, 12";
            } else {
                $sql = "SELECT * FROM aanbieding ORDER BY id DESC";
                $start = 12 * ($_GET['page'] - 1);
                $result_totaal = db()->query($sql);
                if ($_GET['page'] == 1) {
                    $start = 0;
                }
                $sql = "SELECT * FROM aanbieding ORDER BY id DESC LIMIT $start, 9";
            }
            ?>
            <div class="bg-white h-auto flex flex-col lg:flex-row p-2 border-2 border-black lg:ml-3 w-full lg:w-1/4 rounded flex-wrap">
                <div class="w-full">
                    <?php if (isset($_POST['aanbiedingzoek'])) { ?>
                        <!-- zoekformulier aanbiedingen -->
                        <form action="src/clear.php" method="post">
                            <button type="submit" name="clearshowcase" class="text-sm mb-1 knop text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg lg:text-sm px-4 py-2">Clear</button>
                        </form>
                    <?php } ?>
                    <form action="showcase.php?page=1" method="post">
                        <div class="absolute mt-2 hidden lg:block  lg:left-4 top-100 flex flex-col items-center pl-1 lg:pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-6 lg:w-5 h-6 lg:h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="flex w-full mb-12">
                            <?php if (isset($_POST['zoekproduct'])) { ?>
                                <input type="search" name="zoekproduct" value="<?php echo $_POST['zoekproduct']; ?>" class="block w-full p-2 pl-7 mr-2 text-sm text-gray-900 border border-black rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            <?php } else { ?>
                                <input type="search" name="zoekproduct" placeholder="filter de aanbieding" class="block w-full p-2 pl-7 mr-2 text-sm text-gray-900 border border-gray-400 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            <?php } ?>
                            <button type="submit" name="aanbiedingzoek" class="knop text-white bg-blue-300 hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg lg:text-sm px-6 lg:px-4 py-3 lg:py-2">Filter</button>
                        </div>

                        <div class="mb-12">
                            <p class="font-semibold text-sm">Orginele prijs</p>
                            <div class="w-full flex justify-between pb-2">
                                <?php
                                if (isset($_POST['orgineelmin'])) {
                                    $orgineelmin = $_POST['orgineelmin'];
                                } else {
                                    $orgineelmin = 0;
                                }
                                if (isset($_POST['orgineelmax'])) {
                                    $orgineelmax = $_POST['orgineelmax'];
                                } else {
                                    $orgineelmax = 100;
                                }
                                ?>
                                <div>€<span id="range1"><?php echo $orgineelmin; ?></span></div>
                                <div>€<span id="range2"><?php echo $orgineelmax; ?></span></div>
                            </div>
                            <div class="w-100 relative mb-5">
                                <?php $orgineel = $orgineelmax - $orgineelmin ?>
                                <div class="slider-track w-full h-2 rounded-lg absolute top-0 bottom-0" style="background: linear-gradient(to right, rgb(218, 218, 229) <?php echo $orgineelmin; ?>%, #ed1c24  <?php echo $orgineelmin; ?>%, #ed1c24 <?php echo $orgineelmax; ?>%, rgb(218, 218, 229) <?php echo $orgineel ?>%);"></div>
                                <input name="orgineelmin" type="range" min="0" max="100" value="<?php echo $orgineelmin; ?>" id="slider-1" oninput="slideOne()" class="absolute top-0 bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                                <input name="orgineelmax" type="range" min="0" max="100" value="<?php echo $orgineelmax; ?>" id="slider-2" oninput="slideTwo()" class="absolute top-0 bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                            </div>
                            <script>
                                window.onload = function() {
                                    slideOne();
                                    slideTwo();
                                }
                                let sliderOne = document.getElementById("slider-1");
                                let sliderTwo = document.getElementById("slider-2");
                                let displayValOne = document.getElementById("range1");
                                let displayValTwo = document.getElementById("range2");
                                let minGap = 0;
                                let sliderTrack = document.querySelector(".slider-track");
                                let sliderMaxValue = document.getElementById("slider-1").max;

                                function slideOne() {
                                    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                                        sliderOne.value = parseInt(sliderTwo.value) - minGap;
                                    }
                                    displayValOne.textContent = sliderOne.value;
                                    fillColor();
                                }

                                function slideTwo() {
                                    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                                        sliderTwo.value = parseInt(sliderOne.value) + minGap;
                                    }
                                    displayValTwo.textContent = sliderTwo.value;
                                    fillColor();
                                }

                                function fillColor() {
                                    percent1 = (sliderOne.value / sliderMaxValue) * 100;
                                    percent2 = (sliderTwo.value / sliderMaxValue) * 100;
                                    sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #ed1c24  ${percent1}% , #ed1c24 ${percent2}%, #dadae5 ${percent2}%)`;
                                }
                            </script>
                        </div>

                        <div class="mb-12">
                            <p class="font-semibold text-sm">Korting prijs</p>
                            <div class="w-full flex justify-between pb-2">
                                <?php
                                if (isset($_POST['exclusiefmin'])) {
                                    $exclusiefmin = $_POST['exclusiefmin'];
                                } else {
                                    $exclusiefmin = 0;
                                }
                                if (isset($_POST['exclusiefmax'])) {
                                    $exclusiefmax = $_POST['exclusiefmax'];
                                } else {
                                    $exclusiefmax = 100;
                                }
                                ?>
                                <div>€<span id="range3"><?php echo $exclusiefmin ?></span></div>
                                <div>€<span id="range4"><?php echo $exclusiefmax ?></span></div>
                            </div>
                            <div class="w-100 relative mb-5 ">
                                <?php $exclusief = $exclusiefmax - $exclusiefmin ?>
                                <div class="slider-track2 w-full h-2 rounded-lg absolute top-0 bottom-0" style="background: linear-gradient(to right, rgb(218, 218, 229) <?php echo $exclusiefmin ?>%, #ed1c24 <?php echo $exclusiefmin ?>%, #ed1c24 <?php echo $exclusiefmax ?>%, rgb(218, 218, 229) <?php echo $exclusief ?>%);"></div>
                                <input name="exclusiefmin" type="range" min="0" max="100" value="<?php echo $exclusiefmin ?>" id="slider-3" oninput="slideThree()" class="absolute top-0 bg-transparanent bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                                <input name="exclusiefmax" type="range" min="0" max="100" value="<?php echo $exclusiefmax ?>" id="slider-4" oninput="slideFour()" class="absolute top-0 bg-transparent bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                            </div>
                            <script>
                                window.onload = function() {
                                    slideThree();
                                    slideFour();
                                }
                                let sliderThree = document.getElementById("slider-3");
                                let sliderFour = document.getElementById("slider-4");
                                let displayValThree = document.getElementById("range3");
                                let displayValFour = document.getElementById("range4");
                                let minGap2 = 0;
                                let sliderTrack2 = document.querySelector(".slider-track2");
                                let sliderMaxValue2 = document.getElementById("slider-3").max;

                                function slideThree() {
                                    if (parseInt(sliderFour.value) - parseInt(sliderThree.value) <= minGap2) {
                                        sliderThree.value = parseInt(sliderFour.value) - minGap2;
                                    }
                                    displayValThree.textContent = sliderThree.value;
                                    fillColor2();
                                }

                                function slideFour() {
                                    if (parseInt(sliderFour.value) - parseInt(sliderThree.value) <= minGap2) {
                                        sliderFour.value = parseInt(sliderThree.value) + minGap2;
                                    }
                                    displayValFour.textContent = sliderFour.value;
                                    fillColor2();
                                }

                                function fillColor2() {
                                    percent3 = (sliderThree.value / sliderMaxValue2) * 100;
                                    percent4 = (sliderFour.value / sliderMaxValue2) * 100;
                                    sliderTrack2.style.background = `linear-gradient(to right, #dadae5 ${percent3}% , #ed1c24 ${percent3}% , #ed1c24 ${percent4}%, #dadae5 ${percent4}%)`;
                                }
                            </script>
                        </div>

                        <div class="mb-12">
                            <p class="font-semibold text-sm">Megabyte</p>
                            <div class="w-full flex justify-between pb-2">
                                <?php
                                if (isset($_POST['puntenmin'])) {
                                    $puntenmin = $_POST['puntenmin'];
                                } else {
                                    $puntenmin = 0;
                                }
                                if (isset($_POST['puntenmax'])) {
                                    $puntenmax = $_POST['puntenmax'];
                                } else {
                                    $puntenmax = 1000;
                                }
                                ?>
                                <div><span id="range5"><?php echo $puntenmin ?></span></div>
                                <div><span id="range6"><?php echo $puntenmax ?></span></div>
                            </div>
                            <div class="w-100 relative mb-5">
                                <?php $punten = $puntenmax - $puntenmin ?>
                                <div class="slider-track3 w-full h-2 rounded-lg absolute top-0 bottom-0" style="background: linear-gradient(to right, rgb(218, 218, 229) <?php echo $exclusiefmin ?>%, #ed1c24 <?php echo $exclusiefmin ?>%, #ed1c24 <?php echo $exclusiefmax ?>%, rgb(218, 218, 229) <?php echo $punten ?>%);"></div>
                                <input name="puntenmin" type="range" min="0" max="1000" value="<?php echo $puntenmin ?>" id="slider-5" oninput="slideFive()" class="absolute top-0 bg-transparanent bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                                <input name="puntenmax" type="range" min="0" max="1000" value="<?php echo $puntenmax ?>" id="slider-6" oninput="slideSix()" class="absolute top-0 bg-transparent bottom-0 w-full rounded-lg pointer-events-none cursor-pointer">
                            </div>
                            <script>
                                window.onload = function() {
                                    slideFive();
                                    slideSix();
                                }
                                let sliderFive = document.getElementById("slider-5");
                                let sliderSix = document.getElementById("slider-6");
                                let displayValFive = document.getElementById("range5");
                                let displayValSix = document.getElementById("range6");
                                let minGap3 = 0;
                                let sliderTrack3 = document.querySelector(".slider-track3");
                                let sliderMaxValue3 = document.getElementById("slider-5").max;

                                function slideFive() {
                                    if (parseInt(sliderSix.value) - parseInt(sliderFive.value) <= minGap3) {
                                        sliderFive.value = parseInt(sliderSix.value) - minGap3;
                                    }
                                    displayValFive.textContent = sliderFive.value;
                                    fillColor3();
                                }

                                function slideSix() {
                                    if (parseInt(sliderSix.value) - parseInt(sliderFive.value) <= minGap3) {
                                        sliderSix.value = parseInt(sliderFive.value) + minGap3;
                                    }
                                    displayValSix.textContent = sliderSix.value;
                                    fillColor3();
                                }

                                function fillColor3() {
                                    percent5 = (sliderFive.value / sliderMaxValue3) * 100;
                                    percent6 = (sliderSix.value / sliderMaxValue3) * 100;
                                    sliderTrack3.style.background = `linear-gradient(to right, #dadae5 ${percent5}% , #ed1c24 ${percent5}% , #ed1c24 ${percent6}%, #dadae5 ${percent6}%)`;
                                }
                            </script>
                        </div>

                        <div class="mb-5">
                            <p class="text-sm font-semibold">Categorieën</p>
                            <?php
                            // herhaalt alle categorieën uit de database
                            $sqlcategorie = "SELECT * FROM categorie";
                            $resultcategorie = db()->query($sqlcategorie);
                            if ($resultcategorie->num_rows > 0) {
                                // output data of each row
                                while ($categorie = $resultcategorie->fetch_assoc()) {
                                    if (isset($_POST['categorie']) && $_POST['categorie'] == $categorie['naam']) { ?>
                                        <p class="text-sm"><input type="radio" checked name="categorie" value="<?php echo $categorie['id'] ?>" class="mr-1"><?php echo $categorie['naam'] ?></p>
                                    <?php } else { ?>
                                        <p class="text-sm"><input type="radio" name="categorie" value="<?php echo $categorie['id'] ?>" class="mr-1 bg-gray-100"><?php echo $categorie['naam'] ?></p>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <style>
                .artikel {
                    width: 26%;
                }

                @media (max-width: 992px) {
                    .artikel {
                        width: 50%;
                    }
                }
            </style>
            <div class="flex flex-col items-center w-3/4">
                <div class="w-full flex flex-row lg:justify-left flex-wrap">
                    <?php
                    // haalt data op voor aanbiedingen
                    $result = db()->query($sql);
                    if ($result->num_rows > 0) {
                        // echo $result->num_rows;
                        // output data of each row
                        while ($data = $result->fetch_assoc()) {
                            $id2 = $data['product_id'];
                            if ($data['actief'] == 'inactief' && $_SESSION['rol'] == 0) {
                            } else {
                                if (isset($_POST['aanbiedingzoek'])) {
                                    $product = NULL;
                                    $orgineelmin = NULL;
                                    $orgineelmax = NULL;

                                    if (isset($_POST['zoekproduct'])) {
                                        $product = $_POST['zoekproduct'];
                                    }
                                    if (isset($_POST['orgineelmin']) && isset($_POST['orgineelmax'])) {
                                        $orgineelmin = $_POST['orgineelmin'];
                                        $orgineelmax = $_POST['orgineelmax'];
                                    }
                                    $sql2 = zoekaanbiedingproduct($orgineelmin, $orgineelmax, $product, $id2);
                                } else {
                                    $sql2 = "SELECT * FROM product WHERE id = $id2";
                                }
                                // haalt de data voor producten op
                                $result2 = db()->query($sql2);
                                while ($data2 = $result2->fetch_assoc()) { ?>
                                    <!-- w-1/2 lg:w-1/4 -->
                                    <div class="bg-white flex flex-col items-center border-2 border-black lg:mx-2 lg:mb-2 p-1 artikel rounded">
                                        <a class="w-full h-full" href="showproduct.php?id=<?php echo $data['id'] ?>">
                                            <img class="w-full h-full" src="<?php echo $data2['foto1'] ?>">
                                        </a>
                                        <a class="font-bold text-black hover:text-red-800 text-center" href="showproduct.php?id=<?php echo $data['id'] ?>">
                                            <h1><?php echo $data2['merk'] . " " . $data2['naam'] ?></h1>
                                        </a>
                                        <p class="text-red-800">megabyte: <?php echo $data['punten'] ?></p>
                                        <div class="flex">
                                            <p class="line-through text-red-300">€<?php echo number_format($data2['prijs'], 2) ?></p>&nbsp;
                                            <?php  ?>
                                            <p class="text-red-600 font-bold">€<?php echo number_format($data['prijs'], 2) ?></p>
                                        </div>
                                        <a class="font-bold text-gray-700 hover:text-red-800 text-center" href="showproduct.php?id=<?php echo $data['id'] ?>">
                                            <button class="p-2 text-white knop">
                                                Lees meer
                                            </button>
                                        </a>
                                    </div>
                    <?php

                                }
                            }
                            $pagelimit = $data['id'];
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>
                <?php
                // echo $result_totaal->num_rows;
                // echo "    ";
                $pages = ceil($result_totaal->num_rows / 12);
                if ($pages == 0) {
                    $pages = 1;
                }
                // echo $pages;
                ?>
                <nav aria-label="Page navigation example" class="w-100 mt-5">
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <?php
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                                $previous = $_GET['page'] - 1;
                                $next = $_GET['page'] + 1;
                                if ($previous < 1) {
                                    $previous = 1;
                                }
                                if ($next > $pages) {
                                    $next = $pages;
                                }
                            } else {
                                $page = 1;
                            }
                            ?>
                            <a href="showcase.php?page=<?php echo $previous ?>" class="block px-3 py-2 ml-0 leading-tight text-black bg-white border border-gray-300 rounded-l-lg hover:bg-gray-200 hover:text-gray-700">
                                <span class="sr-only">Previous</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                        <?php
                        $i = 1;
                        while ($i <= $pages) {
                            $minpage = $_GET['page'] - 5;
                            $maxpage = $_GET['page'] + 5;
                            if ($i > $minpage && $i < $maxpage) {
                                if ($i == $page) {
                        ?>
                                    <li>
                                        <a href="showcase.php?page=<?php echo $i ?>" aria-current="page" class="z-10 px-3 py-2 leading-tight font-semibold text-white border border-red-500 bg-red-500 hover:bg-red-600 hover:text-white"><?php echo $i ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <a href="showcase.php?page=<?php echo $i ?>" class="px-3 py-2 leading-tight text-black bg-white border font-semibold border-gray-300 hover:bg-red-500 hover:border-red-500 hover:text-white"><?php echo $i ?></a>
                                    </li>
                        <?php
                                }
                            }
                            $i++;
                        }
                        ?>
                        <li>
                            <a href="showcase.php?page=<?php echo $next ?>" class="block px-3 py-2 leading-tight text-black bg-white border border-gray-300 rounded-r-lg hover:bg-gray-200 hover:text-gray-700">
                                <span class="sr-only">Next</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php include 'layout/footer.php' ?>