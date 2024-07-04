<?php
include '../fpdf/fpdf.php';
include 'connection.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,utf8_decode('EXPO Ayolas 2024'),0,1,'C');
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode('Lista Completa de Usuarios'),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',10);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function BasicTable($header, $data) {
        $this->SetFont('Arial','B',12);
        foreach($header as $col) {
            $this->Cell(30,7,utf8_decode($col),1);
        }
        $this->Ln();
        $this->SetFont('Arial','',12);
        foreach($data as $row) {
            foreach($row as $col) {
                $this->Cell(30,6,utf8_decode($col),1);
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF('L', 'mm', 'A4'); // 'L' stands for Landscape orientation
$pdf->AliasNbPages();
$pdf->AddPage();

$header = array('ID', 'CI', 'Nombre', 'Apellido', 'Tel', 'Categ', 'Comentarios', 'Estado de Pago');
$data = [];

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $data[] = array(
        $row['id'], 
        $row['id_card'], 
        $row['name'], 
        $row['surname'], 
        $row['phone'], 
        $row['category'], 
        $row['category_comment'], 
        $row['payment_status']
    );
}

$pdf->BasicTable($header, $data);
$pdf->Output();
$conn->close();
?>
