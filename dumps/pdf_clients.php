<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Europe/Paris");
$today = date("d/m/y");

require('fpdf.php');

class PDF extends FPDF
{
// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau amélioré
function ImprovedTable($header, $data)
{
    //Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(90,174,209);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //En-tête
    $w=array(40,75,75);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Données
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}

}

$pdf = new PDF();

// Titres des colonnes
$header = array('Code', 'Nom', 'Prenom');

// Chargement des données
$data = $pdf->LoadData('dump_clients.txt');

$pdf->SetFont('Arial','',14);

$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
// $pdf->Image('main.png',100,15,35,35);
$pdf->Text(10, 7, "Clients ".$today);

$w=$pdf->GetStringWidth('');
$pdf->SetX((210-$w)/2);
$pdf->Cell(0,10,utf8_decode(''),41,1);
$pdf->SetFont('Times','B',12);

$w=$pdf->GetStringWidth('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$pdf->SetX((210-$w)/2);
$pdf->Cell(0,10,utf8_decode('Base de données - AV Menuiseries'),41,1);
$pdf->SetFont('Times','B',12);

$pdf->Output();
?>