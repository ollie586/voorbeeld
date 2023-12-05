<?php
include("src/functies.php");
$_SESSION['inlog'] = NULL;
$_SESSION['id'] = NULL;
$_SESSION['rol'] = NULL;
// session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="images/web_logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
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
            <!-- component -->
            <nav class="flex items-center justify-between flex-wrap">
                <div class=" w-full flex-grow flex flex-row justify-center items-center lg:w-auto ">
                    <ul class="flex justify-center flex-row">
                        <li class="p-2">
                            <a href="index.php" style="font-family: Poppins" class="text-base text-red-500 font-semibold">Login</a>
                        </li>
                        <li class="p-2">
                            <a href="showcase.php?page=1" style="font-family: Poppins" class="text-base text-gray-600 font-bold hover:text-red-500">Aanbiedingen</a>
                    </ul>
                </div>
            </nav>
        </div>
        <img src="images/banner2.jpg" class="h-48 w-full hidden lg:block">
        <img src="images/banner_mobile.jpg" class="h-36 w-full  lg:hidden">


        <div style="background-color: #f7f7f7;" class="flex flex-col lg:flex-row lg:justify-center mx-30 flex-wrap">
            <div class=" flex justify-center border-2 border-red-600 m-5 ml-7 lg:ml-5 w-5/6 lg:w-1/4 rounded-lg ">
                <div style="background-color: #f7f7f7;" class="p-1 rounded-lg">
                    <p>Welkom bij de klantkaart pagina van dPC Solutions. Hier kunt u als klant bijvoorbeeld bekijken hoeveel punten u gespaart heeft, welke extra aanbiedingen er voor u zijn en voor welke producten en kortingen u kunt sparen. Iedereen die met sparen begint krijgt van ons de eerste 50 punten!</p>
                    <br>
                    <style>
                        .knop
                        {
                            background-color: #39b93c;
                        }
                        .knop:hover
                        {
                            background-color: #ed1c24;
                        }
                    </style>
                    <p>Hier kunt uw onze <a href="showcase.php?page=1" class="knop rounded-lg p-2 font-semibold text-gray-700 hover:bg-blue-700 text-white">Aanbiedingen</a> alvast bekijken</p>
                </div>
            </div>
            <div  class="flex justify-center border-2 border-blue-300 m-5 ml-7 lg:ml-5 w-5/6 lg:w-2/5 rounded-lg">
                <div style="background-color: #f7f7f7;" class="p-1 w-full bg-white rounded-lg">
                    <?php
                    // checkt de login
                    if (isset($_POST['login'])) {
                        $email = $_POST['email'];
                        $klantnummer = $_POST['klantnummer'];
                        login($email, $klantnummer);
                        $error = login($email, $klantnummer);
                    }
                    ?>

                    <form action="index.php" method="POST" class="p-5">
                        <?php if (isset($error)) { ?>
                            <p class="font-bold text-red-500"><?php echo $error; ?></p>
                        <?php }
                        ?>
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Jouw email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="voorbeeld@email.com" required>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Klantnummer</label>
                            <input type="password" name="klantnummer" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="klantnummer" required>
                        </div>
                        <button type="submit" name="login" class="knop font-semibold rounded-lg px-3 py-1 lg:px-5 text-base text-white">Login</button>
                    </form>

                </div>
            </div>
        </div>
        <?php include 'layout/footer.php'; ?>