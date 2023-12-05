<?php
include "functies.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

// if(isset($_POST['nieuwcat']))
// {
//     $categorie = $_POST['cat'];
//     $sql = "INSERT INTO categorie(naam) VALUES ('$categorie')";
//     db()->query($sql);
//     header("location: ../data/aanbiedingen.php?page=1");
// }

// maakt een bon aan als je punten besteed
if (isset($_POST['bestel'])) {
    $gebruikerid = $_POST['gebruiker'];
    $aanbiedingid = $_POST['aanbieding'];
    $punten = $_POST['punten'];
    $userpunten = $_POST['userpunten'];
    $datum = date('Y-m-d H:i:s', strtotime($_POST['datum']));
    $rest = $userpunten - $punten;
    $sql = "UPDATE gebruikers SET punten=$rest WHERE id = $gebruikerid";
    db()->query($sql);
    $sql = "INSERT INTO bestelling(aanbiedingid, gebruikerid, gebruikt, datum) VALUES ($aanbiedingid, $gebruikerid,'nee', '$datum')";
    db()->query($sql);
    header('location: ../data/bestellingen.php?page=1');
}

//maakt een nieuwe klant aan
if (isset($_GET['nieuwe_klant'])) {
    $vnaam = $_GET['vnaam'];
    $anaam = $_GET['anaam'];
    $bedrijf = $_GET['bedrijf'];
    $hnummer = $_GET['hnummer'];
    $straat = $_GET['straat'];
    $plaats = $_GET['plaats'];
    $pcode = $_GET['pcode'];
    $email = $_GET['email'];
    $klantnummer = $_GET['klantnummer'];
    $telefoon = $_GET['telefoon'];
    $sql = "INSERT INTO gebruikers(voornaam, achternaam, bedrijf, huisnummer, straat, plaats, postcode, email, ww, telefoon, punten, rol, actief) VALUES 
    ('$vnaam','$anaam','$bedrijf','$hnummer','$straat','$plaats','$pcode','$email','$klantnummer','$telefoon',50,0,'actief')";
    db()->query($sql);
    header('location: ../pages/index.php');
}

// maakt nieuwe aanbiedingen aan
if (isset($_POST['nieuweaanbieding'])) {
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $categorieproduct = $_POST['categorieproduct'];
    $merk = $_POST['merk'];
    $onderdeel = $_POST['onderdeel'];
    $fabriek = $_POST['fabriek'];
    $conditie = $_POST['conditie'];
    $omschrijving = $_POST['omschrijving'];
    $img1 = $_POST['img1'];
    $img2 = $_POST['img2'];
    $img3 = $_POST['img3'];
    $img4 = $_POST['img4'];

    $korting = $_POST['inlever'];
    $punten = $_POST['punten'];
    $kortingcategorie = $_POST['categorie'];

    $sql = "INSERT INTO product(naam, prijs, omschrijving, categorie, onderdeel, merk, fabriekscode, conditie, foto1, foto2, foto3, foto4) 
    VALUES ('$naam','$prijs','$omschrijving','$categorieproduct','$onderdeel','$merk','$fabriek','$conditie','$img1','$img2','$img3','$img4')";
    db()->query($sql);
    $sqlproduct = "SELECT * FROM product WHERE naam='$naam'";
    $result = db()->query($sqlproduct);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($data = $result->fetch_assoc()) {
            $productid = $data['id'];
            $sqlaanbieding = "INSERT INTO aanbieding(product_id, categorie, prijs, punten, actief) 
            VALUES ('$productid','$kortingcategorie','$korting','$punten','actief')";
            db()->query($sqlaanbieding);
        }
    }
    header("location: ../pages/index.php");
}

//bewerkt de aanbieding gebaseerd op jouw input
if (isset($_POST['bewerkaanbieding'])) {
    $id = $_POST['id'];
    $prijs = $_POST['inlever'];
    $punten = $_POST['punten'];
    $categorie = $_POST['categorie'];
    $sql = "UPDATE aanbieding SET categorie='$categorie', prijs=$prijs,punten=$punten WHERE id = $id";
    db()->query($sql);
    $productid = $_POST['productid'];
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $categorieproduct = $_POST['categorieproduct'];
    $merk = $_POST['merk'];
    $onderdeel = $_POST['onderdeel'];
    $fabriek = $_POST['fabriek'];
    $conditie = $_POST['conditie'];
    $omschrijving = $_POST['omschrijving'];
    $img1 = $_POST['img1'];
    $img2 = $_POST['img2'];
    $img3 = $_POST['img3'];
    $img4 = $_POST['img4'];
    $sql = "UPDATE product SET naam='$naam',prijs=$prijs,omschrijving='$omschrijving',categorie='$categorieproduct',onderdeel='$onderdeel',merk='$merk',fabriekscode='$fabriek',conditie='$conditie',
    foto1='$img1',foto2='$img2',foto3='$img3',foto4='$img4' WHERE id = $productid";
    db()->query($sql);
    if (isset($_POST['store'])) {
        header('location: ../data/aanbiedingen.php?page=1');
    }
    if (isset($_POST['detail'])) {
        header('location: ../detail/product.php?id=' . $id);
    }
}

