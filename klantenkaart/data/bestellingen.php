<?php include '../layout/header.php' ?>
<div style="background-color: #f7f7f7;" class="flex flex-col lg:flex-row lg:justify-center w-full flex-wrap">
    <div class="flex items-center flex-col bg-white border-2 border-black my-5 lg:ml-5 py-2 lg:p-4 w-full lg:w-11/12 rounded">
        <h1 class="text-3xl font-bold">Bestellingen</h1>
        <?php
        if(isset($_POST['zoeksql'])){}
        if (isset($_POST['bestelzoek'])) {
            $bonid = NULL;
            $gebruikt = NULL;
            //verstuurt data voor zoeken
            if (isset($_POST['bonid'])) {
                $bonid = $_POST['bonid'];
            }
            if (isset($_POST['gebruikt'])) {
                $gebruikt = $_POST['gebruikt'];
            }
            $sql = zoekbon($bonid, $gebruikt, $_SESSION['id']);
            $start = 12 * ($_GET['page'] - 1);
            $result_totaal = db()->query($sql);
            if ($_GET['page'] == 1) {
                $start = 0;
            }
            if ($_GET['page'] == 2) {
                $start = 12;
            }
            $sql = $sql . " LIMIT $start, 12";
        } else {
            // haalt data op afhankelijk van de gebruiker rol
            if ($_SESSION['rol'] == 1) {
                $start = 1 * ($_GET['page'] - 1);
                $sql = "SELECT * FROM bestelling ORDER BY datum DESC";
                $result_totaal = db()->query($sql);
                if ($_GET['page'] == 1) {
                    $start = 0;
                }
                if ($_GET['page'] == 2) {
                    $start = 12;
                }
                $sql = "SELECT * FROM bestelling ORDER BY datum DESC LIMIT $start, 12";
            } elseif ($_SESSION['rol'] == 0) {
                $id = $_SESSION['id'];
                $start = 12 * ($_GET['page'] - 1);
                $sql = "SELECT * FROM bestelling WHERE gebruikerid = $id ORDER BY datum DESC";
                $result_totaal = db()->query($sql);
                if ($_GET['page'] == 1) {
                    $start = 0;
                }
                if ($_GET['page'] == 2) {
                    $start = 12;
                }
                $sql = "SELECT * FROM bestelling WHERE gebruikerid = $id ORDER BY datum DESC LIMIT $start, 12";
            }
        }
        ?>
        <!-- zoekformulier bestellingen -->
        <form method="post" action="bestellingen.php?page=1" class="w-full lg:w-4/5 my-4">
            <div class="relative">
                <div class="absolute  left-0 top-4 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <?php if (isset($bonid)) { ?>
                    <input type="search" name="bonid" value="<?php echo $bonid ?>" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Zoek het bonnummer">
                <?php } else { ?>
                    <input type="search" name="bonid" <?php  ?> class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Zoek het bonnummer">
                <?php } ?>
                <style>
                    .knop {
                        background-color: #39b93c;
                    }

                    .knop:hover {
                        background-color: #ed1c24;
                    }
                </style>
                <button type="submit" name="bestelzoek" class="knop text-white absolute right-3 top-2.5 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Zoek</button>
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
        <!-- clear search knop -->
        <?php if (isset($_POST['bestelzoek'])) { ?>
            <form action="../src/clear.php" method="post">
                <button type="submit" name="clearbestel" class="knoptext-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-4 lg:text-lg lg:px-4 lg:py-2">Clear</button>
            </form>
        <?php } ?>
    </div>
    <div class="flex flex-col items-center">
        <div class="flex flex-wrap  justify-center">
            <?php
            $result = db()->query($sql);
            // haalt data voor bestellingen op
            if ($result->num_rows > 0) {
                // output data of each row
                while ($data = $result->fetch_assoc()) {
                    // haalt data voor aanbiedingen op
                    $aanbieding = $data['aanbiedingid'];
                    $sql2 = "SELECT * FROM aanbieding WHERE id = $aanbieding";
                    $result2 = db()->query($sql2);
                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while ($data2 = $result2->fetch_assoc()) {

                            // haalt data voor de producten op
                            $product = $data2['product_id'];
                            $sql3 = "SELECT * FROM product WHERE id = $product";
                            $result3 = db()->query($sql3);
                            if ($result3->num_rows > 0) {
                                // output data of each row
                                while ($data3 = $result3->fetch_assoc()) {
                                    // haalt data voor de gebruiker op
                                    $gebruiker = $data['gebruikerid'];
                                    $sql4 = "SELECT * FROM gebruikers WHERE id = $gebruiker";
                                    $result4 = db()->query($sql4);
                                    if ($result4->num_rows > 0) {
                                        // output data of each row
                                        while ($data4 = $result4->fetch_assoc()) { ?>
                                            <!-- border-2 border-black -->
                                            <div class="flex justify-center flex-col my-1 lg:ml-5 w-full lg:w-5/12 rounded-lg space-y-1 lg:space-y-0">
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
                                                                <td class="pl-1"><?php echo $data2['punten']?></td>
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
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                                <!-- Main modal om bestellingen te verzilveren -->
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
                                                                    Aanbieding: <?php echo $data3['naam'] ?><br>
                                                                    Prijs: €<?php echo number_format($data2['prijs'], 2) ?>
                                                                </h3>
                                                                <div class="flex justify-center space-x-2">


                                                                    <form action="../src/database.php" method="post">
                                                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                                        <input type="hidden" name="gebruikt" value="<?php echo $data['gebruikt'] ?>">
                                                                        <input type="hidden" name="bestelling" value="true">
                                                                        <?php if ($data['gebruikt'] == "nee") { ?>
                                                                            <button type="submit" name="verzilver" class="knop rounded-lg px-3 py-1 lg:px-5 text-white">
                                                                                Verzilveren
                                                                            </button>
                                                                        <?php } elseif ($data['gebruikt'] == "ja") { ?>
                                                                            <button type="submit" name="verzilver" class="knop rounded-lg px-3 py-1 lg:px-5 text-white">
                                                                                Herstellen
                                                                            </button>
                                                                        <?php } ?>
                                                                    </form>
                                                                    <button data-modal-hide="bon-modal<?php echo $data['id'] ?>" class="rounded-lg  bg-blue-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-blue-800">Annuleer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            <?php
                                            }
                                        }
                                    }
                                }
                            }
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
                    <a href="bestellingen.php?page=<?php echo $previous ?>" class="block px-3 py-2 ml-0 leading-tight text-black bg-white border border-gray-300 rounded-l-lg hover:bg-gray-200 hover:text-gray-700">
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
                                <a href="bestellingen.php?page=<?php echo $i ?>" aria-current="page" class="z-10 px-3 py-2 leading-tight font-semibold text-white border border-red-500 bg-red-500 hover:bg-red-600 hover:text-white"><?php echo $i ?></a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="bestellingen.php?page=<?php echo $i ?>" class="px-3 py-2 leading-tight text-black bg-white border font-semibold border-gray-300 hover:bg-red-500 hover:border-red-500 hover:text-white"><?php echo $i ?></a>
                            </li>
                <?php
                        }
                    }
                    $i++;
                }
                ?>
                <li>
                    <?php if (isset($zoek)) { ?>
                        <form action="bestellingen.php?page=<?php echo $next ?>" method="post">
                            <button type="submit" name="zoeksql" class="block px-3 py-2 leading-tight text-black bg-white border border-gray-300 rounded-r-lg hover:bg-gray-200 hover:text-gray-700">
                                <span class="sr-only">Next</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </form>
                    <?php } else { ?>
                    <a href="bestellingen.php?page=<?php echo $next ?>" class="block px-3 py-2 leading-tight text-black bg-white border border-gray-300 rounded-r-lg hover:bg-gray-200 hover:text-gray-700">
                        <span class="sr-only">Next</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php include '../layout/footer.php' ?>