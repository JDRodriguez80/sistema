<?php 
    require '../FPDF/fpdf.php';

    $pdf=new FPDF();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(50,10,'Mensaje de prueba',0,0,'c');
    $pdf->Output();
?>