<?php
require '../FPDF/fpdf.php';
session_start();
require "../../conexion.php";
$conn = new Database();
$con = $conn->conectar();
//debug
//$oficioId = 1;
$oficioId = $_GET['id'];

class PDF extends FPDF
{
    function Header()
    {
        $this->AddLink('');
        $this->Image('../img/logo.jpg', 8, 8, 20);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(80);
        (string)$name = iconv('UTF-8', 'windows-1252', 'Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"');
        $this->Cell(25, 10, $name, 0, 1, 'C');
        $this->Ln(10);
    }
    function Footer()
    {
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $leyenda = iconv('UTF-8', 'windows-1252', 'Este documento no es válido sin el sello correspondiente');
        $this->Cell(5, 10, $leyenda, 0, 0, 'L');
        $this->SetFont('Arial', 'I', 10);
        $pagEncode = iconv('UTF-8', 'windows-1252', 'Página ');
        $this->Cell(0, 10, $pagEncode  . $this->PageNo() . '  de  {nb}', 0, 0, 'R');
    }
}

$querry = $con->prepare("SELECT * FROM oficios WHERE idOficio=:id");
$querry->bindParam(':id', $oficioId);
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos as $valores) {
    $fechaOf = $valores['fecha'];
    $asuntoOf = $valores['asunto'];
    $destinatarioOf = $valores['destinatario'];
    $cargoOf = $valores['cargo'];
    $dependenciaOf = $valores['dependencia'];
    $cuerpoOf = $valores['cuerpo'];
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
setlocale(LC_TIME, "es_MX");
$date = date_create($fechaOf);
$fechaForm = date_format($date, "d/m/Y");
$pdf->Cell(185, 10, 'H. Matamoros Tamps. a: ' . $fechaForm, 0, 1, 'R');
$pdf->Cell(165, 10, 'Oficio No.', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(18, 10, '2023 / '  . $oficioId, 0, 1, 'R');
$asunto = iconv('UTF-8', 'windows-1252', $asuntoOf);
$pdf->Cell(185, 10, 'Asunto: ' . $asunto, 0, 1, 'R');

$pdf->Cell(10, 5, $destinatarioOf, 0, 1, 'L');
$pdf->Cell(10, 5, $cargoOf, 0, 1, 'L');
$pdf->Cell(10, 5, $dependenciaOf, 0, 1, 'L');
$pdf->Cell(10, 5, 'Presente', 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);
$cuerpo = iconv('UTF-8', 'windows-1252', 'La que subscribe Lic. Martha Genoveva Jiménez Limón, directora del centro de atención múltiple “Prof. Nicasio Zúñiga Huerta”, perteneciente a la zona escolar 09 de educación especial ');
$cuerpo2 = iconv('UTF-8', 'windows-1252', $cuerpoOf);
$cuerpo3 = iconv('UTF-8', 'windows-1252', 'Agradeciendo de antemano su valiosa cooperación, reciba un cordial saludo ');
$cuerpo4 = iconv('UTF-8', 'windows-1252', 'Lic. Martha Genoveva Jiménez Limón ');
$cuerpo5 = iconv('UTF-8', 'windows-1252', 'Directora');
$pdf->SetXY(6, 100);
$pdf->MultiCell(0, 5, $cuerpo, 0, 'J');
$pdf->SetXY(6, 110);
$pdf->MultiCell(0, 5, $cuerpo2, 0, 'J');
$pdf->SetXY(6, -80);
$pdf->MultiCell(0, 5, $cuerpo3, 0, 'C');
$pdf->Image('../img/firma-mta.png', 95, 225, 20);
$pdf->SetXY(6, -50);
$pdf->MultiCell(0, 5, $cuerpo4, 0, 'C');
$pdf->MultiCell(0, 5, $cuerpo5, 0, 'C');

$pdf->Output();
