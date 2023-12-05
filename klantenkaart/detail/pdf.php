<?php
require('../src/fpdf/fpdf.php');
$id = $_POST['id'];
$naam = $_POST['naam'];
$bedrijf = $_POST['bedrijf'];
$datum = $_POST['datum'];
$product = $_POST['product'];
$prijs = $_POST['prijs'];
$punten = $_POST['punten'];
class PDF extends FPDF{}
// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetTitle('dPCSolutions-aanbieding-' . $id);
define('EURO',chr(128));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
$pdf->cell(10, 10, '',0,0,'');
$pdf->cell(168, 250, '',1,0,'');
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 190);

$pdf->cell(10, 10, 'Voucher',0,0,'');
$pdf->Image('../images/header_logo.png',80,10,100);

$pdf->SetFont('Arial','B',10);
$pdf->SetY($pdf->GetY() + 25);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, 'dPCSolutions Zelhem',0,0,'');
$pdf->SetX($pdf->GetX() - 150);
$pdf->SetFont('Arial','',10);
$pdf->cell(10, 10, 'Klant: ' . $bedrijf . ' (' . $naam . ')',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, 'Smidsstraat 1',0,0,'');
$pdf->SetX($pdf->GetX() - 150);
$pdf->SetFont('Arial','',10);
$pdf->cell(10, 10, 'Bonnummer: ' . $id  ,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, '7021 AB Zelhem',0,0,'');
$pdf->SetX($pdf->GetX() - 150);
$pdf->SetFont('Arial','',10);
$pdf->cell(10, 10, 'Bestel datum: ' . $datum,0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetY($pdf->GetY() + 10);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, 'dPCSolutions Ruurlo',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, 'zuivelweg 9',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 190);
$pdf->cell(10, 10, '7261 BA Ruurlo',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetY($pdf->GetY() + 20);
$pdf->SetX($pdf->GetX() - 190);
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->cell(110, 10, 'Product',1,0,'',true);
$pdf->SetX($pdf->GetX() - 20);
$pdf->cell(30, 10, 'Nieuwe prijs',1,0,'',true);
$pdf->cell(30, 10, 'Aantal Punten',1,0,'',true);

$pdf->SetY($pdf->GetY() + 10);
$pdf->SetX($pdf->GetX() - 190);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10);
$pdf->cell(90, 10, $product,1,0,'');
$pdf->cell(30, 10, EURO . ' ' . number_format($prijs, 2),1,0,'');
$pdf->cell(30, 10, $punten,1,0,'');

$pdf->SetY($pdf->GetY() + 160);
$pdf->SetFont('Arial','',10);
$pdf->cell(5, 10, '',0,0,'');
$pdf->cell(10, 10, "Op al onze aanbiedingen en overeenkomsten zijn de algemene voorwaarden ICT Waarborg van toepassing.",0,0,'');
$pdf->SetY($pdf->GetY() + 5);
$pdf->cell(60, 10, '',0,0,'');
$pdf->cell(10, 10, 'Deze vindt u op www.dpcsolutions.nl',0,0,'');
$pdfTitle = 'dPCSolutions-aanbieding-' . $id. '.pdf';
if(isset($_POST['kijk'])){
    $pdf->Output();
}
if(isset($_POST['download'])){
    $pdf->Output( 'D', $pdfTitle, true );
}
?>