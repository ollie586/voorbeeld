<?php
// start session
session_start();
//website
//klantkaart.dpcsolutions.nl

// db site
// http://83.137.145.19:8880/phpmyadmin/
// db site user
// Klanten-Kaart_dPC_
// db site www
// &fv3.Yg>w#2f7jF91.R

// ftp filezilla
// host
// 83.137.145.19
// gebruiker
// klanten-kaart_dpc_
// www
// 4y75gB&Kg+w9?
function db()
{
    // Create connection
    $conn = new mysqli("localhost", "Klanten-Kaart_dPC_", "&fv3.Yg>w#2f7jF91.R", "_dpc_Klant-Kaart_12524");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //   echo "Connected successfully";
    return $conn;
}

// functie om in te loggen
function login($email, $ww)
{
    if (isset($_POST['login'])) {
        $error = NULL;
        //voorkomt sql injecties
        $email = stripslashes($email);
        $ww = stripslashes($ww);
        $email = mysqli_real_escape_string(db(), $email);
        $ww = mysqli_real_escape_string(db(), $ww);
        //set de query en voert hem uit
        $sql = "SELECT * FROM gebruikers WHERE email='$email' AND ww='$ww'";
        $result = db()->query($sql);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                    if ($data['actief'] == 'actief') {
                        $_SESSION['inlog'] = true;
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['rol'] = $data['rol'];
                        header("Location: pages/index.php");
                        die();
                    }
                    $error = 'Uw account staat momenteel uit';
                    return $error;
            }
        } else {
            $error = 'Wachtwoord of email is niet correct';
            return $error;
        }
    }
}

//functie om de resultaten van alle aanbiedingen te filteren zodra je ingelogt bent
function zoekaanbieding($kortingmin, $kortingmax, $puntenmin, $puntenmax, $categorie, $actief)
{
    $sql = "SELECT * FROM aanbieding";
    //korting
    if ($kortingmax != null) {
        //korting-punten
        if ($kortingmax != null) {
            $sql = $sql . " WHERE prijs BETWEEN $kortingmin AND $kortingmax AND punten BETWEEN $puntenmin AND $puntenmax";
            //categorie
            if ($categorie != null) {
                $sql = $sql . " AND categorie = '$categorie'";
                //categorie-actief
                if ($actief != null) {
                    $sql = $sql . " AND actief = '$actief'";
                }
            }
            //actief
            elseif ($actief != null) {
                $sql = $sql . " AND actief = '$actief'";
            }
        }
    }
    return $sql . " ORDER BY id DESC";
}

// functie om de resultaten van alle aanbiedingen voor inloggen te zoeken
function zoekaanbiedinguitlog($kortingmin, $kortingmax, $puntenmin, $puntenmax, $categorie)
{
    $sql = "SELECT * FROM aanbieding";
    //korting
    if ($kortingmax != null) {
        //korting-punten
        if ($kortingmax != null) {
            $sql = $sql . " WHERE prijs BETWEEN $kortingmin AND $kortingmax AND punten BETWEEN $puntenmin AND $puntenmax";
            //categorie
            if ($categorie != null) {
                $sql = $sql . " AND categorie = '$categorie'";
            }
        }
    }
    return $sql . " ORDER BY id DESC";
}

//functie om de resultaten bij alle bonnen te filteren
function zoekaanbiedingproduct($orgineelmin, $orgineelmax, $product, $productid)
{
    $sql = "SELECT * FROM product WHERE id = $productid";
    //orginele prijs
    if ($orgineelmin != null && $orgineelmax != null) {
        //orginele prijs-product
        $sql = $sql . " AND prijs BETWEEN $orgineelmin AND $orgineelmax";
        if ($product != NULL) {
            $sql = $sql . " AND naam LIKE '%$product%'";
        }
    }
    return $sql;
}

//functie om de resultaten van alle bonnen te filteren
function zoekbon($bonid, $gebruikt, $id)
{
    $sql = "SELECT * FROM bestelling";
    //bonid
    if ($bonid != null) {
        if ($_SESSION['rol'] == 1) {
            $sql = $sql . " WHERE id = '$bonid'";
            //gebruikt admin
            if ($gebruikt != null) {
                $sql = $sql . " AND gebruikt = '$gebruikt'";
            }
        } elseif ($_SESSION['rol'] == 0) {
            $id = $_SESSION['id'];
            $sql = $sql . " WHERE gebruikerid = $id AND id = '$bonid'";
            //gebruikt klant
            if ($gebruikt != null) {
                $sql = $sql . " AND gebruikt = '$gebruikt'";
            }
        }
    }
    //gebruikt
    elseif ($gebruikt != null) {
        if ($_SESSION['rol'] == 1) {
            $sql = $sql . " WHERE gebruikt = '$gebruikt'";
            //bonid admin
            if ($bonid != null) {
                $sql = $sql . " AND id = '$bonid'";
            }
        } elseif ($_SESSION['rol'] == 0) {
            $id = $_SESSION['id'];
            $sql = $sql . " WHERE gebruikerid = $id AND gebruikt = '$gebruikt'";
            //bonid klant
            if ($bonid != null) {
                $sql = $sql . " AND id = '$bonid'";
            }
        }
    }
    return $sql . " ORDER BY datum DESC";
}

