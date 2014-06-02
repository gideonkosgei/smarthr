<?php require_once(LIB_PATH.DS.'fpdf.php');?>

<?php

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('pdf_logo.jpg',10,6,190);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
	$this->Ln(18);
    $this->Cell(0,10,'SMARTHR LEAVE APPLICATION REPORTS',0,1,'C');
    // Line break
    $this->Ln(5);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	$this->Cell(0,10,date('l jS\,F Y'),0,1,'R');
	
}
}

// Instanciation of inherited class
/*
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,1,1,'A');
$pdf->Output();
*/
?>