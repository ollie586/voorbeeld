<?php include '../layout/header.php';
// print_r($_POST);
// stuurt alle data voor zoeken
$actief = null;
$voornaam = null;
$achternaam = null;
$bedrijf = null;
if (isset($_POST['search'])) {
    if (isset($_POST['actief'])) {
        $actief = $_POST['actief'];
    }
    if (isset($_POST['voornaam'])) {
        $voornaam = $_POST['voornaam'];
    }
    if (isset($_POST['achternaam'])) {
        $achternaam = $_POST['achternaam'];
    }
    if (isset($_POST['bedrijf'])) {
        $bedrijf = $_POST['bedrijf'];
    }
    unset($_POST['voornaam']);
    unset($_POST['achternaam']);
    unset($_POST['bedrijf']);
    unset($_POST['actief']);
    $sql = zoekklant($actief, $voornaam, $achternaam, $bedrijf);
    $start = 9 * ($_GET['page'] - 1);
    $result_totaal = db()->query($sql);
    if ($_GET['page'] == 1) {
        $start = 0;
    }
    if ($_GET['page'] == 2) {
        $start = 9;
    }
    $sql = $sql . " LIMIT $start, 9";
} else {
    $sql = "SELECT * FROM gebruikers";
    $start = 9 * ($_GET['page'] - 1);
    $result_totaal = db()->query($sql);
    if ($_GET['page'] == 1) {
        $start = 0;
    }
    if ($_GET['page'] == 2) {
        $start = 9;
    }
    $sql = "SELECT * FROM gebruikers LIMIT $start, 9";
}
?>
<script src="../js/jquery-3.6.3.min.js"></script>
<div style="background-color: #f7f7f7;" class="flex flex-row lg:flex-row lg:justify-center mx-30 flex-wrap space-y-3">
    <div class="w-full mt-3 lg:ml-10">
        <div class="absolute mt-4 left-50 top-110 flex w-2/5 items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <!-- zoek formulier voor gebruiken -->
        <form action="klanten.php?page=1" method="post" class="flex flex-col lg:flex-row items-center space-y-1 lg:space-x-1">
            <?php if (isset($voornaam)) { ?>
                <input type="search" name="voornaam" value="<?php echo $voornaam; ?>" placeholder="Voornaam" class="w-full lg:w-3/12 lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } else { ?>
                <input type="search" name="voornaam" placeholder="Voornaam" class="w-full mt-1 lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } ?>

            <?php if (isset($achternaam)) { ?>
                <input type="search" name="achternaam" value="<?php echo $achternaam ?>" placeholder="Achternaam" class="w-full lg:w-3/12 lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } else { ?>
                <input type="search" name="achternaam" placeholder="Achternaam" class="w-full lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } ?>

            <?php if (isset($bedrijf)) { ?>
                <input type="search" name="bedrijf" placeholder="Bedrijf" value="<?php echo $bedrijf ?>" class="w-full lg:w-3/12 lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } else { ?>
                <input type="search" name="bedrijf" placeholder="Bedrijf" class="w-full lg:w-3/12 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <?php } ?>

            <ul class="flex justify-end space-x-6 items-center">
                <li>
                    <?php if ($actief == "actief") { ?>
                        <p><input type="radio" checked name="actief" value="actief" class="mr-1 bg-gray-100">Actief</input></p>
                    <?php } else { ?>
                        <p><input type="radio" name="actief" value="actief" class="mr-1 bg-gray-100">Actief</input></p>
                    <?php } ?>
                </li>
                <li>
                    <?php if ($actief == "inactief") { ?>
                        <p><input type="radio" checked name="actief" value="inactief" class="mr-1 bg-gray-100">Inactief</input></p>
                    <?php } else { ?>
                        <p><input type="radio" name="actief" value="inactief" class="mr-1 bg-gray-100">Inactief</input></p>
                    <?php } ?>
                </li>
            </ul>
            <style>
                .knop {
                    background-color: #39b93c;
                }

                .knop:hover {
                    background-color: #ed1c24;
                }
            </style>
            <button type="submit" name="search" class="knop text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-4 lg:text-lg lg:px-4 lg:py-2">Zoek</button>
            <?php if (isset($_POST['search'])) { ?>
                <form action="../../src/clear.php" method="post">
                    <button type="submit" name="clearklant" class="knop text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-4 lg:text-lg lg:px-4 lg:py-2">Clear</button>
                </form>
            <?php } ?>
        </form>
    </div>
    <div class="flex flex-col items-center w-100">
        <div class="flex flex-wrap justify-center lg:space-x-2 space-y-2">
            <?php
            // haalt data van alle gebruikers op
            // echo $sql;
            $result = db()->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($data = $result->fetch_assoc()) {
                    //admin check
                    if ($data['rol'] == 1) { ?>
                        <div class="flex justify-center bg-blue-500 border-2 border-black p-0.5 w-11/12 lg:w-fit rounded">
                            <div class="w-fit h-full flex flex-col space-x-0 lg:p-1">
                                <div class="bg-white w-full h-full rounded flex align-center flex-col">
                                    <table class="w-full h-full">
                                        <tr class="border-2 border-black rounded bg-red-600 h-fit">
                                            <th colspan="2" class="text-gray-900 font-bold h-fit p-0">
                                                <div class="w-full  flex justify-center">
                                                    <a href="../detail/profiel.php?id=<?php echo $data['id'] ?>">
                                                        <div class="hover:text-black-900">
                                                            <?php echo $data['bedrijf'] . "<br>(" . $data['voornaam'] . " " . $data['achternaam'] . ")"; ?>
                                                        </div>
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Adres:</th>
                                            <td class="pl-1"><?php echo $data['straat'] . " " . $data['huisnummer']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Plaats:</th>
                                            <td class="pl-1"><?php echo $data['plaats']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Postcode:</th>
                                            <td class="pl-1"> <?php echo $data['postcode']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Email:</th>
                                            <td class="pl-1"> <?php echo $data['email']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Telefoon:</th>
                                            <td class="pl-1"> <?php echo $data['telefoon']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Klantnummer:</th>
                                            <td class="pl-1"> <?php echo $data['ww']; ?></td>
                                        </tr>
                                    </table>
                                    <button id="bewerkgegevensadmin" data-modal-toggle="gegevens-modal<?php echo $data['id'] ?>" class="knop border-2 border-t-0 border-black font-bold w-full px-3 py-1 lg:px-5 text-white">Bewerk gegevens</button>
                                </div>
                                <div class="flex flex-col items-center bg-white border-2 border-t-0 border-black w-full flex">
                                    <div class="flex flex-row space-x-1">
                                        <h1 class="text-2xl text-bold items-center font-bold">Saldo:</h1>
                                        <p class="text-xl text-gray-700"><?php echo $data['punten']; ?> megabyte</p>
                                    </div>
                                    <form action="../src/database.php" method="post" class="flex flex-row justify-center space-x-1 ">
                                        <input type="hidden" name="klant" value="true">
                                        <input type="hidden" name="punten_nu" value="<?php echo $data['punten'] ?>">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                        <button type="submit" name="neem" class="rounded-lg font-bold text-sm bg-red-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-red-800">Neem<br>megabyte</button>
                                        <input type="number" name="punten" value="0" class="bg-gray-100 text-black my-1 w-2/5 h-10 border border-gray-300 rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                        <button type="submit" name="geef" class="rounded-lg font-bold text-sm bg-green-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-green-800">Geef<br>megabyte</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                    //admin check
                    if ($data['rol'] == 0) { ?>
                        <div class="flex flex-col justify-center bg-red-500 border-2 border-black p-0.5 w-11/12 lg:w-fit rounded space-x-1 h-fit">
                            <div class="w-full  flex flex-col space-x-0 lg:p-1">
                                <div class="w-full bg-white flex flex-col">
                                    <table class="w-full h-full">
                                        <tr class="border-2 border-black rounded bg-blue-400">
                                            <th colspan="2" class=" text-black">
                                                <div class="w-full flex justify-center">
                                                    <a href="../detail/profiel.php?id=<?php echo $data['id'] ?>">
                                                        <div class="hover:text-black cursor-pointer">
                                                            <?php echo $data['bedrijf'] . "<br>(" . $data['voornaam'] . " " . $data['achternaam'] . ")"; ?>
                                                        </div>
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Adres:</th>
                                            <td class="pl-1"> <?php echo $data['straat'] . " " . $data['huisnummer']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Plaats:</th>
                                            <td class="pl-1"> <?php echo $data['plaats']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Postcode:</th>
                                            <td class="pl-1"> <?php echo $data['postcode']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Email:</th>
                                            <td class="pl-1"> <?php echo $data['email']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Telefoon:</th>
                                            <td class="pl-1"> <?php echo $data['telefoon']; ?></td>
                                        </tr>
                                        <tr class="border-2 border-black rounded">
                                            <th class=" border-2 border-black rounded bg-gray-300">Klantnummer:</th>
                                            <td class="pl-1"> <?php echo $data['ww']; ?></td>
                                        </tr>
                                    </table>
                                    <button id="bewerkgegevens<?php echo $data['id'] ?>" data-modal-toggle="gegevens-modal<?php echo $data['id'] ?>" class="knop border-2 border-t-0 border-black font-bold w-full bg-green-400 px-3 py-1 lg:px-5 text-white">Bewerk gegevens</button>
                                </div>

                                <div class="flex flex-col items-center bg-white border-2 border-t-0 border-black w-fit">
                                    <div class="flex flex-row space-x-1 justify-center">
                                        <h1 class="text-2xl text-bold items-center font-bold">Saldo:</h1>
                                        <p class="text-xl text-gray-700"><?php echo $data['punten']; ?> megabyte</p>
                                    </div>
                                    <form action="../src/database.php" method="post" class="flex flex-row justify-center space-x-1 mb-1 w-fit">
                                        <input type="hidden" name="klant" value="true">
                                        <input type="hidden" name="punten_nu" value="<?php echo $data['punten'] ?>">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                        <button type="submit" name="neem" class="rounded-lg font-bold text-sm bg-red-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-red-800">Neem<br>megabyte</button>
                                        <input type="number" name="punten" value="0" class="bg-gray-100 text-black my-1 w-2/5 h-10 border border-gray-300 rounded-lg focus:ring-black focus:border-black block w-full p-1">
                                        <button type="submit" name="geef" class="rounded-lg font-bold text-sm bg-green-400 px-2 py-1 lg:px-4 text-black hover:text-white hover:bg-green-800">Geef<br>megabyte</button>
                                    </form>
                                </div>

                                <div class="flex flex-col items-center bg-white border-2 border-t-0 border-black w-full lg:w-96 h-20">
                                    <!-- hoeveelheid punten laten zien en veranderen -->
                                    <?php if ($data['actief'] == "actief") { ?>
                                        <button data-modal-toggle="actief-modal<?php echo $data['id'] ?>" class="w-2/12 lg:w-2/12  bg-red-500 hover:bg-red-800 p-1 m-0 rounded-lg"><img class="h-1/10 w-1/10" src="../images/cross.png"></button>
                                    <?php } elseif ($data['actief'] == "inactief") { ?>
                                        <button data-modal-toggle="actief-modal<?php echo $data['id'] ?>" class="w-2/12 lg:w-2/12 bg-green-500 hover:bg-green-800 p-1 m-0 rounded-lg"><img src="../images/check.png"></button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Main modal om een gebruiker actief of uit te zetten -->
                    <div id="actief-modal<?php echo $data['id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-md md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow">
                                <button type="button" data-modal-toggle="actief-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="actief-modal<?php echo $data['id'] ?>">
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
                                                <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                <input type="hidden" name='actief' value="<?php echo $data['actief'] ?>">
                                                <!-- data-modal-toggle="inactief-modal" -->
                                                <button type="submit" name="update-actief" class="font-semibold bg-red-400 text-black hover:text-white hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Ja, zet op inactief
                                                </button>
                                            </form>
                                        <?php } elseif ($data['actief'] == "inactief") { ?>
                                            <form action="../src/database.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                                <input type="hidden" name='actief' value="<?php echo $data['actief'] ?>">
                                                <!-- data-modal-toggle="actief-modal" -->
                                                <button type="submit" name="update-actief" class="knop font-semibold text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Ja, zet op actief
                                                </button>
                                            </form>
                                        <?php } ?>
                                        <button data-modal-toggle="actief-modal<?php echo $data['id'] ?>" type="button" class="font-semibold bg-blue-300 text-black hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 focus:z-10">
                                            Annuleren
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main modal om de gegevens van een gebruiker aan te passen -->
                    <div id="gegevens-modal<?php echo $data['id'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-md md:h-auto">
                            <!-- Modal content -->
                            <div class="relative w-fit bg-white rounded-lg shadow">
                                <button type="button" class="absolute top-3 right-2.5 text-black bg-gray-200 hover:bg-black hover:text-white  rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="gegevens-modal<?php echo $data['id'] ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="px-6 py-6 lg:px-8">
                                    <h3 class="mb-4 text-xl font-medium text-black">Bewerk gegevens</h3>
                                    <form action="../src/database.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                        <input type="hidden" name="klant" value="true">
                                        <div class="flex space-x-2 lg:flex-row">
                                            <div>
                                                <label class="block font-medium text-gray-900">Voornaam</label>
                                                <input type="text" name="vnaam" id="vnaam" value="<?php echo $data['voornaam'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="voornaam" required>
                                            </div>
                                            <div>
                                                <label class="block font-medium text-gray-900">Achternaam</label>
                                                <input type="text" name="anaam" id="anaam" value="<?php echo $data['achternaam'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5" placeholder="achternaam" required>
                                            </div>
                                            <div>
                                                <label class="block font-medium text-gray-900">Bedrijfnaam</label>
                                                <input type="text" name="bedrijf" id="bedrijf" value="<?php echo $data['bedrijf'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="bedrijfnaam" required>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2 lg:flex-row">
                                            <div class="w-4/5">
                                                <label class="block font-medium text-gray-900">Straatnaam</label>
                                                <input type="text" name="straat" id="straat" value="<?php echo $data['straat'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="straatnaam" required>
                                            </div>
                                            <div class="w-1/5">
                                                <label class="block font-medium text-gray-900">nummer</label>
                                                <input type="text" name="hnummer" id="hnummer" value="<?php echo $data['huisnummer'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="4" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block font-medium text-gray-900">Plaats</label>
                                            <input type="text" name="plaats" id="plaats" value="<?php echo $data['plaats'] ?>" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 " placeholder="plaats" required>
                                        </div>
                                        <div>
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
                                        <button type="submit" name="bewerkgebruiker" class="knop rounded-lg font-semibold px-3 py-1 lg:px-5 mt-6 text-white">Bewerk gegevens</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            } else {
                echo "0 results";
            } ?>
        </div>
        <?php $pages = ceil($result_totaal->num_rows / 9);
        if ($pages == 0) {
            $pages = 1;
        } ?>
        <nav aria-label="Page navigation example" class="w-100 mt-5">
            <ul class="inline-flex items-center -space-x-px">
                <li>
                    <?php if (isset($_GET['page'])) {
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
                    } ?>
                    <a href="klanten.php?page=<?php echo $previous ?>" class="block px-3 py-2 ml-0 leading-tight text-black bg-white border border-gray-300 rounded-l-lg hover:bg-gray-200 hover:text-gray-700">
                        <span class="sr-only">Previous</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </li>
                <?php $i = 1;
                while ($i <= $pages) {
                    $minpage = $_GET['page'] - 5;
                    $maxpage = $_GET['page'] + 5;
                    if ($i > $minpage && $i < $maxpage) {
                        if ($i == $page) { ?>
                            <li>
                                <a href="klanten.php?page=<?php echo $i ?>" aria-current="page" class="z-10 px-3 py-2 leading-tight font-semibold text-white border border-red-500 bg-red-500 hover:bg-red-600 hover:text-white"><?php echo $i ?></a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="klanten.php?page=<?php echo $i ?>" class="px-3 py-2 leading-tight text-black bg-white border font-semibold border-gray-300 hover:bg-red-500 hover:border-red-500 hover:text-white"><?php echo $i ?></a>
                            </li>
                <?php }
                    }
                    $i++;
                } ?>
                <li>
                    <a href="klanten.php?page=<?php echo $next ?>" class="block px-3 py-2 leading-tight text-black bg-white border border-gray-300 rounded-r-lg hover:bg-gray-200 hover:text-gray-700">
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
<?php include '../layout/footer.php' ?>