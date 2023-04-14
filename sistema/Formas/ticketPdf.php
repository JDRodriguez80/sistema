<?php
require '../FPDF/fpdf.php';
session_start();
require "../../conexion.php";
$conn = new Database();
$con = $conn->conectar();

$idPago = $_GET['id'];
$querry = $con->prepare("SELECT * FROM pagos inner join alumnos on pagos.idAlumno = alumnos.idAlumno inner join tipoPago on pagos.idTipoPago = tipoPago.idTipoPago INNER join personal on pagos.idPersonal=personal.idPersonal where pagos.idPago = $idPago");
$querry->execute();
$datos = $querry->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF
{
    function Header()
    {
        $this->AddLink('');
        $this->Image('../img/logo.jpg', 2, 3, 10, 8);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20);
        (string)$name = iconv('UTF-8', 'windows-1252', 'Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"');
        $this->Cell(30, -3, $name, 0, 1, 'C');
        $this->Line(2, 12, 80, 12);
    }
    function Footer()
    {
        $this->SetY(-2);
        $this->SetFont('Arial', 'B', 8);
        $leyenda = iconv('UTF-8', 'windows-1252', 'Gracias por su pago');
        $this->Cell(20);
        $this->Cell(20, -6, $leyenda, 0, 1, 'C');
        $this->Line(2, 110, 80, 110);
    }
}



$pdf = new PDF();
$pdf->AddPage('P', [80, 120], 0);
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 10);
setlocale(LC_TIME, "es_MX");
$date = date_create($datos[0]['fechaPago']);
$fechaForm = date_format($date, "d/m/Y");
$pdf->Cell(60, 15, 'H. Matamoros Tamps. a: ' . $fechaForm, 0, 1, 'C');
$pdf->Cell(60, 5, 'Comp. Pago No.', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(20, 5, $datos[0]['idPago'], 0, 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(5, 5, 'Alumno:', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 10);
(string)$name = iconv('UTF-8', 'windows-1252', 'Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"');
$nombre = $datos[0]['nombre'] . " " . $datos[0]['primApellido'] . " " . $datos[0]['segApellido'];
(string)$nameFix = iconv('UTF-8', 'windows-1252', $nombre);
$pdf->Cell(20, 5, $nameFix, 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(8, 5, 'Concepto:', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 10);
(string)$nombrePago = iconv('UTF-8', 'windows-1252', $datos[0]['nombrePago']);
$pdf->Cell(20, 5, $nombrePago, 0, 1, 'L');
$pdf->Cell(5, 5, 'Importe:', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(20, 5, "$" . $datos[0]['abono'], 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 5, 'Saldo:', 0, 0, 'R');
$pdf->SetTextColor(213, 0, 4);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(20, 5, "$" . $datos[0]['resto'], 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(6, 40, 'Recibio:', 0, 0, 'R');
$pdf->SetFont('Arial', 'I', 10);
(string)$nomPersonal = iconv('UTF-8', 'windows-1252', $datos[0]['nombres'] . " " . $datos[0]['primApellido'] . " " . $datos[0]['segApellido']);

$pdf->Cell(5, 40, $nomPersonal, 0, 1, 'L');









$pdf->Output();
