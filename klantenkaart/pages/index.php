<?php include '../layout/header.php' ?>

<div style="background-color: #f7f7f7;" class="flex flex-col lg:flex-row lg:justify-center mx-30 pb-5 flex-wrap">
    <?php if ($_SESSION['rol'] == 1) { ?>
        <div class="bg-white flex justify-center flex-col items-center border-2 border-black mt-5 ml-7 lg:ml-5 p-5 w-5/6 lg:w-2/5 rounded">
            <h2 class="text-xl font-bold">Klanten</h2>
            <?php
            // laat de hoeveelheid gebruikers zien
            $aantal = 0;
            $sql = "SELECT * FROM gebruikers";
            $result = db()->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($data = $result->fetch_assoc()) {
                    $aantal++;
                }
            } ?>
            <p class="text-gray-700 font-bold"><?php echo $aantal; ?> klanten</p>
            <div class="flex flex-row space-x-2">
                <a href="../data/klanten.php?page=1"><button class="rounded-lg font-semibold bg-blue-300 px-3 py-1 lg:px-5 mt-2 lg:mt-6 text-gray-700 hover:text-white hover:bg-blue-800">Index</button></a>
                <button data-modal-toggle="nieuw-klant-modal" class="knop rounded-lg font-semibold px-3 py-1 lg:px-5 mt-2 lg:mt-6 text-white">Nieuwe klant</button>
            </div>
        </div>
    <?php } ?>
    <style>
        .knop {
            background-color: #39b93c;
        }

        .knop:hover {
            background-color: #ed1c24;
        }
    </style>
    <div class="bg-white flex flex-col space-y-4 lg:flex-row justify-center border-2 lg:space-x-8 lg:flex-row border-black mt-5 ml-7 lg:ml-5 p-5 w-5/6 lg:w-2/5 rounded">
        <div class="flex flex-col items-center">
            <div>
                <h2 class="text-xl  font-bold">Aanbiedingen</h2>
                <?php
                // laat de hoeveelheid aanbiedingen zien
                $aantal = 0;
                if ($_SESSION['rol'] == 1) {
                    $sql = "SELECT * FROM aanbieding";
                } elseif ($_SESSION['rol'] == 0) {
                    $sql = "SELECT * FROM aanbieding WHERE actief = 'actief'";
                }
                $result = db()->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($data = $result->fetch_assoc()) {
                        $aantal++;
                    }
                } ?>
            </div>
            <p class="text-gray-700  font-bold"><?php echo $aantal ?> aandbiedingen</p>
            <div>
                <a href="../data/aanbiedingen.php?page=1"><button class="rounded-lg font-semibold bg-blue-300 px-3 py-1 lg:px-5 mt-6 text-base text-gray-700 hover:text-white hover:bg-blue-800">Index</button></a>
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <button data-modal-toggle="nieuw-product-modal" class="knop rounded-lg font-semibold px-3 py-1 lg:px-5 mt-4 text-base text-white hover:text-white">Nieuwe aanbieding</button>
                <?php } ?>
            </div>
        </div>
    </div>


    <div class="bg-white flex flex-col justify-center items-center border-2 border-black border-2 lg:space-x-8 border-black mt-5 ml-7 lg:ml-5 p-5 w-5/6 lg:w-2/5 rounded">
        <h2 class="text-xl font-bold">Bestellingen</h2>
        <?php
        // laat de hoeveelheid bestellingen zien
        $aantal = 0;
        if ($_SESSION['rol'] == 1) {
            $sql = "SELECT * FROM bestelling WHERE gebruikt = 'nee'";
        } elseif ($_SESSION['rol'] == 0) {
            $id = $_SESSION['id'];
            $sql = "SELECT * FROM bestelling WHERE gebruikt = 'nee' AND gebruikerid = '$id'";
        }
        $result = db()->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($data = $result->fetch_assoc()) {
                $aantal++;
            }
        } ?>
        <p class="text-gray-700 font-bold"><?php echo $aantal ?> openstaande bestellingen</p>
        <a href="../data/bestellingen.php?page=1"><button class="font-semibold rounded-lg bg-blue-300 px-3 py-1 lg:px-4 mt-6 text-gray-700 hover:text-white hover:bg-blue-800">Index</button></a>
    </div>
