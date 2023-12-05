<?php 
// cleared de post van verschillende pagina's
if(isset($_POST['clearklant']))
{
    unset($_POST['voornaam']);
    unset($_POST['achternaam']);
    unset($_POST['bedrijf']);
    unset($_POST['clearklant']);
header('location: ../data/klanten.php?page=1');
}
if(isset($_POST['clearbestel']))
{
    header('location: ../data/bestellingen.php?page=1');
}
if(isset($_POST['clearprofiel']))
{
    $id =$_POST['profielid'];
    header('location: ../detail/profiel.php?id=' . $id );
}
if(isset($_POST['clearadmin']))
{
header('location: ../detail/profieladmin.php');
}
if(isset($_POST['clearaanbieding']))
{
header('location: ../data/aanbiedingen.php?page=1');
}
if(isset($_POST['clearshowcase']))
{
header('location: ../showcase.php?page=1');
}
?>