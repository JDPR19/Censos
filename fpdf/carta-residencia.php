<?php
require('./fpdf.php');

// Recuperar datos de la URL
$nombre_completo = urldecode($_GET['nombre_completo']);
$nacionalidad = urldecode($_GET['nacionalidad']);
$cedula = urldecode($_GET['cedula']);
$tiempo_habitado = urldecode($_GET['tiempo_habitado']);
$direccion = urldecode($_GET['direccion']);
$fecha = urldecode($_GET['fecha']);

// Configurar el mes en español
$meses = array(
    'January' => 'Enero',
    'February' => 'Febrero',
    'March' => 'Marzo',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Junio',
    'July' => 'Julio',
    'August' => 'Agosto',
    'September' => 'Septiembre',
    'October' => 'Octubre',
    'November' => 'Noviembre',
    'December' => 'Diciembre'
);

// Obtener el mes en español
$mes = $meses[date('F', strtotime($fecha))];

// Generar el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(30, 0, 30);

// Agregar logo
$pdf->Image('../images/4.jpeg', 20, 20, 40);
$pdf->Image('../images/5.png', 155, 18, 35);
$pdf->SetFont('Arial', '', 9);

// Encabezado
$pdf->Ln(20); // Añadir un espacio debajo del logo
$pdf->MultiCell(0, 4, utf8_decode("República Bolivariana de Venezuela\nMinisterio del Poder Popular para las Comunas\nConsejo Comunal \"Unidos por San José\"\nIndependencia Estado Yaracuy\nRif: C-29926466-0"), 0, 'C');
$pdf->Ln(12);

$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, utf8_decode('CONSTANCIA DE RESIDENCIA'), 0, 1, 'C');
$pdf->Ln(12);

// Contenido
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 5, utf8_decode("          Nosotros los abajo firmantes, venezolanos, mayores de edad, e integrantes del Consejo Comunal \"Unidos Por San José\" del Municipio Independencia del Estado Yaracuy, por medio de la presente hacemos constar que el Ciudadano(a): __ $nombre_completo __ de nacionalidad: __ $nacionalidad __, titular de la Cédula de Identidad: __ $cedula __, reside en la Urbanización San José desde hace _ $tiempo_habitado _ años en la siguiente dirección: _ $direccion _.\n\nMotivo de la solicitud: ___________________________\n\nConstancia que se emite a solicitud de la parte interesada a los _" . date('d', strtotime($fecha)) . "_ días del mes de _" . $mes . "_ del año _" . date('Y', strtotime($fecha)) . "_.\n\n"), 0, 'L');
$pdf->Ln(6);

$pdf->MultiCell(0, 5, utf8_decode("Atentamente:\nConsejo Comunal \"Unidos por San José\"\n\n"), 0, 'C');
$pdf->Ln(6);

// Firmas
$pdf->MultiCell(0, 5, utf8_decode("__________________________                                             __________________________"), 0, 'C');
$pdf->MultiCell(0, 5, utf8_decode("Héctor Ramírez                                                                         Jaimina Rodríguez"), 0, 'C');
$pdf->MultiCell(0, 5, utf8_decode("C.I: 5222856                                                                                C.I: 10861757"), 0, 'C');
$pdf->Cell(0, 5, utf8_decode("Vocero Ppal. Comisión Electoral                                               Vocera Ppal. Comisión Electoral"), 0, 'C');
$pdf->Ln(20);

$pdf->MultiCell(0, 5, utf8_decode("__________________________                                             __________________________"), 0, 'C');
$pdf->MultiCell(0, 5, utf8_decode("Deisy Pérez                                                                          Vocero de calle"), 0, 'C');
$pdf->MultiCell(0, 5, utf8_decode("               C.I: 7906080"), 0, 'L');
$pdf->Cell(0, 5, utf8_decode("Vocera Ppal. Comisión Electoral"), 0, 'C');
$pdf->Ln(30);

// Información adicional del Consejo Comunal
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, utf8_decode("Consejo Comunal \"Unidos por San José\" del Municipio Independencia\nDirección Calle 5 Aldea Universitaria. Urbanización San José. Municipio Independencia del Estado Yaracuy\nCorreo Electrónico: ccomunal2022@gmail.com"), 0, 'C');
$pdf->Ln(10);

// Salida del PDF
$pdf->Output('I', 'Solicitud.pdf'); 

?>
