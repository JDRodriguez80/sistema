<?php
require '../FPDF/fpdf.php';
session_start();
require "../../conexion.php";
$conn = new Database();
$con = $conn->conectar();
//debug
$idAlumno = $_GET['id'];
$idGrupo = $_GET['grupo'];
//$oficioId = $_GET['id'];

class PDF extends FPDF
{
    function Header()
    {
        $this->AddLink('');
        $this->Image('../img/logoCal.png', 60, 5, 90, 20);
        $this->SetFont('Arial', 'B', 14);
        /*  $this->Cell(80);
        (string)$name = iconv('UTF-8', 'windows-1252', 'Centro de Atención Múltiple "Prof. Nicasio Zúñiga Huerta"');
        $this->Cell(25, 10, $name, 0, 1, 'C'); */
        $this->Ln(10);
    }
    function Footer()
    {
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 0, 0);
        $leyenda = iconv('UTF-8', 'windows-1252', 'Este documento no es válido sin el sello correspondiente');
        $this->Cell(5, 10, $leyenda, 0, 0, 'L');
        $this->SetFont('Arial', 'I', 10);
        $pagEncode = iconv('UTF-8', 'windows-1252', 'Página ');
        $this->Cell(0, 10, $pagEncode  . $this->PageNo() . '  de  {nb}', 0, 0, 'R');
    }
}

$querry = $con->prepare("SELECT * FROM alumnos INNER JOIN evaluaciones ON alumnos.`idAlumno`= evaluaciones.`idAlumno` WHERE alumnos.`idAlumno`= :idAlumno");
$querry->bindParam(':idAlumno', $idAlumno);
$querry->execute();
$datos = $querry->fetch(PDO::FETCH_ASSOC);
//imprimiendo datos de la calificacion 
$nombres = $datos['nombre'] . " " . $datos['primApellido'] . " " . $datos['segApellido'];
$querry = $con->prepare("SELECT * FROM grupo WHERE idGrupo=$datos[idGrupo]");
$querry->execute();
$datosGrupo = $querry->fetch(PDO::FETCH_ASSOC);



$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 14);
setlocale(LC_TIME, "es_MX");
$pdf->Cell(185, 10, 'SISTEMA EDUCATIVO NACIONAL', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'BOLETA DE EVALUACION', 0, 1, 'C');
$pdf->Cell(125, 10, 'EDUCACION PRIMARIA', 0, 0, 'C');
$pdf->Cell(10, 10, 'CICLO ESCOLAR 2022-2023', 0, 1, 'C');
$pdf->SetFont('Arial', 'U', 14);
$pdf->Cell(10, 10, 'DATOS DEL ALUMNO(A): ' . $nombres, 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(10, 10, 'GRADO: ' . $datosGrupo['grupo'], 0, 1, 'L');
$pdf->Line(10, 68, 200, 68);
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(82, 86, 89);
$pdf->Cell(60, 10, 'MATERIA ', 1, 0, 'C', 1);
$pdf->Cell(30, 10, '1er PERIODO', 1, 0, 'C', 1);
$pdf->Cell(30, 10, '2do PERIODO', 1, 0, 'C', 1);
$pdf->Cell(30, 10, '3er PERIODO', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'PROMEDIO', 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
//$pdf->SetFillColor(255, 255, 255);
//llenando tabla

$pdf->SetDrawColor(0, 0, 60);
$pdf->SetFont('Arial', '', 10);
(string)$esp = iconv('UTF-8', 'windows-1252', 'ESPAÑOL');
$pdf->Cell(60, 10, $esp, 1, 0, 'C');
$pdf->Cell(30, 10, $datos['esp1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['esp2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['esp3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['esProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'MATEMATICAS', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['mat1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['mat2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['mat3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['matProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'LEN. EXT', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['ext1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['ext2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['ext3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['extProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'C. NAT.', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['nat1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['nat2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['nat3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['natProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'HISTORIA', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['his1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['his2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['his3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['hisProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'CIV. Y ET.', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['civ1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['civ2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['civ3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['civProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'ARTES', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['art1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['art2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['art3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['artProm'], 1, 1, 'C');
$pdf->Cell(60, 10, 'ED. FISICA', 1, 0, 'C');
$pdf->Cell(30, 10, $datos['fis1'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['fis2'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['fis3'], 1, 0, 'C');
$pdf->Cell(30, 10, $datos['fisProm'], 1, 1, 'C');



$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(82, 86, 89);
$pdf->Cell(150, 10, 'PROMEDIO FINAL', 1, 0, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
//$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 10, $datos['finProm'], 1, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetTextColor(250, 36, 25);
$pdf->Ln(30);
$pdf->Cell(0, 10, 'BOLETA PROVISIONAL SIN VALIDEZ OFICIAL ', 0, 1, 'C');














$pdf->Output();