</div>
<?php if ($_SESSION['rol'] == 1) { ?>
    <!-- Main modal om nieuwe klant aan te maken -->
    <div id="nieuw-klant-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto rounded-lg">
            <!-- Modal content -->
            <div class="relative w-fit bg-white shadow border-2 border-gray-500 rounded-lg">
                <button type="button" class="absolute top-3 right-2.5 text-black bg-gray-200 hover:bg-black hover:text-white  rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="nieuw-klant-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-black">Nieuwe klant</h3>
                    <form class="" action="../src/database.php" methhod="post">

                        <div class="flex space-x-2 lg:flex-row">
                            <div class="">
                                <label class="block font-medium text-gray-900">Voornaam</label>
                                <input type="text" name="vnaam" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="voornaam" required>
                            </div>
                            <div class="">
                                <label class="block font-medium text-gray-900">Achternaam</label>
                                <input type="text" name="anaam" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="achternaam" required>
                            </div>
                            <div class="">
                                <label class="block font-medium text-gray-900">Bedrijfnaam</label>
                                <input type="text" name="bedrijf" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="bedrijfnaam" required>
                            </div>
                        </div>

                        <div class="flex space-x-2 lg:flex-row">
                            <div class=" w-4/5">
                                <label class="block font-medium text-gray-900">Straatnaam</label>
                                <input type="text" name="straat" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="straatnaam" required>
                            </div>
                            <div class="w-1/5">
                                <label class="block font-medium text-gray-900">nummer</label>
                                <input type="huisnummer" name="hnummer" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="4" required>
                            </div>
                        </div>
                        <div class="flex space-x-2 lg:flex-row">
                            <div class="w-2/5">
                                <label class="block font-medium text-gray-900">Plaatsnaam</label>
                                <input type="text" name="plaats" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="plaats" required>
                            </div>
                            <div class="w-3/5">
                                <label class="block font-medium text-gray-900">Postcode</label>
                                <input type="text" name="pcode" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="postcode" required>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-900">Telefoonnummer</label>
                            <input type="text" name="telefoon" id="telefoon" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="12345545" required>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="naam@gmail.com" required>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-900">Klantnummer</label>
                            <input type="text" name="klantnummer" id="ww" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="vul klantnummer in" required>
                        </div>
                        <button type="submit" name="nieuwe_klant" class="knop rounded-lg font-semibold px-3 py-1 lg:px-5 mt-6 text-white">Maak een nieuwe klant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal - om een nieuwe aanbieding te maken -->
    <div id="nieuw-product-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="w-full bg-white rounded-lg shadow border-gray-500 border-2 rounded-lg">
                <button type="button" class="absolute top-3 right-2.5 text-black bg-gray-200 hover:bg-black hover:text-white  rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="nieuw-product-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-6">

                    <form class="" action="../src/database.php" method="post">
                        <div class="flex space-x-2 lg:flex-row">
                            <div>
                                <h3 class="mb-1 text-lg font-medium text-black">Nieuw product</h3>
                                <div class="flex space-x-2 lg:flex-row">
                                    <div class="">
                                        <label class="block font-medium text-gray-900">Naam</label>
                                        <input type="text" name="naam" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="naam" required>
                                    </div>
                                    <div class="">
                                        <label class="block  font-medium text-gray-900">Prijs</label>
                                        <input type="number" step="0.01" name="prijs" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="prijs" required>
                                    </div>
                                </div>

                                <div class="flex space-x-2 lg:flex-row">
                                    <div class="">
                                        <label class="block font-medium text-gray-900">Merk</label>
                                        <input type="text" name="merk" placeholder="merk" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                    </div>
                                    <div class="">
                                        <label class="block font-medium text-gray-900">Categorie</label>
                                        <input type="text" name="categorieproduct" placeholder="categorie" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                    </div>
                                </div>

                                <div class="flex space-x-2 lg:flex-row">
                                    <div class="">
                                        <label class="block font-medium text-gray-900">Onderdeel</label>
                                        <input type="text" name="onderdeel" placeholder="onderdeel" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                    </div>
                                    <div class="">
                                        <label class="block font-medium text-gray-900">Conditie</label>
                                        <input type="text" name="conditie" placeholder="conditie" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                    </div>
                                </div>

                                <div class="">
                                    <label class="block font-medium text-gray-900">Fabriekscode</label>
                                    <input type="text" name="fabriek" placeholder="fabriekscode" required class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                </div>
                                <div class="flex space-x-2 lg:flex-row">
                                    <div class="">
                                        <label for="img">Foto 1:</label>
                                        <input type="text" name="img1" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                    </div>
                                    <div class="">
                                        <label for="img">Foto 2:</label>
                                        <input type="text" name="img2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                    </div>
                                </div>
                                <div class="flex space-x-2 lg:flex-row">
                                    <div class="">
                                        <label for="img">Foto 3:</label>
                                        <input type="text" name="img3" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                    </div>
                                    <div class="">
                                        <label for="img">Foto 4:</label>
                                        <input type="text" name="img4" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                    </div>
                                </div>
                                <div class="">
                                    <label class="block font-medium text-gray-900">Omschrijving</label>
                                    <textarea name="omschrijving" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-1" required cols="20" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <h3 class="mb-1 text-lg font-medium text-black">Nieuwe aanbieding</h3>
                                <div class="">
                                    <label class="block  font-medium text-gray-900">Inlever prijs</label>
                                    <input type="number" name="inlever" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="prijs na inleveren" required>
                                </div>
                                <div class="">
                                    <label class="block font-medium text-gray-900">Aantal punten</label>
                                    <input type="number" name="punten" id="" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="Aantal punten" required>
                                </div>

                                <div class="">
                                    <label class="block font-medium text-gray-900">Categorie</label>
                                    <select name="categorie" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                        <option selected hidden>Kies een categorie</option>
                                        <?php
                                        $sqlcategorie = "SELECT * FROM categorie";
                                        $resultcategorie = db()->query($sqlcategorie);
                                        if ($resultcategorie->num_rows > 0) {
                                            // output data of each row
                                            while ($categorie = $resultcategorie->fetch_assoc()) {
                                                if($categorie['actief'] == 'actief'){
                                        ?>
                                                <option value="<?php echo $categorie['id'] ?>"><?php echo $categorie['naam'] ?></option>
                                        <?php
                                        }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="flex space-x-2 lg:flex-row">
                                </div>
                                <button type="submit" name="nieuweaanbieding" class="knop rounded-lg font-semibold px-3 py-1 lg:px-5 mt-6 text-white">Maak een nieuwe aanbieding</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include '../layout/footer.php' ?>