//functie om resultaten van alle bestellingen te filteren op de profiel pagina
function zoekbonprofiel($bonid, $gebruikt, $profielid)
{
    $sql = "SELECT * FROM bestelling WHERE gebruikerid = $profielid";
    //bonid
    if ($bonid != null) {
        $sql = $sql . " AND id = '$bonid'";
        //bonid-gebruikt admin
        if ($gebruikt != null) {
            $sql = $sql . " AND gebruikt = '$gebruikt'";
        }
    }
    //gebruikt
    elseif ($gebruikt != null) {
        $sql = $sql . " AND gebruikt = '$gebruikt'";
        //gebruikt-bonid admin
        if ($bonid != null) {
            $sql = $sql . " AND id = '$bonid'";
        }
    }
    return $sql . " ORDER BY datum DESC LIMIT 6";
}

//functie om resultaten op de admin profiel pagina te filteren
function zoekbonadmin($bonid, $gebruikt)
{
    $sql = "SELECT * FROM bestelling";
    //bonid
    if ($bonid != null) {
        $sql = $sql . " WHERE id = '$bonid'";
        //bonid-gebruikt admin
        if ($gebruikt != null) {
            $sql = $sql . " AND gebruikt = '$gebruikt'";
        }
    }
    //gebruikt
    elseif ($gebruikt != null) {
        $sql = $sql . " WHERE gebruikt = '$gebruikt'";
        //gebruikt-bonid admin
        if ($bonid != null) {
            $sql = $sql . " AND id = '$bonid'";
        }
    }
    return $sql . " ORDER BY datum DESC LIMIT 6";
}

//functie om de resultaten van alle klanten te filteren
function zoekklant($actief, $voornaam, $achternaam, $bedrijf)
{
    $sql = "SELECT * FROM gebruikers WHERE";
    //voornaam
    if ($voornaam != NULL) {
        $sql = $sql . " voornaam LIKE '%$voornaam%'";
        //voornaam-actief
        if ($actief != NULL) {
            $sql = $sql . " AND actief = '$actief'";
            //voornaam-actief-achternaam
            if ($achternaam != NULL) {
                $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
                //voornaam-actief-achternaam-bedrijf
                if ($bedrijf  != NULL) {
                    $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
                }
            }
            //voornaam-actief-bedrijf
            elseif ($bedrijf  != NULL) {
                $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
                //voornaam-actief-bedrijf-achternaam
                if ($achternaam != NULL) {
                    $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
                }
            }
        }
        //voornaam-achternaam
        elseif ($achternaam != NULL) {
            $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
            //voornaam-achternaam-actief
            if ($actief != NULL) {
                $sql = $sql . " AND actief = '$actief'";
                //voornaam-achternaam-actief-bedrijf
                if ($bedrijf  != NULL) {
                    $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
                }
            }
            //voornaam-achternaam-bedrijf
            elseif ($bedrijf  != NULL) {
                $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
                //voornaam-achternaam-bedrijf-actief
                if ($actief != NULL) {
                    $sql = $sql . " AND actief = '$actief'";
                }
            }
        }
        //voornaam-bedrijf
        elseif ($bedrijf  != NULL) {
            $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
            //voornaam-bedrijf-actief
            if ($actief != NULL) {
                $sql = $sql . " AND actief = '$actief'";
                //voornaam-bedrijf-actief-achternaam
                if ($achternaam != NULL) {
                    $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
                }
            }
            //voornaam-bedrijf-achternaam
            elseif ($achternaam != NULL) {
                $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
                //voornaam-bedrijf-achternaam-actief
                if ($actief != NULL) {
                    $sql = $sql . " AND actief = '$actief'";
                }
            }
        }
    }
    //achternaam
    elseif ($achternaam != NULL) {
        $sql = $sql . " achternaam LIKE '%$achternaam%'";
        //achternaam-actief
        if ($actief != NULL) {
            $sql = $sql . " AND actief = '$actief'";
            //achternaam-actief-bedrijf
            if ($bedrijf  != NULL) {
                $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
            }
        }
        //achternaam-bedrijf
        elseif ($bedrijf  != NULL) {
            $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
            //achternaam-bedrijf-actief
            if ($actief != NULL) {
                $sql = $sql . " AND actief = '$actief'";
            }
        }
    }
    //bedrijf
    elseif ($bedrijf  != NULL) {
        $sql = $sql . " bedrijf LIKE '%$bedrijf%'";
        //bedrijf-actief
        if ($actief != NULL) {
            $sql = $sql . " AND actief = '$actief'";
            //bedrijf-actief-achternaam
            if ($achternaam != NULL) {
                $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
            }
        }
        //bedrijf-achternaam
        elseif ($achternaam != NULL) {
            $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
            //bedrijf-achternaam-actief
            if ($actief != NULL) {
                $sql = $sql . " AND actief = '$actief'";
            }
        }
    }
    //actief
    elseif ($actief != NULL) {
        $sql = $sql . " actief='$actief'";
    }
    return $sql;
}