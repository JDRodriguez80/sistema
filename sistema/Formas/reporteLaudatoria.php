<?php
require '../FPDF/fpdf.php';
session_start();
require "../../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$idLaudatoria = $_GET['id'];

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

$querry = $con->prepare("SELECT laudatorias.idLaudatoria, laudatorias.fecha, laudatorias.motivo, laudatorias.idPersonal, personal.nombres,
personal.primApellido, personal.segApellido FROM laudatorias inner join personal on laudatorias.idPersonal = personal.idPersonal WHERE idLaudatoria=:id");
$querry->bindParam(':id', $idLaudatoria);
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos as $valores) {
    $idLaudatoria = $valores['idLaudatoria'];
    $fechaOf = $valores['fecha'];
    $cuerpoOf = $valores['motivo'];
    $idPersonal = $valores['idPersonal'];
    $nombres = $valores['nombres'];
    $primApellido = $valores['primApellido'];
    $segApellido = $valores['segApellido'];
    $destinatarioOf = $nombres . ' ' . $primApellido . ' ' . $segApellido;
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
setlocale(LC_TIME, "es_MX");
$date = date_create($fechaOf);
$fechaForm = date_format($date, "d/m/Y");
$pdf->Cell(185, 10, 'H. Matamoros Tamps. a: ' . $fechaForm, 0, 1, 'R');
$pdf->Cell(165, 10, 'Acta No.', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(18, 10, '2023 / '  . $idLaudatoria, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(10, 10, $destinatarioOf, 0, 1, 'L');
$pdf->Cell(10, 5, 'Presente', 0, 1, 'L');
$pdf->SetFont('Arial', '', 14);
$cuerpo = iconv('UTF-8', 'windows-1252', 'El centro de atención múltiple “Prof. Nicasio Zúñiga Huerta”, perteneciente a la zona escolar 09 de educación especial tiene el placer de otorgar la presente');
$cuerpo2 = iconv('UTF-8', 'windows-1252', $cuerpoOf);
$cuerpo3 = iconv('UTF-8', 'windows-1252', 'Exhortandole a continuar con el compromiso y responsabilidad que le caracterizan en beneficio de esta institución. ');
$cuerpo4 = iconv('UTF-8', 'windows-1252', 'Lic. Martha Genoveva Jiménez Limón ');
$cuerpo5 = iconv('UTF-8', 'windows-1252', 'Directora');
$cuerpo6 = iconv('UTF-8', 'windows-1252', 'NOTA LAUDATORIA ');
$pdf->SetXY(6, 100);
$pdf->MultiCell(0, 5, $cuerpo, 0, 'C');
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetXY(6, 120);
$pdf->Image('../img/glifoiz.png', 38, 122, 30);
$pdf->MultiCell(0, 15, $cuerpo6, 0, 'C');
$pdf->Image('../img/glifoder.png', 135, 122, 30);
$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(0, 5, 'Por : ', 0, 'C');
$pdf->SetFont('Arial', 'B', 15);
$pdf->SetXY(6, 150);
$pdf->MultiCell(0, 5, $cuerpo2, 0, 'C');
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(6, -100);
$pdf->MultiCell(0, 5, $cuerpo3, 0, 'C');
$pdf->Image('../img/firma-mta.png', 95, 225, 20);
$pdf->SetXY(6, -50);
$pdf->MultiCell(0, 5, $cuerpo4, 0, 'C');
$pdf->MultiCell(0, 5, $cuerpo5, 0, 'C');



$pdf->Output();