//voor een gebruiker bewerken
if (isset($_POST['bewerkgebruiker'])) {
    $vnaam = $_POST['vnaam'];
    $anaam = $_POST['anaam'];
    $bedrijf = $_POST['bedrijf'];
    $hnummer = $_POST['hnummer'];
    $straat = $_POST['straat'];
    $plaats = $_POST['plaats'];
    $pcode = $_POST['pcode'];
    $email = $_POST['email'];
    $telefoon = $_POST['telefoon'];
    if ($_SESSION['rol'] == 1) {
        $klantnummer = $_POST['klantnummer'];
    };
    if ($_SESSION['rol'] == 1) {
        $sql = "UPDATE gebruikers SET voornaam='$vnaam', achternaam='$anaam', bedrijf='$bedrijf', huisnummer='$hnummer', straat='$straat', plaats='$plaats', postcode='$pcode', email='$email',
    telefoon='$telefoon', ww='$klantnummer' WHERE id=$id";
    } else {
        $sql = "UPDATE gebruikers SET voornaam='$vnaam', achternaam='$anaam', bedrijf='$bedrijf', huisnummer='$hnummer', straat='$straat', plaats='$plaats', postcode='$pcode', email='$email',
    telefoon='$telefoon' WHERE id=$id";
    }
    db()->query($sql);
    if (isset($_POST['klant'])) {
        header('location: ../data/klanten.php?page=1');
    }
    if (isset($_POST['profiel'])) {
        header('location: ../detail/profiel.php?id=' . $id);
    }
    if (isset($_POST['admin'])) {
        header('location: ../detail/profieladmin.php');
    }
}

// geeft punten aan een gebruiker
if (isset($_POST['geef'])) {
    $punten = $_POST['punten'];
    $punten_nu = $_POST['punten_nu'];
    $toename = $punten_nu + $punten;
    $sql = "UPDATE gebruikers SET punten=$toename WHERE id='$id'";
    db()->query($sql);
    if (isset($_POST['klant'])) {
        header('location: ../data/klanten.php?page=1');
    }
    if (isset($_POST['profiel'])) {
        header('location: ../detail/profiel.php?id=' . $id);
    }
    if (isset($_POST['admin'])) {
        header('location: ../detail/profieladmin.php');
    }
}

// neemt punten weg van een gebruiker
if (isset($_POST['neem'])) {
    $punten = $_POST['punten'];
    $punten_nu = $_POST['punten_nu'];
    $afname = $punten_nu - $punten;
    $sql = "UPDATE gebruikers SET punten=$afname WHERE id='$id'";
    db()->query($sql);
    if (isset($_POST['klant'])) {
        header('location: ../data/klanten.php?page=1');
    }
    if (isset($_POST['profiel'])) {
        header('location: ../detail/profiel.php?id=' . $id);
    }
    if (isset($_POST['admin'])) {
        header('location: ../detail/profieladmin.php');
    }
}

// voor verzilveren van bestellingen
if (isset($_POST['verzilver'])) {
    $profielid = $_POST['profielid'];
    if ($_POST['gebruikt'] == 'nee') {
        $sql = "UPDATE bestelling SET gebruikt='ja' WHERE id='$id'";
    }
    if ($_POST['gebruikt'] == 'ja') {
        $sql = "UPDATE bestelling SET gebruikt='nee' WHERE id='$id'";
    }
    db()->query($sql);
    if (isset($_POST['bestelling'])) {
        header('location: ../data/bestellingen.php?page=1');
    }
    if (isset($_POST['profiel'])) {
        header('location: ../detail/profiel.php?id=' . $profielid);
    }
    if (isset($_POST['admin'])) {
        header('location: ../detail/profieladmin.php');
    }
}

//maakt een nieuwe categorie aan
if (isset($_POST['nieuwcat'])) {
    $categorie = $_POST['cat'];
    $sql = "INSERT INTO categorie(naam, actief) VALUES ('$categorie','actief')";
    db()->query($sql);
    header('location: ../data/aanbiedingen.php?page=1');
}

//voor een categorie bewerken
if (isset($_POST['editcat'])) {
    $naam = $_POST['catnaam'];
    $sql = "UPDATE categorie SET naam='$naam' WHERE id=$id";
    db()->query($sql);
    if (isset($_POST['categorie'])) {
        header('location: ../data/aanbiedingen.php?page=1');
    }
}

// update de actief status van catogeriën
if (isset($_POST['categorie-actief'])) {
    if ($_POST['actief'] == 'actief') {
        $sql = "UPDATE categorie SET actief='inactief' WHERE id='$id'";
    }
    if ($_POST['actief'] == 'inactief') {
        $sql = "UPDATE categorie SET actief='actief' WHERE id='$id'";
    }
    db()->query($sql);
    if (isset($_POST['categorie'])) {
        header('location: ../data/aanbiedingen.php?page=1');
    }
}

// update de actief status van aanbiedingen
if (isset($_POST['aanbieding-actief'])) {
    if ($_POST['actief'] == 'actief') {
        $sql = "UPDATE aanbieding SET actief='inactief' WHERE id='$id'";
    }
    if ($_POST['actief'] == 'inactief') {
        $sql = "UPDATE aanbieding SET actief='actief' WHERE id='$id'";
    }
    db()->query($sql);
    if (isset($_POST['aanbieding'])) {
        header('location: ../data/aanbiedingen.php?page=1');
    }
    if (isset($_POST['product'])) {
        header('location: ../detail/product.php?id=' . $id);
    }
}

// update de actief status van klanten
if (isset($_POST['update-actief'])) {
    if ($_POST['actief'] == 'actief') {
        $sql = "UPDATE gebruikers SET actief='inactief' WHERE id='$id'";
    }
    if ($_POST['actief'] == 'inactief') {
        $sql = "UPDATE gebruikers SET actief='actief' WHERE id='$id'";
    }
    db()->query($sql);
    header('location: ../data/klanten.php?page=1');
}