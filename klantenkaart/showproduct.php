<?php
$_SESSION['inlog'] = false;
$_SESSION['id'] = NULL;
$_SESSION['rol'] = NULL;
include("src/functies.php");
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
</head>

<body class="text-gray-700">
    <header class="z-50 bg-white flex flex-col sticky top-0">
        <div class="w-full flex justify-center">
            <a href="index.php"><img src="images/header_logo.png" class="h-20 w-96 pl-5"></a>
        </div>
        <div class="w-full border-y border-gray-200">
            <!-- component -->
            <nav class="flex items-center justify-between flex-wrap">
                <div class=" w-full flex-grow flex flex-row justify-center items-center lg:w-auto ">
                    <ul class="flex justify-center flex-row">
                        <li class="p-2">
                            <a href="index.php" style="font-family: Poppins" class="text-base text-gray-600 font-bold hover:text-red-500">Login</a>
                        </li>
                        <li class="p-2">
                            <a href="showcase.php?page=1" class="text-base text-gray-600 font-bold hover:text-red-500">Aanbiedingen</a>
                    </ul>
                </div>
            </nav>
        </div>
        <img src="images/banner2.jpg" class="h-48 w-full hidden lg:block">
        <img src="images/banner_mobile.jpg" class="h-36 w-full  lg:hidden">
        <div style="background-color: #f7f7f7;" class="flex lg:flex-row lg:justify-center mx-30 flex-wrap">
            <?php
            $id = $_GET['id'];
            // pakt alle nodige data
            $sql = "SELECT * FROM aanbieding WHERE id = $id";
            $result = db()->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($data = $result->fetch_assoc()) { ?>
                    <div class="flex justify-center flex-col bg-white border-2 border-black my-5 ml-7 lg:ml-5 p-4 w-5/6 lg:w-2/5 rounded">
                        <?php
                        $id2 = $data['product_id'];
                        $sql2 = "SELECT * FROM product WHERE id = $id2";
                        $result2 = db()->query($sql2);
                        while ($data2 = $result2->fetch_assoc()) {
                            if ($data2['foto1'] != NULL) {
                                $fotos = [1 => $data2['foto1']];
                            }
                            if ($data2['foto2'] != NULL) {
                                $fotos = [1 => $data2['foto1'], 2 => $data2['foto2']];
                            }
                            if ($data2['foto3'] != NULL) {
                                $fotos = [1 => $data2['foto1'], 2 => $data2['foto2'], 3 => $data2['foto3']];
                            }
                            if ($data2['foto4'] != NULL) {
                                $fotos = [1 => $data2['foto1'], 2 => $data2['foto2'], 3 => $data2['foto3'], 4 => $data2['foto4']];
                            }
                            if ($data2['foto2'] != NULL) {
                        ?>
                                <div id="default-carousel" class="relative" data-carousel="static">
                                    <!-- Carousel wrapper om de foto's te laten zien -->
                                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                        <?php

                                        $a = 1;
                                        foreach ($fotos as $value) { ?>
                                            <!-- Item 1 -->
                                            <div data-modal-toggle="image-modal">
                                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                    <img src="<?php echo $fotos[$a] ?>" class="absolute block w-80 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                                </div>
                                            </div>
                                        <?php $a++;
                                        } ?>
                                    </div>
                                    <!-- Slider indicators -->
                                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                        <?php $a = 1;
                                        foreach ($fotos as $value) { ?>
                                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide <?php echo $a ?>" data-carousel-slide-to="<?php echo $a ?>"></button>
                                        <?php $a++;
                                        } ?>
                                    </div>
                                    <!-- Slider controls -->
                                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                        <span class="inline-flex bg-gray-800/30 items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10">
                                            <svg aria-hidden="true" class="w-5 h-5 sm:w-6 sm:h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                            <span class="sr-only">Previous</span>
                                        </span>
                                    </button>
                                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                        <span class="inline-flex items-center justify-center bg-gray-800/30 w-8 h-8 rounded-full sm:w-10 sm:h-10">
                                            <svg aria-hidden="true" class="w-5 h-5  sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <span class="sr-only">Next</span>
                                        </span>
                                    </button>
                                </div>
                            <?php } elseif (isset($data2['foto1'])) { ?>
                                <div data-modal-toggle="image-modal">
                                    <div class="flex justify-center">
                                        <img src="<?php echo $data2['foto1'] ?>" class="w-3/4">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="mb-5">
                                <h1 class="text-xl font-bold"><?php echo $data2['merk'] . " " . $data2['naam'] ?></h1>
                                <div class="flex flex-col lg:flex-row">
                                    <p>Tegen inlevering van <?php echo $data['punten'] ?> megabyte: &nbsp;</p>
                                    <div class="flex flex-row">
                                        <p class="line-through text-red-800">€<?php echo number_format($data2['prijs'], 2) ?></p>
                                        <p class="text-base text-black font-bold">&nbsp;€<?php echo number_format($data['prijs'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                            <h1 class="text-xl font-bold">Omschrijving</h1>
                            <p><?php echo $data2['omschrijving'] ?></p>
                    </div>

                    <div class="flex justify-start h-fit flex-col bg-white border-2 border-black my-5 ml-7 lg:ml-5 p-4 w-full lg:w-2/5 rounded">
                        <h1 class="text-2xl font-bold"></h1>
                        <table class="w-full border-2 mt-2">
                            <tr style="background-color: #ed1c24;">
                                <th colspan="2" class="text-black text-2xl">Informatie</th>
                            </tr>
                            <tr class="border-2 border-black">
                                <th class="border-2 border-black bg-gray-300">Categorie:</th>
                                <td class="text-black lg:pl-5"><?php echo $data2['categorie'] ?></td>
                            </tr>
                            <tr class="border-2 border-black">
                                <th class="border-2 border-black bg-gray-300">Onderdeel:</th>
                                <td class="text-black lg:pl-5"><?php echo $data2['onderdeel'] ?></td>
                            </tr>
                            <tr class="border-2 border-black">
                                <th class="border-2 border-black bg-gray-300">Merk:</th>
                                <td class="text-black lg:pl-5"><?php echo $data2['merk'] ?></td>
                            </tr>
                            <tr class="border-2 border-black">
                                <th class="border-2 border-black bg-gray-300">Fabriekscode:</th>
                                <td class="text-black lg:pl-5"><?php echo $data2['fabriekscode'] ?></td>
                            </tr>
                            <tr class="border-2 border-black">
                                <th class="border-2 border-black bg-gray-300">Conditie:</th>
                                <td class="text-black lg:pl-5"><?php echo $data2['conditie'] ?></td>
                            </tr>
                        </table>
                        <a href="index.php"><button class="font-semibold rounded-lg bg-blue-300 px-3 py-1 lg:px-5 mt-6 text-gray-700 hover:text-white hover:bg-blue-800">Je moet inloggen om deze aanbieding te kopen</button></a>
                    </div>
                    <!-- Main modal -->
                    <div id="image-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-xl md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow">
                                <!-- <button type="button" data-modal-toggle="punten-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="image-modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button> -->
                                <?php if ($data2['foto2'] != NULL) { ?>
                                    <div id="default-carousel" class="relative" data-carousel="static">
                                        <!-- Carousel wrapper om de foto's te laten zien -->
                                        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                            <?php
                                            $a = 1;
                                            foreach ($fotos as $value) { ?>
                                                <!-- Item 1 -->
                                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                    <img src="<?php echo $fotos[$a] ?>" class="absolute block w-80 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                                </div>
                                            <?php $a++;
                                            } ?>
                                        </div>
                                        <!-- Slider indicators -->
                                        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                            <?php $a = 1;
                                            foreach ($fotos as $value) { ?>
                                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide <?php echo $a ?>" data-carousel-slide-to="<?php echo $a ?>"></button>
                                            <?php $a++;
                                            } ?>
                                        </div>
                                        <!-- Slider controls -->
                                        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                            <span class="inline-flex bg-gray-800/30 items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10">
                                                <svg aria-hidden="true" class="w-5 h-5 sm:w-6 sm:h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                </svg>
                                                <span class="sr-only">Previous</span>
                                            </span>
                                        </button>
                                        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                            <span class="inline-flex items-center justify-center bg-gray-800/30 w-8 h-8 rounded-full sm:w-10 sm:h-10">
                                                <svg aria-hidden="true" class="w-5 h-5  sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                <span class="sr-only">Next</span>
                                            </span>
                                        </button>
                                    </div>
                                <?php } elseif (isset($data2['foto1'])) { ?>
                                    <div class="flex justify-center">
                                        <img src="<?php echo $data2['foto1'] ?>" class="w-3/4">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
            <?php
                        }
                    }
                } ?>
                    </div>
        </div>

        <?php include 'layout/footer.php'; ?>