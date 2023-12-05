<?php include '../layout/header.php'; ?>
<div style="background-color: #f7f7f7;" class="flex lg:flex-row lg:justify-center mx-30 flex-wrap">
    <?php $id = $_SESSION['id'];
    $sql = "SELECT * FROM gebruikers WHERE id = $id";
    $result = db()->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($data = $result->fetch_assoc()) { ?>
            <div class="flex justify-center flex-col bg-white border-2 border-black my-2 lg:my-5 lg:ml-7 lg:ml-5 p-4 w-full lg:w-2/5 rounded">
                <table class="w-full">
                    <tr class="bg-blue-400">
                        <th class="border-2 border-black text-black" colspan="2">Persoonlijke gegevens</th>
                    </tr>
                    <tr class="border-2 border-black">
                        <th class="border-2 border-black bg-gray-300">Naam:</th>
                        <td class="text-black pl-5"><?php echo $data['bedrijf'] . ' (' . $data['voornaam'] . ' ' . $data['achternaam'] . ')' ?></td>
                    </tr>
                    <tr class="border-2 border-black">
                        <th class="border-2 border-black bg-gray-300">Adres:</th>
                        <td class="text-black pl-5"><?php echo $data['straat'] . ' ' . $data['huisnummer'] ?></td>
                    </tr>
                    <tr class="border-2 border-black">
                        <th class="border-2 border-black bg-gray-300">Plaats:</th>
                        <td class="text-black pl-5"><?php echo $data['plaats'] ?></td>
                    </tr>
                    <tr class="border-2 border-black">
                        <th class="border-2 border-black bg-gray-300">Postcode:</th>
                        <td class="text-black pl-5"><?php echo $data['postcode'] ?></td>
                    </tr>
                    <tr class="border-2 border-black">
                        <th class="border-2 border-black bg-gray-300">Email:</th>
                        <td class="text-black pl-5"><?php echo $data['email'] ?></td>
                    </tr>
                    <tr class="border-2 border-black rounded">
                        <th class=" border-2 border-black rounded bg-gray-300">Telefoon:</th>
                        <td class="text-black pl-5"><?php echo $data['telefoon'] ?></td>
                    </tr>
                    <tr class="border-2 border-black rounded">
                        <th class=" border-2 border-black rounded bg-gray-300">Klantnummer:</th>
                        <td class="text-black pl-5"> <?php echo $data['ww']; ?></td>
                    </tr>
                </table>
                <!-- Modal toggle -->
                <button data-modal-toggle="gegevens-modal" class="font-bold lg:font-semibold text-xl lg:text-base rounded-lg bg-green-400 px-3 lg:px-5 py-5 lg:py-1 mt-2 lg:mt-6 text-white hover:bg-green-800">Bewerk gegevens</button>
            </div>
            <div class="bg-white flex flex-col items-center border-2 border-black my-2 lg:my-5 lg:ml-5 p-4 w-full lg:w-2/5 rounded">
                <h1 class="text-5xl text-bold items-center">Saldo</h1>
                <p class="text-2xl text-gray-700"><?php echo $data['punten'] ?> megabyte</p>
                <form action="../src/database.php" method="post">
                    <div class="flex flex-col lg:flex-row place-content-center space-y-2 lg:space-x-2">
                        <input type="hidden" name="admin" value="true">
                        <input type="hidden" name="punten_nu" value="<?php echo $data['punten'] ?>">
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                        <button type="submit" name="neem" class="font-semibold text-xl lg:text-base rounded-lg bg-red-400 px-3 py-4 lg:py-1 lg:px-5  lg:mt-6 text-black hover:text-white hover:bg-red-800">Neem megabyte</button>
                        <input type="number" name="punten" value="0" class="bg-gray-100 text-black w-fit text-xl lg:mt-6 h-12 border border-gray-300 rounded-lg focus:ring-black focus:border-black block w-full p-1">
                        <button type="submit" name="geef" class="font-semibold text-xl lg:text-base rounded-lg bg-green-400 px-3 py-4 lg:py-1 lg:px-5 lg:mt-6 text-black hover:text-white hover:bg-green-800">Geef megabyte</button>
                    </div>
                </form>
                <a href="../data/aanbiedingen.php?page=1"><button class="font-semibold rounded-lg text-xl bg-blue-300 px-5 py-3 lg:px-5 mt-6 text-black hover:text-white hover:bg-blue-800">Aanbiedigen bekijken</button></a>
            </div>
            <?php
            if (isset($_POST['adminzoek'])) {
                $bonid = NULL;
                $gebruikt = NULL;
                if (isset($_POST['bonid'])) {
                    $bonid = $_POST['bonid'];
                }
                if (isset($_POST['gebruikt'])) {
                    $gebruikt = $_POST['gebruikt'];
                }
                // zorgt ervoor dat je bestellingen kunt zoeken
                $sql = zoekbonadmin($bonid, $gebruikt);
            } else {
                $sql = "SELECT * FROM bestelling ORDER BY datum DESC LIMIT 6";
            }
            ?>
            <div class="flex items-center flex-col bg-white border-2 border-black my-2 lg:my-5 lg:ml-5 py-2 lg:p-4 w-full lg:w-4/5 rounded">
                <h1 class="text-3xl font-bold">Bestellingen</h1>
                <form method="post" action='profieladmin.php' class="w-full lg:w-4/5 my-4">
                    <div class="relative">
                        <div class="absolute  left-0 top-4 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <style>
                            .knop {
                                background-color: #39b93c;
                            }

                            .knop:hover {
                                background-color: #ed1c24;
                            }
                        </style>
                        <?php if (isset($bonid)) { ?>
                            <input type="search" name="bonid" value="<?php echo $bonid ?>" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Zoek het bonnummer">
                        <?php } else { ?>
                            <input type="search" name="bonid" <?php  ?> class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Zoek het bonnummer">
                        <?php } ?> <button type="submit" name="adminzoek" class="knop text-white absolute right-3 top-2.5 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 lg:px-4 py-2">Zoek</button>
                        <ul class="flex space-x-6 justify-end">
                            <li>
                                <?php if (isset($gebruikt) && $gebruikt == "ja") { ?>
                                    <p class=""><input type="radio" checked name="gebruikt" value="ja" class="mr-1 bg-gray-100">Gebruikt</input></p>
                                <?php } else { ?>
                                    <p class=""><input type="radio" name="gebruikt" value="ja" class="mr-1 bg-gray-100">Gebruikt</input></p>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if (isset($gebruikt) && $gebruikt == "nee") { ?>
                                    <p class=""><input type="radio" checked name="gebruikt" value="nee" class="mr-1 bg-gray-100">Ongebruikt</input></p>
                                <?php } else { ?>
                                    <p class=""><input type="radio" name="gebruikt" value="nee" class="mr-1 bg-gray-100">Ongebruikt</input></p>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </form>
                <?php
                if (isset($_POST['adminzoek'])) {
                ?>
                    <form action="../src/clear.php" method="post">
                        <button type="submit" name="clearadmin" class=" knop font-semibold text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-4 lg:text-lg lg:px-4 lg:py-2">Clear</button>
                    </form>
                <?php
                }
                ?>
        <?php }
    } ?>
        <div class="flex flex-row justify-center flex-wrap">
            <?php
            // haalt alle data voor de bestellingen
            $result = db()->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($data = $result->fetch_assoc()) {

                    $aanbieding = $data['aanbiedingid'];
                    $sql2 = "SELECT * FROM aanbieding WHERE id = $aanbieding";
                    $result2 = db()->query($sql2);
                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while ($data2 = $result2->fetch_assoc()) {

                            $product = $data2['product_id'];
                            $sql3 = "SELECT * FROM product WHERE id = $product";
                            $result3 = db()->query($sql3);
                            if ($result3->num_rows > 0) {
                                // output data of each row
                                while ($data3 = $result3->fetch_assoc()) {

                                    $gebruiker = $data['gebruikerid'];
                                    $sql4 = "SELECT * FROM gebruikers WHERE id = $gebruiker";
                                    $result4 = db()->query($sql4);
                                    if ($result4->num_rows > 0) {
                                        // output data of each row
                                        while ($data4 = $result4->fetch_assoc()) { ?>
                                            <div class="flex justify-center flex-col  my-1 lg:ml-5 w-full lg:w-5/12 rounded-lg  space-y-1 lg:space-y-0">
                                                <a href="../detail/product.php?id=<?php echo $data2['id'] ?>" class="w-full border-2 border-black rounded-t-lg bg-blue-400  text-black hover:text-red-900 flex justify-center font-bold py-1 text-lg">
                                                    <?php echo $data3['merk'] . " " . $data3['naam'] ?>
                                                </a>
                                                <div class="flex flex-col lg:flex-row">
                                                    <div class="bg-white w-full lg:w-2/5 border-2 border-black rounded-bl-lg">
                                                        <table class="w-full h-full rounded-bl-lg">
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Bonnummer:</th>
                                                                <td class="pl-1"><?php echo $data['id'] ?></td>
                                                            </tr>
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Prijs:</th>
                                                                <td class="pl-1">€<?php echo number_format($data2['prijs'], 2) ?></td>
                                                            </tr>
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Advies:</th>
                                                                <td class="pl-1">€<?php echo number_format($data3['prijs'], 2) ?></td>
                                                            </tr>
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Megabyte:</th>
                                                                <td class="pl-1"><?php echo $data2['punten'] ?></td>
                                                            </tr>
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Categorie:</th>
                                                                <td class="pl-1">
                                                                <?php $sql5 = 'SELECT * FROM categorie WHERE id =' . $data2['categorie']; 
                                                                    $result5 = db()->query($sql5);
                                                                    if ($result5->num_rows > 0) {
                                                                        // output data of each row
                                                                        while ($data5 = $result5->fetch_assoc()) {
                                                                            echo $data5['naam'];
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr class="border-b-2 border-black">
                                                                <th class="border-r-2 border-black bg-gray-300">Klant:</th>
                                                                <td class="pl-1"><a class="text-red-500 hover:text-red-900" href="../detail/profiel.php?id=<?php echo $data4['id'] ?>"><?php echo $data4['voornaam'] . ' ' . $data4['achternaam'] ?></a></td>
                                                            </tr>
                                                            <tr class="rounded-bl-lg">
                                                                <th class="border-r-2 border-black rounded-bl-lg bg-gray-300">Bedrijf:</th>
                                                                <td class="pl-1"><?php echo $data4['bedrijf'] ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="w-full lg:w-2/5 bg-white lg:p-1 flex flex-row flex-wrap lg:none border-y-2 border-black">
                                                        <a href="../detail/product.php?id=<?php echo $data2['id'] ?>" class="w-full h-full">
                                                            <img class="w-full h-full" src="<?php echo $data3['foto1'] ?>">
                                                        </a>
                                                    </div>
                                                    <div class="flex items-center space-y-2 flex-col bg-white rounded-br-lg w-full lg:w-1/5 py-1 border-2 border-black">
                                                        <h1 class="text-2xl lg:text-xl font-semibold items-center">Gebruikt</h1>
                                                        <p class="text-xl text-gray-700"><?php echo $data['gebruikt'] ?></p>
                                                        <div class="flex flex-col items-center">
                                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                                                <?php if ($data['gebruikt'] == "nee") { ?>
                                                                    <button data-modal-toggle="bon-modal<?php echo $data['id'] ?>" class="knop w-11/12 rounded-lg font-semibold text-xl lg:text-sm px-3 py-3 lg:py-1 text-white">Verzilver</button>
                                                                <?php } elseif ($data['gebruikt'] == "ja") { ?>
                                                                    <button data-modal-toggle="bon-modal<?php echo $data['id'] ?>" class="knop w-11/12 rounded-lg font-semibold text-xl lg:text-sm px-3 py-3 lg:py-1 text-white">Herstellen</button>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <form action="../detail/pdf.php" target="_blank" method="post" class="ml-2 mt-2 w-full">
                                                                <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                                <input type="hidden" name="naam" value="<?php echo $data4['voornaam'] . " " . $data4['achternaam'] ?>">
                                                                <input type="hidden" name="bedrijf" value="<?php echo $data4['bedrijf'] ?>">
                                                                <input type="hidden" name="datum" value="<?php echo date("d-m-Y", strtotime($data['datum'])); ?>">
                                                                <input type="hidden" name="product" value="<?php echo $data3['merk'] . " " . $data3['naam'] ?>">
                                                                <input type="hidden" name="prijs" value="<?php echo number_format($data2['prijs'], 2) ?>">
                                                                <input type="hidden" name="punten" value="<?php echo $data2['punten'] ?>">
                                                                <button name="kijk" class="w-11/12 font-semibold rounded-lg text-xl lg:text-sm bg-blue-400 mb-2 px-3 py-3 lg:py-1 text-black hover:text-white hover:bg-blue-800">Bekijk voucher</button>
                                                                <button name="download" class="w-11/12 font-semibold rounded-lg text-xl lg:text-sm bg-blue-400 px-3 py-3 lg:py-1 text-black hover:text-white hover:bg-blue-800">Download voucher</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Main modal -->
                                            <div id="bon-modal<?php echo $data['id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                                <div class="relative w-full h-full max-w-md md:h-auto">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="bon-modal<?php echo $data['id'] ?>">
                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-6 text-center">

                                                            <h3 class="mb-2 text-lg font-normal text-gray-500">
                                                                Bonnummer: <?php echo $data['id'] ?><br>
                                                                Klant: <?php echo $data4['bedrijf'] . " " . $data4['voornaam'] . ' ' . $data4['achternaam'] . ")" ?><br>
                                                                Aanbieding: <?php echo $data3['merk'] . ' ' . $data3['onderdeel'] ?><br>
                                                                Prijs: €<?php echo $data2['prijs'] ?>
                                                            </h3>
                                                            <div class="flex justify-center space-x-2">


                                                                <form action="../src/database.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                                    <input type="hidden" name="gebruikt" value="<?php echo $data['gebruikt'] ?>">
                                                                    <input type="hidden" name="admin" value="true">
                                                                    <?php if ($data['gebruikt'] == "nee") { ?>
                                                                        <button type="submit" name="verzilver" class=" font-semibold rounded-lg bg-green-400 px-3 py-1 lg:px-5   text-black hover:text-white hover:bg-green-800">
                                                                            Verzilveren
                                                                        </button>
                                                                    <?php } elseif ($data['gebruikt'] == "ja") { ?>
                                                                        <button type="submit" name="verzilver" class="font-semibold rounded-lg bg-green-400 px-3 py-1 lg:px-5   text-black hover:text-white hover:bg-green-800">
                                                                            Herstellen
                                                                        </button>
                                                                    <?php } ?>
                                                                </form>
                                                                <button data-modal-hide="bon-modal<?php echo $data['id'] ?>" class="rounded-lg font-semibold bg-blue-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-blue-800">Annuleer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            <?php }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            ?>

        </div>


            </div>
</div>
<?php $id = $_SESSION['id'];
$sql = "SELECT * FROM gebruikers WHERE id = $id";
$result = db()->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($data = $result->fetch_assoc()) { ?>
        <!-- Main modal -->
        <div id="gegevens-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-md md:h-auto">
                <!-- Modal content -->
                <div class="relative w-fit bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 right-2.5 text-black bg-gray-200 hover:bg-black hover:text-white  rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="gegevens-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-black">Bewerk gegevens</h3>
                        <form class="" action="../src/database.php" method="post">

                            <input type="hidden" id="id" name="id" value="<?php echo $data['id'] ?>">
                            <input type="hidden" name="admin" value="true">
                            <div class="flex space-x-2 lg:flex-row">
                                <div class="">
                                    <label class="block font-medium text-gray-900">Voornaam</label>
                                    <input type="text" name="vnaam" id="vnaam" value="<?php echo $data['voornaam'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="voornaam" required>
                                </div>
                                <div class="">
                                    <label class="block font-medium text-gray-900">Achternaam</label>
                                    <input type="text" name="anaam" id="anaam" value="<?php echo $data['achternaam'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5" placeholder="achternaam" required>
                                </div>
                                <div class="">
                                    <label class="block font-medium text-gray-900">Bedrijfnaam</label>
                                    <input type="text" name="bedrijf" id="bedrijf" value="<?php echo $data['bedrijf'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="bedrijfnaam" required>
                                </div>
                            </div>

                            <div class="flex space-x-2 lg:flex-row">                               
                                <div class=" w-4/5">
                                    <label class="block font-medium text-gray-900">Straatnaam</label>
                                    <input type="text" name="straat" id="straat" value="<?php echo $data['straat'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="straatnaam" required>
                                </div>
                                <div class="w-1/5">
                                    <label class="block font-medium text-gray-900">nummer</label>
                                    <input type="text" name="hnummer" id="hnummer" value="<?php echo $data['huisnummer'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="4" required>
                                </div>
                            </div>
                            <div class="">
                                <label class="block font-medium text-gray-900">Plaats</label>
                                <input type="text" name="plaats" id="plaats" value="<?php echo $data['plaats'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="plaats" required>
                            </div>
                            <div class="">
                                <label class="block font-medium text-gray-900">Postcode</label>
                                <input type="text" name="pcode" id="pcode" value="<?php echo $data['postcode'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="postcode" required>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-900">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo $data['email'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="naam@gmail.com" required>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-900">Telefoonnummer</label>
                                <input type="text" name="telefoon" id="telefoon" value="<?php echo $data['telefoon'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="12345545" required>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-900">Klantnummer</label>
                                <input type="text" name="klantnummer" id="email" value="<?php echo $data['ww'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="naam@gmail.com" required>
                            </div>
                            <button type="submit" name="bewerkgebruiker" class="font-semibold rounded-lg bg-blue-400 px-3 py-1 lg:px-5 mt-6  text-black hover:text-white hover:bg-blue-800">Bewerk gegevens</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>


<?php include '../layout/footer.php' ?>