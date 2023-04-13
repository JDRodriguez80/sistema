<?php
session_start();
require 'fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('img/image.png', 5, 5, 30 );
        $this->SetFont('Arial','',15);
        $this->Cell(30);
        $this->Cell(120,10, 'Centro de Atencíon Múltiple',0,0,'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I', 8);
        $this->Cell(0,10, 'Página '.$this->PageNo().'/{nb}',0,0,'C' );
    }
}
?>