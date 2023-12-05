<?php include '../layout/header.php'; ?>
<style>
    .knop {
        background-color: #39b93c;
    }

    .knop:hover {
        background-color: #ed1c24;
    }
</style>
<div style="background-color: #f7f7f7;" class="flex lg:flex-row lg:justify-center mx-30 flex-wrap">
    <?php
    $id = $_GET['id'];
    // pakt alle data van de aanbieding op deze pagina
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
                    if ($data2['foto2'] != NULL) { ?>
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
                <?php if (($_SESSION['rol'] == 1)) { ?>
                    <div class="flex space-x-2">
                        <button data-modal-toggle="bewerk-product-modal" class="w-1/3 lg:w-1/12 bg-green-500 hover:bg-green-800 p-1 rounded-lg"><img class="" src="../images/pencil.png"></button>
                        <?php if ($data['actief'] == "actief") { ?>
                            <button data-modal-toggle="actief-modal" class="w-1/3 lg:w-1/12 bg-red-500 hover:bg-red-800 p-1 rounded-lg"><img src="../images/cross.png"></button>
                        <?php } elseif ($data['actief'] == "inactief") { ?>
                            <button data-modal-toggle="actief-modal" class="w-1/3 lg:w-1/12 bg-green-500 hover:bg-green-800 p-1 rounded-lg"><img class="" src="../images/check.png"></button>
                        <?php } ?>
                    </div>
                <?php } ?>
                <table class="w-full border-2 mt-2">
                    <tr style="background-color: #ed1c24;">
                        <th colspan="2" class="text-2xl text-black">Informatie</th>
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
                <?php
                    $gebruikerid = $_SESSION['id'];
                    $sql3 = "SELECT * FROM gebruikers WHERE id = $gebruikerid";
                    $result3 = db()->query($sql3);
                    if ($result3->num_rows > 0) {
                        // output data of each row
                        while ($data3 = $result3->fetch_assoc()) {
                            if ($data3['punten'] >= $data['punten']) { ?>
                            <button data-modal-toggle="punten-modal" class="flex font-semibold justify-center rounded-lg bg-blue-300 px-3 py-1 lg:px-4 mt-6 text-black hover:text-white hover:bg-blue-800">Gebruik punten</button>
                        <?php } elseif ($data3['punten'] < $data['punten']) { ?>
                            <button class="flex font-semibold justify-center cursor-default rounded-lg bg-red-800 px-3 py-1 lg:px-4 mt-6 text-white">Niet genoeg punten</button>
                        <?php } ?>
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
                                                <?php $a = 1;
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
                        </div>
                        <?php if (($_SESSION['rol'] == 1)) { ?>
                            <!-- Main modal om het product en aanbieding te bewerken-->
                            <div id="bewerk-product-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                <div class="relative w-full h-full max-w-2xl md:h-auto">
                                    <!-- Modal content -->
                                    <div class="w-full bg-white rounded-lg shadow">
                                        <button type="button" class="absolute top-3 right-2.5 text-black bg-gray-200 hover:bg-black hover:text-white  rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="bewerk-product-modal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="px-6 py-6 lg:px-6">

                                            <form class="" action="../src/database.php" method="post">
                                                <div class="flex space-x-2 lg:flex-row">
                                                    <div>
                                                        <h3 class="mb-1 text-lg font-medium text-black">Bewerk product</h3>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                            <input type="hidden" name="productid" value="<?php echo $data2['id'] ?>">
                                                            <input type="hidden" name="detail" value="true">

                                                            <div class="">
                                                                <label class="block font-medium text-gray-900">Naam</label>
                                                                <input type="text" name="naam" value="<?php echo $data2['naam'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="naam" required>
                                                            </div>
                                                            <div class="">
                                                                <label class="block  font-medium text-gray-900">Prijs</label>
                                                                <input type="number" step="0.01" name="prijs" value="<?php echo number_format($data2['prijs'], 2) ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="prijs" required>
                                                            </div>
                                                        </div>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                            <div class="">
                                                                <label class="block font-medium text-gray-900">Merk</label>
                                                                <input type="text" name="merk" value="<?php echo $data2['merk'] ?>" placeholder="merk" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                            </div>
                                                            <div class="">
                                                                <label class="block font-medium text-gray-900">Categorie</label>
                                                                <input type="text" name="categorieproduct" value="<?php echo $data2['categorie'] ?>" placeholder="categorie" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                            </div>
                                                        </div>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                            <div class="">
                                                                <label class="block font-medium text-gray-900">Onderdeel</label>
                                                                <input type="text" name="onderdeel" value="<?php echo $data2['onderdeel'] ?>" placeholder="onderdeel" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                            </div>
                                                            <div class="">
                                                                <label class="block font-medium text-gray-900">Conditie</label>
                                                                <input type="text" name="conditie" value="<?php echo $data2['conditie'] ?>" placeholder="conditie" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <label class="block font-medium text-gray-900">Fabriekscode</label>
                                                            <input type="text" name="fabriek" value="<?php echo $data2['fabriekscode'] ?>" placeholder="fabriekscode" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                        </div>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                            <div class="">
                                                                <label for="img">Foto 1:</label>
                                                                <input type="text" name="img1" value="<?php echo $data2['foto1'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                                            </div>

                                                            <div class="">
                                                                <label for="img">Foto 2:</label>
                                                                <input type="text" name="img2" value="<?php echo $data2['foto2'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                                            </div>
                                                        </div>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                            <div class="">
                                                                <label for="img">Foto 3:</label>
                                                                <input type="text" name="img3" value="<?php echo $data2['foto3'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                                            </div>

                                                            <div class="">
                                                                <label for="img">Foto 4:</label>
                                                                <input type="text" name="img4" value="<?php echo $data2['foto4'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <label class="block font-medium text-gray-900">Omschrijving</label>
                                                            <textarea name="omschrijving" value="<?php echo $data2['omschrijving'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1" required cols="20" rows="5"><?php echo $data2['omschrijving'] ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <h3 class="mb-1 text-lg font-medium text-black">Bewerk aanbieding</h3>
                                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                        <input type="hidden" name="detail" value="true">
                                                        <div class="">
                                                            <label class="block  font-medium text-gray-900">Inlever prijs</label>
                                                            <input type="number" step="0.01" name="inlever" value="<?php echo number_format($data['prijs'], 2) ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="prijs na inleveren" required>
                                                        </div>
                                                        <div class="">
                                                            <label class="block font-medium text-gray-900">Aantal punten</label>
                                                            <input type="number" name="punten" value="<?php echo $data['punten'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="Aantal punten" required>
                                                        </div>
                                                        <div class="">
                                                            <label class="block font-medium text-gray-900">Categorie</label>
                                                            <select name="categorie" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                                                <option selected value="<?php echo $data['categorie'] ?>" hidden><?php echo $data['categorie'] ?></option>
                                                                <?php
                                                                $sql4 = 'SELECT * FROM categorie WHERE id =' . $data['categorie'];
                                                                $result4 = db()->query($sql4);
                                                                if ($result4->num_rows > 0) {
                                                                    // output data of each row
                                                                    while ($data4 = $result4->fetch_assoc()) { ?>
                                                                        <option selected value="<?php echo $data4['naam'] ?>" hidden><?php echo $data4['naam'] ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                $sqlcategorie = "SELECT * FROM categorie";
                                                                $resultcategorie = db()->query($sqlcategorie);
                                                                if ($resultcategorie->num_rows > 0) {
                                                                    // output data of each row
                                                                    while ($categorie = $resultcategorie->fetch_assoc()) {
                                                                        if ($categorie['actief'] == 'actief') { ?>
                                                                            <option value="<?php echo $categorie['naam'] ?>"><?php echo $categorie['naam'] ?></option>
                                                                <?php }
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="flex space-x-2 lg:flex-row">
                                                        </div>
                                                        <button type="submit" name="bewerkaanbieding" class="knop rounded-lg  px-3 py-1 lg:px-5 mt-6 text-white">Bewerk aanbieding</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Main modal om de aanbieding en het product -->
                            <div id="actief-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                <div class="relative w-full h-full max-w-md md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow">
                                        <button type="button" data-modal-toggle="actief-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="actief-modal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-6 text-center">
                                            <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php if ($data['actief'] == "actief") { ?>
                                                <h3 class="mb-5 text-lg font-normal text-black">weet je zeker dat je dit artikel op inactief wilt zetten?</h3>
                                            <?php } elseif ($data['actief'] == "inactief") { ?>
                                                <h3 class="mb-5 text-lg font-normal text-black">weet je zeker dat je dit artikel op actief wilt zetten?</h3>
                                            <?php } ?>
                                            <div class="flex justify-center">
                                                <?php if ($data['actief'] == "actief") { ?>
                                                    <form action="../src/database.php" method="post">
                                                        <input type="hidden" name="product" value="true">
                                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                        <input type="hidden" name='actief' value="<?php echo $data['actief'] ?>">
                                                        <!-- data-modal-toggle="inactief-modal" -->
                                                        <button type="submit" name="aanbieding-actief" class=" bg-red-400 text-black hover:text-white hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Ja, zet op inactief
                                                        </button>
                                                    </form>
                                                <?php } elseif ($data['actief'] == "inactief") { ?>
                                                    <form action="../src/database.php" method="post">
                                                        <input type="hidden" name="product" value="true">
                                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                        <input type="hidden" name='actief' value="<?php echo $data['actief'] ?>">
                                                        <!-- data-modal-toggle="actief-modal" -->
                                                        <button type="submit" name="aanbieding-actief" class="knop text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Ja, zet op actief
                                                        </button>
                                                    </form>
                                                <?php } ?>
                                                <button data-modal-toggle="actief-modal" type="button" class="bg-blue-300 text-black hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 focus:z-10">
                                                    Annuleren
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Main modal -->
                        <div id="punten-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                            <div class="relative w-full h-full max-w-md md:h-auto">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button" data-modal-toggle="punten-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="popup-modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-black">weet je zeker dat je punten wilt gebruiken?</h3>
                                        <div class="flex flex-row justify-center">
                                            <form action="../src/database.php" method="post">
                                                <input type="hidden" name="gebruiker" value="<?php echo $_SESSION['id'] ?>">
                                                <input type="hidden" name="aanbieding" value="<?php echo $data['id'] ?>">
                                                <input type="hidden" name="punten" value="<?php echo $data['punten'] ?>">
                                                <input type="hidden" name="userpunten" value="<?php echo $data3['punten'] ?>">
                                                <input type="hidden" name="datum" value="<?php echo date('Y-m-d H:i:s') ?>">
                                                <button type="submit" name="bestel" class="knop text-lg font-bold text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Ja, ik wil punten gebruiken
                                                </button>
                                            </form>
                                            <button data-modal-toggle="punten-modal" type="button" class="text-lg font-bold bg-blue-300 text-black hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 focus:z-10">
                                                Annuleren
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    <?php }
                    }
                }
            }
        } ?>
            </div>
</div>

<?php include '../layout/footer.php'; ?>